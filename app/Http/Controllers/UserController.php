<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function listTransactions($user_id)
    {
        $user = User::query()->findOrFail($user_id);
        return $user->transactions;
    }
}
