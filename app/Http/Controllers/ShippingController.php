<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\RafflePrizes;
use App\PrizeProduct;
use App\Shipping;

class ShippingController extends Controller
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

    public function index(Request $request)
    {
        $userId = \Auth::user()->id;

        if (isset($request->id)) {
            $raffleId = (int)$request->id;
            $rafflePrize = RafflePrizes::where('id', '=',$raffleId)->where('prize_type', '=','product')->where('user_id', '=', $userId)->first();

            if (isset($rafflePrize->id)) {
                $shipping = Shipping::where('raffle_id', '=',$raffleId)->where('user_id', '=', $userId)->first();

                $product = PrizeProduct::where("id",$rafflePrize->prize)->first();
                $prizeName = $product->name;

                return view('shipping', ['shipping' => $shipping, 'raffle' => $rafflePrize, 'prizeName' => $prizeName]);
            }

        }

        return redirect()->route('home');
    }

    public function query(Request $request)
    {
        $userId = \Auth::user()->id;

        if (isset($request->raffle_id)) {

            $raffleId = (int)$request->raffle_id;

            try{

                DB::beginTransaction();

                $rafflePrize = RafflePrizes::where('id', '=',$raffleId)->where('user_id', '=', $userId)->where('status', '=', 0)->first();

                if (isset($rafflePrize->id)) {
                    $requestArr = $request->except('_token');

                    if(isset($requestArr['prize_name'],
                            $requestArr['full_name'],
                            $requestArr['country'],
                            $requestArr['zip'],
                            $requestArr['address'],
                            $requestArr['phone'],
                            $requestArr['email'])
                        && !empty($requestArr['prize_name'])
                        && !empty($requestArr['full_name'])
                        && !empty($requestArr['country'])
                        && !empty($requestArr['zip'])
                        && !empty($requestArr['address'])
                        && !empty($requestArr['phone'])
                        && !empty($requestArr['email'])
                        && filter_var($requestArr['email'], FILTER_VALIDATE_EMAIL)) {

                        $requestArr['user_id'] =  $userId;
                        $requestArr['status'] = 0;
                        Shipping::forceCreate($requestArr);

                        $rafflePrize->status = 2;
                        $rafflePrize->save();
                    }
                }

                DB::commit();

            } catch(\Exception $e){
                DB::rollback();

                echo $e->getMessage();
            }

            return redirect()->route('shipping', $raffleId);

        } else {

            return redirect()->route('home');
        }

    }
}

