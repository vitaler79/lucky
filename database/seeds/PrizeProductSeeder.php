<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PrizeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prize_products')->insert([
            'name' => 'Vacuum cleaner BOSH ZXC-1600',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('prize_products')->insert([
            'name' => 'iPhone 11',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('prize_products')->insert([
            'name' => 'iPad Air 2',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('prize_products')->insert([
            'name' => 'Mac Book 13',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('prize_products')->insert([
            'name' => 'Xiaomi Redme 11 Pro',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('prize_products')->insert([
            'name' => 'TV Samsung FUUL HD ASDV23L',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('prize_products')->insert([
            'name' => 'iWatch',
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
