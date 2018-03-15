<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 15/03/2018
 * Time: 11:44
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTransaction extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount'
    ];

    protected $hidden = [
        'user_id', 'updated_at'
    ];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    //  todo: use cknow/laravel-money with accessors instead simple int
    //  @link http://moneyphp.org/en/latest/index.html
//    public function setAmount(Money $amount)
//    {
//
//    }
//
//    public function getAmount() : Money
//    {
//
//    }

}