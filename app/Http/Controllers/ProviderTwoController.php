<?php

namespace App\Http\Controllers;

use App\Services\MoneyService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class ProviderTwoController
 * @package App\Http\Controllers
 */
class ProviderTwoController extends Controller
{

    /**
     *  salt used when env('PROVIDER_TWO_SALT') is not set
     */
    const DEFAULT_SALT = 123;


    /**
     * @param Request $request
     * @param MoneyService $moneyService
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function topUpUserBalance(Request $request, MoneyService $moneyService)
    {
        $validator = $this->makeTopUpValidator($request);

        if ($validator->fails()) {
            Log::warning('ProviderOne validator fails', [
                'request' => $request->all(), 'errors' => $validator->errors()->toArray()
            ]);
            return response('ERROR', 200);
        }

        $user = User::query()->find($request->get('x'));
        $amount = (int)$request->get('y'); //todo: make Money class like @link http://moneyphp.org

        $result = (bool)$moneyService->topUpBalance($user, $amount);

        if ($result){
            Log::info('ProviderOne request success', ['request' => $request->all()]);
        }else{
            Log::warning('ProviderOne request fails', ['request' => $request->all()]);
        }
        $response = $result ? 'OK' : 'ERROR';
        return response($response, 200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    protected function makeTopUpValidator(Request $request) : \Illuminate\Validation\Validator
    {
        $validator = Validator::make($request->all(), [
            'x' => 'required|integer|min:1|exists:users,id',
            'y' => 'required|integer|min:1',
            'md5' => 'required'
        ]);

        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();
            $salt = env('PROVIDER_TWO_SALT', self::DEFAULT_SALT);
            if ($data['md5'] !== md5($data['x'] . $data['y'] . $salt)){
                $validator->errors()->add('md5', 'Something is wrong with this field!');
            }
        });

        return $validator;
    }


}
