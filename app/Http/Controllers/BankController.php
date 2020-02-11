<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\RafflePrizes;
use App\Bank;

class BankController extends Controller
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
            $rafflePrize = RafflePrizes::where('id', '=',$raffleId)->where('prize_type', '=','money')->where('user_id', '=', $userId)->first();

            if (isset($rafflePrize->id)) {
                $bank = Bank::where('raffle_id', '=',$raffleId)->where('user_id', '=', $userId)->first();

                return view('bank', ['bank' => $bank, 'raffle' => $rafflePrize]);
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
                    $requestArr = $request->all();

                    if(isset($requestArr['full_name'],$requestArr['account'],$requestArr['email'])
                        && !empty($requestArr['full_name'])
                        && !empty($requestArr['account'])
                        && !empty($requestArr['email'])
                        && filter_var($requestArr['email'], FILTER_VALIDATE_EMAIL)) {

                        $requestArr['_token'] = sha1($requestArr['_token'] . $requestArr['email'] . date('Y-m-d H:i:s'));
                        $requestArr['sum'] = $rafflePrize->prize;
                        $requestArr['user_id'] =  $userId;
                        $requestArr['status'] = 0;
                        Bank::forceCreate($requestArr);

                        $rafflePrize->status = 2;
                        $rafflePrize->save();
                    }
                }

                DB::commit();

            } catch(\Exception $e){
                DB::rollback();

                echo $e->getMessage();
            }

            return redirect()->route('bank', $raffleId);

        } else {

            return redirect()->route('home');
        }

    }
}
