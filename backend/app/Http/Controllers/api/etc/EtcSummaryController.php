<?php

namespace App\Http\Controllers\api\etc;

use App\Http\Controllers\Controller;
use App\Models\AllTransaction;
use App\Models\Bridge;
use App\Helpers\PlazaHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EtcSummaryController extends Controller
{
    public function etcRequest(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('fallback');
        }

        // Get bridges assigned to the user with their associated plazas
        $bridgeData = Bridge::with('plazas')
            ->whereIn('id', $user->bridges()->pluck('id'))
            ->get();

        // Return specific bridge details if selected
        if ($request->selectedBridge) {
            $bridgePlaza = Bridge::with('plazas')->find($request->selectedBridge);
            return response()->json($bridgePlaza);
        }

        return view('etcReport.request.etcDetailRequest', compact('bridgeData'));
    }

    public function etcShow(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'selectedBridgeId' => 'required|exists:bridges,id',
            'plaza_id' => 'required|exists:plaza_tb,plaza_id',
            'inputDate' => 'required|date',
            'inputStartTime' => 'required|date_format:H:i:s',
            'inputEndTime' => 'required|date_format:H:i:s|after:inputStartTime',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Retrieve bridge and plaza details
        $bridgeInfo = PlazaHelper::getBridgeAndPlazaNames($request);
        $bridgeName = $bridgeInfo->bridge_name;
        $plazaName = $bridgeInfo->plaza_name;

        // Get related plaza IDs and date range for the query
        $plazaIds = PlazaHelper::getPlazaIds($request);
        $dateRangeAndShift = PlazaHelper::getDateRangeAndShift($request);
        $startOfDay = $dateRangeAndShift['startOfDay'];
        $endOfDay = $dateRangeAndShift['endOfDay'];
        $inputDate = $dateRangeAndShift['inputDate'];

        // Fetch aggregated transaction data
        $transactions = AllTransaction::whereIn('plaza_id', $plazaIds)
            ->where('is_active', 1)
            ->where('payment_type_id', 3)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->selectRaw('vehicle_class, lane_no, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('vehicle_class', 'lane_no')
            ->orderBy('vehicle_class')
            ->get()
            ->groupBy('vehicle_class');

        // Transform results into the desired format
        $groupedTransactions = $transactions->map(function ($group) {
            return [
                'total_amount' => $group->sum('total_amount'),
                'lanes' => $group->map(fn($item) => [
                    'lane_no' => $item->lane_no,
                    'count' => $item->count,
                ]),
            ];
        });

        $lanes = $this->getLanes($groupedTransactions);

        // Respond with aggregated data
        return response()->json([
            "bridgeName" => $bridgeName,
            "plazaName" => $plazaName,
            "inputDate" => $inputDate,
            "lanes" => $lanes,
            "transactions" => $groupedTransactions
        ]);
    }
    public function getLanes($transactions)
    {
        $lanes = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction['lanes'] as $item) {
                $lanes[] = [
                    'lane_no' => $item['lane_no'],
                    'count' => $item['count'],
                ];
            }
            return $lanes;
        }
    }

}
