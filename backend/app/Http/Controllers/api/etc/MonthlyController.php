<?php

namespace App\Http\Controllers\api\etc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AllTransaction;
use App\Helpers\PlazaHelper;

class MonthlyController extends Controller
{
    public function monthlyRequest(Request $request)
        {
            $user = User::where('username','programmer')->first();
            if ($user) {
                $userBridges = $user->bridges->pluck('id');
                $bridgeData = Bridge::with('plazas')
                    ->whereIn('id', $userBridges)
                    ->get();

                if ($request->selectedBridge) {
                    $bridgePlaza = $bridgeData->find($request->selectedBridge);
                    return response()->json($bridgePlaza);
                }
                return response()->json($bridgeData);
            }
            return redirect()->route('fallback');
        }


public function monthlyShow(Request $request)
    {
//         $validator = Validator::make($request->all(), [
//             'selectedBridgeId' => 'required|exists:bridges,id',
//             'plaza_id' => 'required|exists:plaza_tb,plaza_id',
//             'month'=>'required',
// //            'endDate'=>'required|date',
//         ]);
//         if ($validator->fails()) {
//             return redirect()->back()->with('error','Please Submit With Correct Input') ;
//         }
        $plazaIds = $request->plaza_id;
        $data['bridgeInfo'] = PlazaHelper::getBridgeAndPlazaNames($request);
        $bridgeName = $data['bridgeInfo']->bridge_name;
        $plazaName = $data['bridgeInfo']->plaza_name;
        $transactions = $this->getEtcMonthly($plazaIds,$request->month);
        $month = Carbon::parse($request->month)->format('F, Y');

        return response()->json(
        [
            'month' => $month,
            'plazaName' => $plazaName,
            'bridgeName' => $bridgeName,
            'transactions' => $transactions,

        ]);

    }
    public function getEtcMonthly($plazaIds,$month)
    {
        [$year, $month] = explode('-', $month);
        $query = AllTransaction::select(
            DB::raw('EXTRACT(DAY FROM created_at) as day'),
            DB::raw('COUNT(CASE WHEN bank_id = 1 THEN transaction_id ELSE NULL END) as bkash_count'),
            DB::raw('COUNT(CASE WHEN bank_id = 2 THEN transaction_id ELSE NULL END) as upay_count'),
            DB::raw('COUNT(CASE WHEN bank_id = 3 THEN transaction_id ELSE NULL END) as rocket_count'),
            DB::raw('COUNT(transaction_id) as transaction_count'),

            DB::raw('SUM(CASE WHEN bank_id = 1 THEN amount ELSE NULL END) as bkash_amount'),
            DB::raw('SUM(CASE WHEN bank_id = 2 THEN amount ELSE NULL END) as upay_amount'),
            DB::raw('SUM(CASE WHEN bank_id = 3 THEN amount ELSE NULL END) as rocket_amount'),
            DB::raw('SUM(amount) as total_amount')
        )
            ->where('is_active', 1)
            ->where('payment_type_id',3)
            ->where('plaza_id', $plazaIds)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy(DB::raw('EXTRACT(DAY FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(DAY FROM created_at)'), 'asc')
            ->get();
        $results = $query->toArray();
        return $results;
    }

    public function getResults($results)
    {
        $monthlyReport = [];
        foreach ($results as $result) {
            $month = $result['day'];
            $bankType = $result['bank_id'];
            $transactionCount = $result['transaction_count'];
            $totalAmount = $result['total_amount'];

            if (!isset($monthlyReport[$bankType])) {
                $monthlyReport[$bankType] = [];
            }

            $monthlyReport[$bankType][] = [
                "day" => $month,
                "transaction_count" => $transactionCount,
                "total_amount" => $totalAmount
            ];
        }
        return $monthlyReport ;
    }

}
