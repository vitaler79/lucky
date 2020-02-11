<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\RafflePrizes;
use App\PrizeFactory;
use App\PrizeProduct;
use App\PrizeMoney;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = \Auth::user()->id;

        $rafflePrize = RafflePrizes::latest('id')->where('user_id', '=', $userId)->where('status', '=', 0)->first();

        $prizeName = '';
        if(isset($rafflePrize->prize_type) && 'product'==$rafflePrize->prize_type) {
            $product = PrizeProduct::where("id",$rafflePrize->prize)->first();
            $prizeName = $product->name;
        }

        return view('home', ['prize' => $rafflePrize, 'prizeName' => $prizeName]);
    }

    public function getPrize(RafflePrizes $rafflePrize)
    {
        $userId = \Auth::user()->id;

        try{

            DB::beginTransaction();

            $prisesArr = explode(',', env('PRIZES_TYPES_FOR_RAFFLE', 'money,bonus,product'));
            $prisesArrLen = count($prisesArr);
            if ($prisesArrLen > 0) {
                $index = rand(0, $prisesArrLen-1);
                $prizeType = $prisesArr[$index];

                $factory = new PrizeFactory();
                $prizeObj = $factory->make($prizeType);

                $prize = $prizeObj->choose();

                if ($prize > 0) {
                    $rafflePrize->user_id = $userId;
                    $rafflePrize->prize_type = $prizeType;
                    $rafflePrize->prize = $prize;
                    $rafflePrize->status = 0;
                    $rafflePrize->save();
                }
            }

            DB::commit();

        } catch(\Exception $e){
            DB::rollback();

            echo $e->getMessage();
        }

        return redirect()->route('home');
    }
}
