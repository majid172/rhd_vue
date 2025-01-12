<?php

use App\Http\Controllers\api\Auth\AuthController;
use App\Http\Controllers\api\etc\EtcSummaryController;
use App\Http\Controllers\api\etc\MonthlyController;
use App\Http\Controllers\api\Realtime\RealtimeDataController;
use App\Http\Controllers\api\Summary\DailyReportController;
use App\Http\Controllers\api\Summary\MonthlyReportController;
use App\Http\Controllers\api\Summary\YearlyReportController;
use App\Http\Controllers\api\GraphController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Graph controller
Route::get('/graph', [GraphController::class, 'index']);

// realtime data
Route::controller(RealtimeDataController::class)->prefix('realtime')->group(function(){
    Route::get('/request','realtimeRequest');
    Route::post('/show','realTimeShow');
    Route::post('/lanewise/show','laneShow');
});
Route::get('/realtime',[RealtimeDataController::class,'index']);


Route::controller(DailyReportController::class)->prefix('summary')->group(function (){
    Route::get('/daily/report','dailyRequest');
    Route::post('/daily/report/show','dailyShow');
});

Route::controller(MonthlyReportController::class)->prefix('summary/monthly/')->group(function(){
    Route::get('/','monthlyRequest');
    Route::post('/show', "monthlyShow");
});

Route::controller(YearlyReportController::class)->prefix('summary/yearly/')->group(function(){
    Route::get('/','yearlyRequest');
    Route::post('/show','yearlyShow');
});

Route::controller(EtcSummaryController::class)->prefix('etc/summary/')->group(function(){
   Route::get('/','etcRequest');
   Route::post('show','etcShow');
});
Route::controller(MonthlyController::class)->prefix('etc/monthly')->group(function(){
    Route::get('/','monthlyRequest');
    Route::post('/show', "monthlyShow");
});

Route::get('/', [AuthController::class, 'login'])->name('login.index');
Route::post('/login', [AuthController::class, 'loginStore'])->name('login.store');
//Route::post("/logout", [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name("logout");



Route::fallback(function () {
    return abort(404);
})->name('fallback');
