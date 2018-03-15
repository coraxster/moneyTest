<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'balance',
    ];


    public function transactions() : HasMany
    {
        return $this->hasMany(UserTransaction::class);
    }



    //  todo: use cknow/laravel-money with accessors instead simple int
    //  @link http://moneyphp.org/en/latest/index.html
//    public function setBalance(Money $balance)
//    {
//
//    }
//
//    public function getBalance() : Money
//    {
//
//    }

}
