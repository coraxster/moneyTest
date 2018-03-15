<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 15/03/2018
 * Time: 12:11
 */

namespace App\Services;


use App\User;
use Illuminate\Support\Facades\DB;

class MoneyService
{

    public function topUpBalance(User $user, int $amount) : bool
    {
        DB::beginTransaction();

        $user->balance += $amount;
        $result = $user->save() and (bool)$user->transactions()->create(['amount' => $amount]);
        if ($result){
            DB::commit();
        }else{
            $user->balance -= $amount;
            DB::rollBack();
        }

        return $result;
    }

}
