<?php

namespace Tests\Unit;

use App\MoneyOperation;
use App\User;
use App\Models\Flow;
use App\MoneyCheck;
use App\MoneyRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class MoneyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * create a money repository instance
     *
     * @param App\User $user
     *
     * @return App\MoneyRepository
     */
    private function newRepository(User $user)
    {
        return new MoneyRepository($user, new Flow, new MoneyCheck($user));
    }

    public function test_get_records()
    {
        $user = factory(User::class)->create();
        for ($i = 0; $i < 10; $i++)
            Flow::create([
                'amount'    => random_int(0, 100),
                'type'      => 1,
                'user_id'   => $user->id,
            ]);

        $repo = $this->newRepository($user);
        $res = $repo->getRecords(3);
        $this->assertEquals(3, $res->count());
    }

    public function test_transfer()
    {
        // create user with a lot of money
        $rich = 1000000.00; // 1 million
        $from = factory(User::class)->make();
        $from->balance = $rich;
        $from->save();

        // create user with no money
        $poor = 0.98;
        $receive = factory(User::class)->make();
        $receive->balance = $poor;
        $receive->save();

        $money = 100.00;
        // 施舍
        $repo = $this->newRepository($from);
        $res = $repo->transfer([
            'amount'            => $money,
            'transfer_party'    => $receive->card_number,
        ]);

        $this->assertNull($res['errcode']);

        // check balance
        $this->assertEquals(
            $poor + $money,
            User::find($receive->id)->balance
        );
        $this->assertEquals(
            $rich - $money,
            User::find($from->id)->balance
        );

        // check flow
        $flows = Flow::where('amount', $money)->get();
        $this->assertEquals(2, $flows->count());
        $this->assertEquals(
            MoneyOperation::type('pay'),
            $flows->first()->type
        );
        $this->assertEquals(
            MoneyOperation::type('collect'),
            $flows->last()->type
        );
        // TODO errcode == 3002 || 3003
    }


    public function test_deposit()
    {
        $balance = 30.00;
        $user = factory(User::class)->make();
        $user->balance = $balance;
        $user->save();

        $repo = $this->newRepository($user);
        $amount = random_int(1000, 3000);
        $res = $repo->deposit([
            'amount'    => $amount,
        ]);

        $this->assertNull($res['errcode']);

        // check balance
        $this->assertEquals(
            $balance + $amount,
            User::find($user->id)->balance
        );

        // check flow
        $flow = Flow::where('amount', $amount)->first();
        $this->assertEquals(MoneyOperation::type('deposit'), $flow->type);
    }

    public function test_withdraw()
    {
        $balance = 3000.00;
        $user = factory(User::class)->make();
        $user->balance = $balance;
        $user->save();

        $repo = $this->newRepository($user);
        $amount = random_int(1000, 3000);
        $res = $repo->withdraw([
            'amount'    => $amount,
        ]);
        $this->assertNull($res['errcode']);

        // check balance
        $this->assertEquals(
            $balance - $amount,
            User::find($user->id)->balance
        );

        // check flow
        $flow = Flow::where('amount', $amount)->first();
        $this->assertEquals(MoneyOperation::type('withdraw'), $flow->type);

        // TODO overflow 5w in total
    }
}
