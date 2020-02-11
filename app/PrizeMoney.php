<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrizeMoney extends Model implements Prize
{
    public function choose()
    {
        $maxMoneyPrise = (int)env('MAX_MONEY_PRIZE',1000);
        $minMoneyPrise = (int)env('MIN_MONEY_PRIZE',100);
        $prizeSum = rand($minMoneyPrise, $maxMoneyPrise);

        $maxTotal = PrizeMoney::latest('id')->first();
        if (isset($maxTotal->sum)) {

            if ($maxTotal->sum>=$prizeSum) {
                $maxTotal->sum = $maxTotal->sum - $prizeSum;
            } else {
                $prizeSum = $maxTotal->sum;
                $maxTotal->sum = 0;
            }
            $maxTotal->save();

            return $prizeSum;
        }

        return 0;
    }
}
