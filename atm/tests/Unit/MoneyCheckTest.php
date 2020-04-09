<?php

namespace Tests\Unit;

use Cache;
use App\User;
use App\MoneyCheck;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class MoneyCheckTest extends TestCase
{
    private $check;

    public function __construct()
    {
        parent::__construct();
    }

    public function test_set_transfer_remain()
    {
        Cache::flush();
        $user = factory(User::class)->create();
        $this->check = new MoneyCheck($user);

        $amount = random_int(0, config('money.daily.transfer'));
        $this->check->setTransferRemain($amount);
        $this->assertEquals($amount, Cache::get(
            "daily_transfer_remain_" . $user->id
        ));
    }

    /**
     * @depends test_set_transfer_remain
     */
    public function test_get_transfer_remain()
    {
        Cache::flush();
        $user = factory(User::class)->create();
        $this->check = new MoneyCheck($user);

        $amount = random_int(0, config('money.daily.transfer'));
        $res = $this->check->transferRemain();
        $this->assertEquals(config('money.daily.transfer'), $res);
        $this->check->setTransferRemain($amount);
        $res = $this->check->transferRemain();
        $this->assertEquals($amount, $res);
    }

    public function test_set_withdraw_remain()
    {
        Cache::flush();
        $user = factory(User::class)->create();
        $this->check = new MoneyCheck($user);

        $amount = random_int(0, config('money.daily.withdraw'));
        $this->check->setWithdrawRemain($amount);
        $this->assertEquals($amount, Cache::get(
            "daily_withdraw_remain_" . $user->id
        ));
    }

    /**
     * @depends test_set_withdraw_remain
     */
    public function test_get_withdraw_remain()
    {
        Cache::flush();
        $user = factory(User::class)->create();
        $this->check = new MoneyCheck($user);

        $amount = random_int(0, config('money.daily.transfer'));
        $res = $this->check->transferRemain();
        $this->assertEquals(config('money.daily.transfer'), $res);
        $this->check->setWithdrawRemain($amount);
        $res = $this->check->withdrawRemain();
        $this->assertEquals($amount, $res);
    }
}
