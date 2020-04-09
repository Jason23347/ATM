<?php

namespace App;

use Cache;

class MoneyCheck
{
    /**
     * Daily Maximum amount
     *
     * @var float
     */
    private $maximum;

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
        $this->maximum = config('money.maximum');
    }

    public function transferRemain()
    {
        return $this->remain('transfer');
    }

    public function setTransferRemain(int $amount)
    {
        return $this->setRemain('transfer', $amount);
    }

    public function withdrawRemain()
    {
        return $this->remain('withdraw');
    }

    public function setWithdrawRemain(int $amount)
    {
        return $this->setRemain('withdraw', $amount);
    }

    private function remain(string $prefix)
    {
        return Cache::remember(
            "daily_" . $prefix ."_remain_" . $this->user->id,
            86400, // at most a day
            function () {
                return $this->maximum;
            });
    }

    private function setRemain(string $prefix, int $amount)
    {
        Cache::remember(
            "daily_" . $prefix ."_remain_" . $this->user->id,
            86400, // at most a day
            function () {
                return $this->$maximum - $amount;
            });
    }
}