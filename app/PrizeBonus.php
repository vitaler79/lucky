<?php
/**
 * Created by PhpStorm.
 * User: Vit
 * Date: 05.07.2019
 * Time: 22:53
 */

namespace App;


class PrizeBonus implements Prize
{
    public function choose()
    {
        $maxBonusPrise = (int)env('MAX_BONUS_PRIZE',10000);
        $minBonusPrise = (int)env('MIN_BONUS_PRIZE',1000);
        return rand($minBonusPrise, $maxBonusPrise);
    }
}