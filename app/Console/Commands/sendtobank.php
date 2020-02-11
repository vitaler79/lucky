<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Bank;
use GuzzleHttp\Client;

class sendtobank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendtobank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending money to bank account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $N = env('NUM_QUERIES_TO_BANKS', 10);

        $bank = Bank::limit($N)->where('status', '=', 0)->get();
        $amount = count($bank);

        for ($i=0; $i<$amount; $i++) {

            try{

                DB::beginTransaction();

                $client = new Client();
                $res = $client->request('POST', 'https://url_to_the_bank_api', [
                    'form_params' => [
                        'auth_key' => env('BANK_AUTH_KEY', '59ac167e2f73bc9a0f61a788b67b82f92c1af522'),
                        'client' => $bank[$i]->full_name,
                        'account' => $bank[$i]->account,
                        'sum' => $bank[$i]->sum,
                        'currency' => 'dollar usa',
                        'token' => $bank[$i]->_token,
                    ]
                ]);

                if(200 == $res->getStatusCode()) {
                    $response = json_decode($res->getBody());

                    if('accepted' == $response['success']) {
                        $curBank = Bank::where('id', '=',$bank[$i]->id)->first();
                        $curBank->status = 1;
                        $curBank->save();
                    }
                }

                DB::commit();

            } catch(\Exception $e){
                DB::rollback();

                echo $e->getMessage();
            }
        }

    }
}
