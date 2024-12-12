<?php

namespace App\Http\Controllers\api\Realtime;

use App\Http\Controllers\Controller;
use App\Models\Plaza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bridge;


use Illuminate\Support\Facades\Validator;
use App\Helpers\PlazaHelper;
use App\Models\AllTransaction;
use App\Models\Image;
use Carbon\Carbon;


class RealtimeDataController extends Controller
{
    public function index(Request $request)
    {

        $user = User::all();
        return $user;

    }
    public function realTimeShow(Request $request)
    {
        $plazaIds = PlazaHelper::getPlazaIds($request);
        $bridgeId = $request->input('selectedBridgeId');
        $plazaId = $request->input('plaza_id');

        // Get bridge and plaza names
        $bridgeName = Bridge::where('id', $bridgeId)->value('bridge_name');
        $plazaName = Plaza::where('plaza_id', $plazaId)->value('plaza_name');

        // Get today's date
        $today = Carbon::today()->format('Y-m-d');

        // Calculate total toll collected today
        $total_toll = DB::table('all_transactions_tb')
            ->whereIn('plaza_id', $plazaIds)
            ->where('payment_type_id', 1) // Assuming payment type 1 is for toll payments
            ->whereDate('created_at', $today)
            ->sum('amount');

        // Calculate total ETC (Electronic Toll Collection) today
        $total_etc = DB::table('all_transactions_tb')
                        ->whereIn('plaza_id', $plazaIds)
                        ->where('payment_type_id', 3) // Assuming payment type 3 is for ETC
                        ->whereDate('created_at', $today)
                        ->sum('amount');


        // Retrieve recent transactions
        $transactions = AllTransaction::with('user')
                            ->whereIn('plaza_id', $plazaIds)
                            ->whereDate('created_at', Carbon::today()) // Filter by today's date
                            ->orderBy('created_at', 'desc')
                            ->limit(6)
                            ->get();


        // Map the transactions to a more readable format
        $transactions = $transactions->map(function ($transaction) {
            $image = Image::where('image_name', $transaction->image_name)->first();
            $imageData = $image ? 'data:image/png;base64,' . base64_encode($image->image_data) : null;


            return [
                'transaction_id' => $transaction->transaction_id,
                'registration_number' => $transaction->registration_number,
                'vehicle_class' => $transaction->vehicle_class,
                'amount' => $transaction->amount,
                'transaction_number' => $transaction->transaction_number,
                'lane_number' => $transaction->lane_no,
                'image_name' => $transaction->image_name,
                'status' => $transaction->class_status,
                'created_at' => Carbon::parse($transaction->created_at)->format('Y-m-d H:i:s'),
                'user' => [
                    'id' => $transaction->user->id,
                    'name' => $transaction->user->name,
                    'username' => $transaction->user->username,
                    'counter_key' => $transaction->user->counter_key,
                    'status' => $transaction->user->status,
                ],
                'image_data' => $imageData // Include the base64-encoded image data
            ];
        });

        // Return the formatted transactions as a JSON response
        return response()->json([
            'total_toll' => $total_toll,
            'total_etc' => $total_etc,
            'transactions' => $transactions
        ]);
    }

    public function laneShow(Request $request)
    {

        $plazaIds = PlazaHelper::getPlazaIds($request);
        $bridgeId = $request->input('selectedBridgeId');
        $plazaId = $request->input('plaza_id');
        // Get bridge and plaza names
        $bridgeName = Bridge::where('id', $bridgeId)->value('bridge_name');
        $plazaName = Plaza::where('plaza_id', $plazaId)->value('plaza_name');

        // Get today's date
        $today = Carbon::today()->format('Y-m-d');

        // Calculate total toll collected today
        $total_toll = DB::table('all_transactions_tb')
            ->whereIn('plaza_id', $plazaIds)
            ->where('payment_type_id', 1) // Assuming payment type 1 is for toll payments
            ->whereDate('created_at', $today)
            ->sum('amount');

        // Calculate total ETC (Electronic Toll Collection) today
        $total_etc = DB::table('all_transactions_tb')
            ->whereIn('plaza_id', $plazaIds)
            ->where('payment_type_id', 3) // Assuming payment type 3 is for ETC
            ->whereDate('created_at', $today)
            ->sum('amount');

        // Retrieve recent transactions
return $request->all();
        $transactions = AllTransaction::with('user')
            ->whereIn('plaza_id', $plazaIds)
            ->where(['is_active'=>1,'lane_no'=>$request->lane])
            ->whereDate('created_at', Carbon::today()) // Filter by today's date
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

return $transactions;

// $transactions = $model::with(['image','user'])
//             ->whereIn('plaza_id',$plazaIds)
//             ->where(['is_active'=>1,'lane_no'=>$counter])
//             ->whereDate('all_transactions_tb.created_at',carbon::today())
//             ->orderBy('all_transactions_tb.created_at','desc')
//             ->limit(6)
//             ->get();
//         return $transactions;

        // Return the formatted transactions as a JSON response
        return response()->json([
            'total_toll' => $total_toll,
            'total_etc' => $total_etc,
            'transactions' => $transactions
        ]);
    }



}


