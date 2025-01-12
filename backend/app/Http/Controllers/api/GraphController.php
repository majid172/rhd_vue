<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AllTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function index()
    {

        $chartOne = $this->chartOne();
        $chartTwo = $this->chartTwo();
        $chartThree = $this->chartThree();
        $chartFour = $this->chartFour();
        return response()->json(['chartOne'=>$chartOne,'chartTwo'=>$chartTwo,'chartThree'=>$chartThree,'chartFour'=>$chartFour]);
    }
    public function chartOne()
    {
        $today = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        $dataOne = AllTransaction::select('vehicle_class', DB::raw('SUM(amount) as totalamount'))
            ->whereBetween('created_at', [$today, $endOfDay])
            ->groupBy('vehicle_class')
            ->get();

        $formattedData = $dataOne->map(function($item) {
            return [
                'label' => $item->vehicle_class,
                'y' => (float) $item->totalamount,
            ];
        });

        return $formattedData;

    }
    public function chartTwo()
    {
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();
        $dataTwo = AllTransaction::select('payment_type_id', DB::raw('SUM(amount) as totalamount'))
            ->where('is_active', 1)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->groupBy('payment_type_id')
            ->get();
        $formattedData = $dataTwo->map(function ($item) {
            $label = match ($item->payment_type_id) {
                '1' => 'Cash',
                '2' => 'Exempt',
                '3' => 'Etc',
                default => '',
            };

            return [
                'label' => $label,
                'y' => (float) $item->totalamount,
            ];
        });
        return $formattedData;
    }
    public function chartThree()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $dataThree = AllTransaction::select(DB::raw('TO_CHAR(created_at,\'DD\') as day'),
        DB::raw('SUM(amount) as totalamount'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('is_active', 1)
            ->groupBy(DB::raw('TO_CHAR(created_at, \'DD\')'))
            ->orderBy(DB::raw('TO_CHAR(created_at, \'DD\')'), 'asc')
            ->get();
        $formattedData = $dataThree->map(function ($item) {
            return [
                'label' => $item->day,
                'y' => (float) $item->totalamount,
            ];
        });
        return $formattedData;
    }
    public function chartFour()
    {
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        $dataFour = AllTransaction::select(
            DB::raw('TO_CHAR(created_at, \'HH24\') as hour'),
            DB::raw('SUM(amount) as totalamount')
        )
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->groupBy(DB::raw('TO_CHAR(created_at, \'HH24\')'))
            ->orderBy(DB::raw('TO_CHAR(created_at, \'HH24\')'), 'asc')
            ->get();
        $formattedData = $dataFour->map(function($item) {
            return [
                'label' => $item->hour,
                'y' => (float) $item->totalamount,
            ];
        });
        return $formattedData;

    }

}
