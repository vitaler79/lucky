<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\RafflePrizes;
use App\User;


class HomeTest extends TestCase
{
    /**
     * A test of the money transferring to the account.
     *
     * @return void
     */
    public function testMoneyToAccount()
    {
        $rate = (float)env("MONEY_TO_ACCOUNT", 2);

        $db_post_raffle = DB::select('SELECT * FROM `raffle_prizes` WHERE `prize_type` = "money" AND `status` = 0 ORDER BY `id` DESC LIMIT 1');
        $raffleId = (int)$db_post_raffle[0]->id;
        $userId = (int)$db_post_raffle[0]->user_id;
        $db_post_user = DB::select('SELECT * FROM `users` WHERE `id` = '.$userId);
        $db_post_account = $db_post_user[0]->account + round($rate * $db_post_raffle[0]->prize);


        $rafflePrize = RafflePrizes::where('id', '=',$raffleId)->where('user_id', '=', $userId)->where('status', '=', 0)->first();
        $user = User::find($userId);
        $model_post_account = $user->account + round($rate * $rafflePrize->prize);

        $this->assertEquals($db_post_account, $model_post_account);
    }
}
