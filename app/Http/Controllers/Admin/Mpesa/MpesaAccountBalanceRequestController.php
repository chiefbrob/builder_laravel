<?php

namespace App\Http\Controllers\Admin\Mpesa;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Mpesa;

class MpesaAccountBalanceRequestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //try {
            $mpesa= new Mpesa();
            $CommandID = 'AccountBalance';
            $Initiator = env('MPESA_CONSUMER_KEY');
            $SecurityCredential = env('MPESA_CONSUMER_SECRET');
            $IdentifierType = 2;
            $PartyA = 12345;
            $Remarks = 'Checking balance';
            $ResultURL = url('/api/v1/admin/mpesa/balance-result');
            $QueueTimeOutURL = url('/api/v1/admin/mpesa/balance-timeout');

            $balanceInquiry=$mpesa->accountBalance(
                $CommandID,
                $Initiator,
                $SecurityCredential,
                $PartyA,
                $IdentifierType,
                $Remarks,
                $QueueTimeOutURL,
                $ResultURL
            );
            return response()->json(['balance' => 50.00], Response::HTTP_OK);
        // } catch (Exception $e) {
        //     Log::error($e);
        //     return response()->json(
        //         ['message' => 'Failed to fetch Mpesa account balance'],
        //         Response::HTTP_UNPROCESSABLE_ENTITY
        //     );
        // }
    }
}
