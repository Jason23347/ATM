<?php

namespace App\Http\Controllers;

use App\MoneyRepository as Money;
use Illuminate\Http\Request;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\OperationRequest;
use App\Resources\ApiResource as Resource;

class MoneyController extends Controller
{
    /**
     * Money repository instance
     *
     * @var App\MoneyRepository
     */
    private $money;

    public function __construct(Money $money)
    {
        $this->money = $money;
    }

    public function index(Request $request)
    {
        $res = $this->money->getRecords(5);
        return new Resource($res);
    }

    public function transfer(TransferRequest $request)
    {
        $user = $request->user();
        $this->authorize('update');
        $res = $this->money->asUser($user)
                    ->transfer($request->input());
        return new Resource($res);
    }

    public function deposit(OperationRequest $request)
    {
        $user = $request->user();
        $this->authorize('update');
        $res = $this->money->asUser($user)
                    ->deposit($request->input());
        return new Resource($res);
    }

    public function widthdraw(OperationRequest $request)
    {
        $user = $request->user();
        $this->authorize('update');
        $res = $this->money->asUser($user)
                    ->withdraw($request->input());
        return new Resource($res);
    }
}
