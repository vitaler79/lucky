<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PrizeMoneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prize_money')->insert([
            'sum' => 100000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
