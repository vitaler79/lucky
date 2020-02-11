<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrizeProduct extends Model implements Prize
{
    public function choose()
    {
        $product = PrizeProduct::inRandomOrder()->where('status', '=', 0)->first();

        if(isset($product->id)) {
            $product->status = 1;
            $product->save();

            return $product->id;
        } else {
            return 0;
        }
    }
}
