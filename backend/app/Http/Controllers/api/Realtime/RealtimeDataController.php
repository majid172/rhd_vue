<?php

namespace App\Http\Controllers\api\Realtime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bridge;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PlazaHelper;
use App\Models\AllTransaction;
use Carbon\Carbon;

class RealtimeDataController extends Controller
{
    public function index(Request $request)
    {

     $user=User::all();

     return $user;



//        $user = Auth::user();
//        if ($user) {
//            $userBridges = $user->bridges()->pluck('id')->toArray();
//            $bridgeData = Bridge::with('plazas')
//                ->whereIn('id', $userBridges)
//                ->get();
//            if ($request->selectedBridge) {
//                $bridgePlaza = Bridge::with('plazas')
//                    ->find($request->selectedBridge);
//                return response()->json($bridgePlaza);
//            }
//            return view('realtime.realtimeRequest', compact('bridgeData'));
//        }
//        return redirect()->route('fallback');
    }
    public function realTimeShow(Request $request)
   {

    //   $validator = Validator::make($request->all(), [
    //     'selectedBridgeId' => 'required|exists:bridges,id',
    //     'plaza_id' => 'required|exists:plaza_tb,plaza_id',
    //   ]);
    //   if ($validator->fails()) {
    //     return redirect()->back()->with('error','Please Submit With Correct Input') ;
    //   }

      $plazaIds = PlazaHelper::getPlazaIds($request);

      $bridgeInfo = PlazaHelper::getBridgeAndPlazaNames($request);
      $bridgeName = $bridgeInfo->bridge_name;
      $plazaName = $bridgeInfo->plaza_name;
      $today = now()->format('Y-m-d');

    // $model = PlazaHelper::getModel($request->plaza_id);
    $total_toll = AllTransaction::whereIn('plaza_id',$plazaIds)->where('payment_type_id',1)
                    ->where('is_active', 1)
                    ->whereDate('created_at', $today)
                    ->sum('amount');

    $total_etc = AllTransaction::whereIn('plaza_id', $plazaIds)
        ->where('payment_type_id', 3)
        ->where('is_active', 1)
        ->whereDate('created_at', $today)
        ->sum('amount');

    $transactions = $this->getTrxData($plazaIds,$plazaName);
return $transactions;
     return view('realtime.realtimeDataShow', compact('transactions','total_toll','total_etc','bridgeName','plazaName'));
   }

      public function getTrxData($plazaIds, $plazaName)
   {

    $subquery = DB::table('ALL_TRANSACTIONS_TB')
    ->select('lane_no', DB::raw('MAX(created_at) as latest_created_at'))
    ->whereIn('plaza_id', $plazaIds)
    ->where('is_active', 1)
    ->whereDate('created_at', Carbon::today())
    ->groupBy('lane_no');
    

    $transactions = AllTransaction::with(['image', 'user'])
    ->joinSub($subquery, 'latest_trx', function($join) {
        $join->on('ALL_TRANSACTIONS_TB.lane_no', '=', 'latest_trx.lane_no')
             ->on('ALL_TRANSACTIONS_TB.created_at', '=', 'latest_trx.latest_created_at');
    })
    ->select(
        'ALL_TRANSACTIONS_TB.transaction_id',
        'ALL_TRANSACTIONS_TB.registration_number',
        'ALL_TRANSACTIONS_TB.amount',
        'ALL_TRANSACTIONS_TB.transaction_number',
        'ALL_TRANSACTIONS_TB.vehicle_class',
        // 'ALL_TRANSACTIONS_TB.vehicle_id',
        'ALL_TRANSACTIONS_TB.lane_no',
        'ALL_TRANSACTIONS_TB.image_name',
        'ALL_TRANSACTIONS_TB.bank_id',
        'ALL_TRANSACTIONS_TB.payment_type_id',
        'ALL_TRANSACTIONS_TB.user_id',
        'ALL_TRANSACTIONS_TB.recognize_by',
        'ALL_TRANSACTIONS_TB.plaza_id',
        // 'ALL_TRANSACTIONS_TB.rfid_no',
        'ALL_TRANSACTIONS_TB.class_status',
        'ALL_TRANSACTIONS_TB.transactin_id_by_bank',
        'ALL_TRANSACTIONS_TB.is_active',
        'ALL_TRANSACTIONS_TB.status_remarks',
        'ALL_TRANSACTIONS_TB.created_at',
        'ALL_TRANSACTIONS_TB.updated_at'

    )
    ->orderBy('ALL_TRANSACTIONS_TB.lane_no', 'asc')
    ->get();

    return $transactions;
   }
}
