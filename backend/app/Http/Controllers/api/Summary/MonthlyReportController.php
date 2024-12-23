<?php

namespace App\Http\Controllers\api\Summary;

use App\Helpers\PlazaHelper;
use App\Http\Controllers\Controller;
use App\Models\AllTransaction;
use App\Models\Bridge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MonthlyReportController extends Controller
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

        // $validator = Validator::make($request->all(), [
        //     'selectedBridgeId' => 'required|exists:bridges,id',
        //     'plaza_id' => 'required|exists:plaza_tb,plaza_id',
        //     'month'=>'required',
        //     'payment_type_id' => 'required|in:1,2,3',
        //     'report_type' => 'required|in:1,2',

        // ]);
        // if ($validator->fails()) {
        //     return redirect()->back()->with('error','Please Submit With Correct Input') ;
        // }


        $plazaId = $request->selectedPlazaId;
        $month = $request->month;
        $paymentType = $request->payment_type;
        $year = date('Y', strtotime($month));
        $monthValue = date('m', strtotime($month));
        $date = Carbon::createFromFormat('Y-m', $month);
        $currentMonth = $date->format('F, Y');

        $plazaDetails = DB::table('plaza_tb')
            ->select('plaza_tb.*', 'bridges.bridge_name')
            ->join('bridges', 'plaza_tb.bridge_id', '=', 'bridges.id')
            ->where('plaza_id', $plazaId)
            ->first();

        $reportType = $request->report_type;

        $transactions = $this->getMonthly($plazaId,$paymentType,$year,$monthValue,$reportType);


        return response()->json(['transactions' => $transactions]);

    }

    public function getMonthly($plazaId,$paymentType,$year,$monthValue,$reportType)
    {

        if ($reportType==1)
        {
            $query = AllTransaction::select(
                DB::raw('EXTRACT(DAY FROM created_at) as day'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'AGRO USE\' THEN transaction_id ELSE NULL END) as agro_use'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'MINI TRUCK\' THEN transaction_id ELSE NULL END) as mini_truck'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'MICROBUS\' THEN transaction_id ELSE NULL END) as microbus'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'TRAILER\' THEN transaction_id ELSE NULL END) as trailer'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'HEAVY TRUCK\' THEN transaction_id ELSE NULL END) as heavy_truck'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'SEDAN CAR\' THEN transaction_id ELSE NULL END) as sedancar'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'MEDIUM TRUCK\' THEN transaction_id ELSE NULL END) as medium_truck'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'LARGE BUS\' THEN transaction_id ELSE NULL END) as largebus'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'MINI BUS/COASTER\' THEN transaction_id ELSE NULL END) as minibus'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'AGRICULTURAL VEHICLE\' THEN transaction_id ELSE NULL END) as agricultural'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'MOTORCYCLE\' THEN transaction_id ELSE NULL END) as motorcycle'),
                DB::raw('COUNT(CASE WHEN vehicle_class = \'PICKUP/JEEP/WRECKER/CRANE\' THEN transaction_id ELSE NULL END) as pickup'),
                DB::raw('COUNT(*) as total_trx')
            )
                ->where('is_active', 1)
                ->where('payment_type_id', $paymentType)
                ->where('plaza_id', $plazaId)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthValue)
                ->groupBy(DB::raw('EXTRACT(DAY FROM created_at)'))
                ->orderBy(DB::raw('EXTRACT(DAY FROM created_at)'), 'asc')
                ->get();
            return $query;
        }
        elseif($reportType == 2)
        {
            $query = AllTransaction::select(
                DB::raw('EXTRACT(DAY FROM created_at) as day'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'AGRO USE\' THEN amount ELSE NULL END) as agro_use'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'MINI TRUCK\' THEN amount ELSE NULL END) as mini_truck'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'MICROBUS\' THEN amount ELSE NULL END) as microbus'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'TRAILER\' THEN amount ELSE NULL END) as trailer'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'HEAVY TRUCK\' THEN amount ELSE NULL END) as heavy_truck'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'SEDAN CAR\' THEN amount ELSE NULL END) as sedancar'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'MEDIUM TRUCK\' THEN amount ELSE NULL END) as medium_truck'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'LARGE BUS\' THEN amount ELSE NULL END) as largebus'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'MINI BUS/COASTER\' THEN amount ELSE NULL END) as minibus'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'MOTORCYCLE\' THEN amount ELSE NULL END) as motorcycle'),
                DB::raw('SUM(CASE WHEN vehicle_class = \'PICKUP/JEEP/WRECKER/CRANE\' THEN amount ELSE NULL END) as pickup'),
                DB::raw('SUM(amount) as total_trx')
            )
                ->where('is_active', 1)
                ->where('payment_type_id', $paymentType)
                ->where('plaza_id', $plazaId)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthValue)
                ->groupBy(DB::raw('EXTRACT(DAY FROM created_at)'))
                ->orderBy(DB::raw('EXTRACT(DAY FROM created_at)'), 'asc')
                ->get();
            return $query;
        }
    }
}
