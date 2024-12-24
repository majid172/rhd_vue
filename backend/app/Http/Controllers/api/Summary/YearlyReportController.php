<?php

namespace App\Http\Controllers\api\Summary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class YearlyReportController extends Controller
{
    /**
     * Fetch bridge and plaza data for the user.
     */
    public function yearlyRequest(Request $request)
    {
        $user = User::where('username', 'programmer')->with('bridges.plazas')->first();

        if (!$user) {
            return redirect()->route('fallback');
        }

        $bridgeData = $user->bridges;

        if ($request->selectedBridge) {
            $bridgePlaza = $bridgeData->find($request->selectedBridge);
            return response()->json($bridgePlaza);
        }

        return response()->json($bridgeData);
    }

    /**
     * Fetch yearly report data for the selected plaza and year.
     */
    public function yearlyShow(Request $request)
    {
        $validatedData = $request->validate([
            'selectedPlazaId' => 'required|exists:plaza_tb,plaza_id',
            'year' => 'required|integer',
        ]);

        $plazaId = $validatedData['selectedPlazaId'];
        $currentYear = $validatedData['year'];

        // Fetch yearly details and return as a JSON response
        $yearlyReports = $this->getYearlyDetails($plazaId, $currentYear);
        return response()->json($yearlyReports);
    }

    /**
     * Fetch and format yearly transaction data.
     */
    private function getYearlyDetails($plazaId, $currentYear)
    {
        // Fetch transaction data grouped by month and payment type
        $results = AllTransaction::select(
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            'payment_type_id',
            DB::raw('COUNT(transaction_id) as transaction_count'),
            DB::raw('SUM(amount) as total_amount')
        )
            ->where('is_active', 1)
            ->where('plaza_id', $plazaId)
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'), 'payment_type_id')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'), 'asc')
            ->get()
            ->toArray();

        // Format and fill the report data
        return $this->formatYearlyReport($results);
    }

    /**
     * Format transaction data and fill in missing months (1 to 12).
     */
    private function formatYearlyReport($results)
    {
        // Initialize an array with all months (1 to 12)
        $allMonths = range(1, 12);
        $yearlyReport = [];

        // Process data for each payment type
        foreach ($results as $result) {
            $paymentType = $result['payment_type_id'];

            // Initialize payment type if not already present
            if (!isset($yearlyReport[$paymentType])) {
                $yearlyReport[$paymentType] = array_fill(0, 12, [
                    'month' => null,
                    'transaction_count' => 0,
                    'total_amount' => 0,
                ]);
            }

            // Populate data for the specific month
            $monthIndex = $result['month'] - 1; // Convert 1-based month to 0-based index
            $yearlyReport[$paymentType][$monthIndex] = [
                'month' => $result['month'],
                'transaction_count' => $result['transaction_count'],
                'total_amount' => $result['total_amount'],
            ];
        }

        // Ensure all months (1 to 12) are present for each payment type
        foreach ($yearlyReport as $paymentType => &$monthlyData) {
            foreach ($allMonths as $month) {
                $monthIndex = $month - 1;
                if (empty($monthlyData[$monthIndex]['month'])) {
                    $monthlyData[$monthIndex] = [
                        'month' => $month,
                        'transaction_count' => 0,
                        'total_amount' => 0,
                    ];
                }
            }
        }

        return $yearlyReport;
    }
}
