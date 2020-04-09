<?php

namespace App;

use App\User;
use App\MoneyCheck;
use App\Models\Flow;
use App\MoneyOperation;

class MoneyRepository
{
    /**
     * User model dependency
     *
     * @var App\User
     */
    private $user;

    /**
     * Flow model dependency
     *
     * @var App\Models\Flow
     */
    private $flow;

    /**
     * MonwyCheck dependency injection
     *
     * @var App\MoneyCheck
     */
    private $check;

    /**
     * Construct
     *
     * @param Flow $flow
     */
    public function __construct(Flow $flow, MoneyCheck $check) {
        $this->flow = $flow;
        $this->check = $check;
    }

    private function parseMoney(float $amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * Bind user
     *
     * @param User $user
     *
     * @return App\MoneyRepository
     */
    public function asUser(User $user)
    {
        // FIXME check whether $user == null
        $this->user = $user;
        return $this;
    }

    /**
     * Get recent flow records
     *
     * @param integer $num
     *
     * @return array
     */
    public function getRecords(int $num = 5)
    {
        return $this->flow->where('user_id', $this->user->id)
                    ->sortBy('created_at', 'desc')
                    ->take($num)
                    ->get();
    }

    /**
     * Transfer money
     *
     * @param array $arr
     *
     * @return array
     */
    public function transfer($arr)
    {
        $amount = $this->parseMoney($arr['amount']);
        $payment = $this->user;

        // find trasfer user
        $collect = $this->user->where('card_number', $arr['card_number'])
                    ->first();
        if ($collect == null) {
            return [
                'errcode'   => 3002,
                'message'   => '收款账户不存在',
            ];
        }

        $payment->balance -= $amount;
        if ($payment->balance < 0) {
            return [
                'errcode'   => 3003,
                'message'   => '没钱不要装逼',
            ];
        }

        // FIXME set maximum balance
        $collect->balance += $amount;

        // TODO handle errors
        $payment->save();
        $collect->save();

        // record payment
        $this->flow->create([
            'amount'    => $amount,
            'type'      => MoneyOperation::type('pay'),
            'user_id'   => $payment->id,
        ]);

        // record collection
        $this->flow->create([
            'amount'    => $amount,
            'type'      => MoneyOperation::type('collect'),
            'user_id'   => $collect->id,
        ]);

        return null;
    }

    /**
     * Deposit and make a record
     *
     * @param array $arr
     *
     * @return array
     */
    public function deposit($arr)
    {
        $amount = $this->parseMoney($arr['amount']);

        // update database
        $this->user->balance -= $amount;
        $res = $this->user->save();
        if (!$res) {
            return [
                'errcode'   => 2001,
                'message'   => 'DB error',
            ];
        }

        // record deposit
        $this->flow->create([
            'amount'    => $amount,
            'type'      => MoneyOperation::type('deposit'),
            'user_id'   => $this->user->id,
        ]);
        return null;
    }

    /**
     * Withdraw and make a record
     *
     * @param array $arr
     *
     * @return array
     */
    public function withdraw($arr)
    {
        $amount = $this->parseMoney($arr['amount']);

        // check if reached daily maximum
        $remain = $this->check->withdrawRemain($this->user);
        if ($remain <= 0) {
            $money = $amount - $remain;
            return [
                'errcode'   => 3001,
                'message'   => '超出每日取款限额' . $money . '元'
            ];
        }
        // update database
        $this->user->balance -= $amount;
        $res = $this->user->save();
        if (!$res) {
            return [
                'errcode'   => 2001,
                'message'   => 'DB error',
            ];
        }

        // record withdraw
        $this->flow->create([
            'amount'    => $amount,
            'type'      => MoneyOperation::type('withdraw'),
            'user_id'   => $this->user->id,
        ]);

        // update daily remain cache
        // TODO error handling
        $this->check->setWithdrawRemain($remain - $amount);
    }
}