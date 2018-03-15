<?php

use App\Services\MoneyService;
use App\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MoneyServiceTest extends TestCase
{
    use DatabaseTransactions;


    public function testTopUpSuccess()
    {
        $moneyService = new MoneyService();

        $user = new User(['name' => 'man']);
        $user->balance = 100;

        $moneyService->topUpBalance($user, 10);

        $this->assertEquals(110, $user->balance);
        $this->assertFalse($user->isDirty());
        $this->assertEquals(1, $user->transactions->count());
        $this->assertEquals(10, $user->transactions[0]->amount);
        $this->assertFalse($user->transactions[0]->isDirty());
    }

    public function testTopUpFail()
    {
        $moneyService = new MoneyService();

        $user = new User(['name' => NULL]);
        $user->balance = 100;

        $user::saving(function(){return false;});

        $moneyService->topUpBalance($user, 10);

        $this->assertNotEquals(110, $user->balance);
        $this->assertTrue($user->isDirty());
        $this->assertEquals(0, $user->transactions->count());
    }


}
