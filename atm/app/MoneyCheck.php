<?php

namespace App;

use Cache;

class MoneyCheck
{
    /**
     * Daily maximum transfer amount
     *
     * @var float
     */
    private $maxTransfer;

    /**
     * Daily maximum withdraw amount
     *
     * @var float
     */
    private $maxWithdraw;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->maxTransfer = config('money.daily.transfer');
        $this->maxWithdraw = config('money.daily.withdraw');
    }

    public function transferRemain()
    {
        return $this->remain('transfer', $this->maxTransfer);
    }

    public function setTransferRemain(int $amount)
    {
        return $this->setRemain('transfer', $amount);
    }

    public function withdrawRemain()
    {
        return $this->remain('withdraw', $this->maxWithdraw);
    }

    public function setWithdrawRemain(int $amount)
    {
        return $this->setRemain('withdraw', $amount);
    }

    private function remain(string $prefix, float $default)
    {
        return Cache::remember(
            "daily_" . $prefix . "_remain_" . $this->user->id,
            86400, // at most a day
            function () use ($default) {
                return $default;
            }
        );
    }

    private function setRemain(string $prefix, int $amount)
    {
        Cache::put(
            "daily_" . $prefix . "_remain_" . $this->user->id,
            $amount,
            86400 // at most a day
        );
    }
}
