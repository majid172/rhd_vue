<?php

namespace App\Http\Controllers\api\Summary;

use App\Helpers\PlazaHelper;
use App\Http\Controllers\Controller;
use App\Models\AllTransaction;
use App\Models\Bridge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DailyReportController extends Controller
{
    public function dailyRequest(Request $request){
//        $user = Auth::user();
        $user = User::with('bridges')
            ->whereHas('bridges')
            ->where('username', 'programmer')
            ->first();

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

    public function dailyShow(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'selectedBridgeId' => 'required|exists:bridges,id',
//            'plaza_id' => 'required|exists:plaza_tb,plaza_id',
//            'inputDate'=>'required|date',
//            'inputStartTime' => 'required|date_format:H:i:s',
//            'inputEndTime' => 'required|date_format:H:i:s|after:inputStartTime',
////            'shift' => 'required|in:all_shift,first_shift,second_shift,third_shift,custom',
//        ]);
//        if ($validator->fails()) {
//            return response()->json('error','Please Submit With Correct Input') ;
//        }
        $plazaIds = PlazaHelper::getPlazaIds($request);
        $startOfDay = $request->inputDate.' '.$request->inputStartTime;
        $endOfDay = $request->inputDate.' '.$request->inputEndTime;

//        $dateRangeAndShift = PlazaHelper::getDateRange($request);

//        $startOfDay = $dateRangeAndShift['startOfDay'];
//        $endOfDay = $dateRangeAndShift['endOfDay'];
//        $inputDate = $dateRangeAndShift['inputDate'];

        $bridgeInfo = PlazaHelper::getBridgeAndPlazaNames($request);
        $bridgeName = $bridgeInfo->bridge_name;
        $plazaName = $bridgeInfo->plaza_name;

        $cashDetails = $this->getPaymentDetails($request, $plazaIds, $startOfDay, $endOfDay, 1);
        $exemptDetails = $this->getPaymentDetails($request, $plazaIds, $startOfDay, $endOfDay, 2);
        $etcDetails = $this->getPaymentDetails($request, $plazaIds, $startOfDay, $endOfDay, 3);
//        $data['cancelDetails'] = $this->getCancelDetails($request, $plazaIds, $startOfDay, $endOfDay);
        return response()->json([
            'cashDetails' => $cashDetails,
            'exemptDetails' => $exemptDetails,
            'etcDetails' => $etcDetails,
        ]);
//        return view('summaryReport.show.dailySummaryShow', compact('cashDetails', 'exemptDetails', 'etcDetails','cancelDetails','bridgeName','plazaName','inputDate','startOfDay','endOfDay'));
    }

    protected function getPaymentDetails($request,$plazaIds,$startOfDay, $endOfDay ,$paymentType)
    {
//        $model = PlazaHelper::getModel($request->plaza_id);
        return AllTransaction::select(
            'vehicle_class',
            DB::raw('COUNT(*) as transaction_count'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('MAX(amount) as vehicle_rate')
        )
            ->whereIn('plaza_id', $plazaIds)
            ->where('is_active','1')
            ->where('created_at', '>=',  $startOfDay)
            ->where('created_at', '<=',  $endOfDay)
            ->where('payment_type_id', $paymentType)
            ->groupBy('vehicle_class')
            ->orderBy('vehicle_rate', 'asc')
            ->get();

    }
}
