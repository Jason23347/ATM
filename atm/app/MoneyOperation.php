<?php

namespace App;

class MoneyOperation
{
    /**
     * 0: 存款
     * 1: 取款
     * 2: 转帐入账
     * 3: 转帐出账
     */
    const operationList = [
        'deposit'   => 0,
        'withdraw'  => 1,
        'collect'   => 2,
        'pay'       => 3,
    ];

    static public function type(string $opt)
    {
        return static::operationList[$opt] ?? -1;
    }
}