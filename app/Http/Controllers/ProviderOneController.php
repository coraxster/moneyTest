<?php

namespace App\Http\Controllers;

use App\Services\MoneyService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProviderOneController extends Controller
{
    const DEFAULT_SALT = 123;


    public function topUpUserBalance(Request $request, MoneyService $moneyService)
    {
        $validator = $this->makeTopUpValidator($request);

        if ($validator->fails()) {
            Log::warning('ProviderOne validator fails', ['request' => $request->all()]);
            return response('<answer>0</answer>', 200)
                ->header('Content-Type', 'text/xml');
        }

        $user = User::query()->find($request->get('a'));
        $amount = (int)$request->get('b');

        $result = (int)$moneyService->topUpBalance($user, $amount);

        if ($result){
            Log::info('ProviderOne request success', ['request' => $request->all()]);
        }else{
            Log::warning('ProviderOne request fails', ['request' => $request->all()]);
        }

        return response("<answer>{$result}</answer>", 200)
            ->header('Content-Type', 'text/xml');
    }



    protected function makeTopUpValidator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'a' => 'required|integer|min:1|exists:users,id',
            'b' => 'required|integer|min:1',
            'md5' => 'required'
        ]);

        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();
            $salt = env('PROVIDER_ONE_SALT', self::DEFAULT_SALT);
            if ($data['md5'] !== md5($data['a'] . $data['b'] . $salt)){
                $validator->errors()->add('md5', 'Something is wrong with this field!');
            }
        });

        return $validator;
    }


}
