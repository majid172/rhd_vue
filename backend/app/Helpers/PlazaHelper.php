<?php


namespace App\Helpers;

use App\Models\Plaza;
use App\Models\Bridge;
use App\Models\NewEtcWallet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class PlazaHelper
{

    public static function getPlazaIds($request)
    {

        $plazaIds = [];

        if ($request->plaza_id == 'all_plaza') {
            $selectedBridgeId = $request->selectedBridgeId;
            $bridge = Bridge::findOrFail($selectedBridgeId);
            $plazaIds = $bridge->plazas()->pluck('plaza_id')->toArray();

        } else {
            $plazaIds[] = $request->plaza_id;
        }

        return $plazaIds;

    }



    public static function getDateRangeAndShift($request)
    {

        $validator = Validator::make($request->all(), [
            'inputDate' => 'required|date',
            'inputStartTime' => 'required|date_format:H:i:s',
            'inputEndTime' => 'required|date_format:H:i:s|after:inputStartTime',
            'shift' => 'nullable|in:all_shift,first_shift,second_shift,third_shift,custom',
        ]);
        if ($validator->fails()) {

            throw new ValidationException($validator);
        }
        $inputDate = $request->input('inputDate');
        $inputFromTime = $request->input('inputStartTime');
        $inputToTime = $request->input('inputEndTime');

        $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate $inputFromTime");
        $endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate $inputToTime");

        $shift = $request->input('shift', null);

        if ($shift) {
            switch ($shift) {
                case 'All Shifts':
                    $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 00:00:00");
                    $endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 23:59:59");
                    break;
                case 'Shift-1':
                    $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 00:00:00");
                    $endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 08:00:00");
                    break;
                case 'Shift-2':
                    $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 08:00:00");
                    $endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 16:00:00");
                    break;
                case 'Shift-3':
                    $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 16:00:00");
                    $endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', "$inputDate 23:59:59");
                    break;
                default:
                    break;
            }
        }

        return [
            'startOfDay' => $startOfDay,
            'endOfDay' => $endOfDay,
            'inputDate' => $inputDate,
        ];
    }

    public static function getBridgeAndPlazaNames($request)
    {

        $data = DB::table('bridges')
            ->join('plaza_tb', 'bridges.id', '=', 'plaza_tb.bridge_id')
            ->where('bridges.id', $request->selectedBridgeId)
            ->where('plaza_tb.plaza_id', $request->plaza_id)
            ->select('bridges.bridge_name', 'plaza_tb.plaza_name')
            ->first();

        return $data;
    }

    public static function getDateRange($request){

        $inputFromTime = "00:00:00";
        $inputToTime = "23:59:59";

        $inputStartDate = $request->input('startDate');
        $inputEndDate = $request->input('endDate');

        $startOfDay = Carbon::parse("$inputStartDate $inputFromTime");
        $endOfDay = Carbon::parse("$inputEndDate $inputToTime");

        return [
            'startOfDay' => $startOfDay,
            'endOfDay' => $endOfDay,
        ];

    }

    public static function getLanes($bridge){

        if($bridge == 'sitolokkha'){
            $lanes = array(
                '0' => 1,
                '1' => 2,
                '2' => 3,
                '3' => 4,
                '4' => 5,
                '5' => 6,
            );
        }
        elseif($bridge == 'meghna'){
            $lanes = array(
                '0' => 1,
                '1' => 2,
                '2' => 3,
                '3' => 4,
                '4' => 5,
                '5' => 6,
                '6' => 7,
                '7' => 8,
                '8' => 9,
                '9' => 10,
                '10' => 11,
                '11' => 12,
            );
        }
        elseif($bridge == 'bhairab'){
            $lanes = array(
                '0' => 1,
                '1' => 2,
                '2' => 3,

            );
        }
        elseif($bridge == 'ashugong'){
            $lanes = array(
                '0' => 4,
                '1' => 5,
                '2' => 6,

            );
        }
        elseif($bridge == 'bhanga'){
            $lanes = array(
                '0' => 1,
                '1' => 2,
                '2' => 3,
                '3' => 4,
                '4' => 5,
                '5' => 6,
                '6' => 7,
                '7' => 8,
                '8' => 9,
                '9' => 10,
                '10' => 11,
                '11' => 12,

            );
        }
        elseif($bridge == 'gomoti'){
            $lanes = array(
                '0'=>1,
                '1' => 2,
                '2'=>3,
                '3'=>4,
                '4'=>5,
                '5'=>6,
                '6'=>7,
                '7'=>8,
            );
        }
        elseif($bridge == 'charsindur'){
            $lanes = array(
                '0' => 1,
                '1'=>2,
                '2'=>3,
                '3'=>4,
            );
        }
        elseif($bridge == 'karnuphuli'){
            $lanes = array(
                '0' => 1,
                '1'=>2,
                '2'=>3,
                '3'=>4,
                '4'=>5,
                '5'=>6,
                '6'=>7,
                '7'=>8,
            );
        }
        elseif($bridge == 'dhaleshwari'){
            $lanes = array(
                '0' => 1,
                '1' => 2,
                '2' => 3,
                '3' => 4,
                '4' => 5,
                '5' => 6,
                '6' => 7,
                '7' => 8,
                '8' => 9,
                '9' => 10,
                '10' => 11,
                '11' => 12,
            );
        }

        elseif($bridge == 'ghorashal'){
            $lanes = array(
                '0' => 1,
                '1'=>2,
                '2'=>3,
                '3'=>4,
            );
        }

        elseif($bridge == 'karnaphuli'){
            $lanes = array(
                '0' => 1,
                '1'=>2,
                '2'=>3,
                '3'=>4,
                '4'=>5,
                '5'=>6,
                '6'=>7,
                '7'=>8,
            );
        }
        return $lanes;
    }


    public static function getRecognize($bridge){
        if($bridge =='all'){
            $recognizeBy=array(
                '0'=>'RFID',
                '1'=>'ANPR',
                '2'=>'OTHERS'
            );
            return $recognizeBy;
        }
    }

    public static function getClassStatus($bridge){
        if($bridge =='all'){
            $classStatus=array(
                '0'=>'MVC',
                '1'=>'AVC',
            );
            return $classStatus;
        }
    }


    public static function getBankType($bridge){
        if($bridge =='all'){
            $bankType=array(
                '0'=>'1',
                '1'=>'2',
                '2'=>'3',
            );
            return $bankType;
        }
    }

    // public static function newGetBankType($bridge){
    //     if($bridge =='all'){
    //         $bankType=array(
    //             '0'=>'63',
    //             '1'=>'64',
    //             '2'=>'69',
    //         );
    //         return $bankType;
    //     }
    // }

    public static function newGetBankType($bridge) {
        if ($bridge == 'all') {
            $bankType = NewEtcWallet::distinct()->pluck('company_oid')->toArray();
            return $bankType;
        }
    }


    public static function getPaymentType($bridge){
        if($bridge =='all'){
            $paymentType=array(
                '0'=>'1',
                '1'=>'2',
                '2'=>'3',
            );
            return $paymentType;
        }
    }

    public static function getVehicleClass($bridge){
        if($bridge =="all"){
            $vehicleClass=array(
                '0'=>'RICKSHAW/VAN',
                '1'=>'MOTORCYCLE',
                '2'=>'TEMPU/CNG/AUTO',
                '3'=>'SEDAN CAR',
                '4'=>'PICKUP/JEEP/WRECKER/CRANE',
                '5'=>'MICROBUS',
                '6'=>'MINI BUS/COASTER',
                '7'=>'AGRO USE',
                '8'=>'MINI TRUCK',
                '9'=>'LARGE BUS',
                '10'=>'MEDIUM TRUCK',
                '11'=>'HEAVY TRUCK',
                '12'=>'TRAILER',
            );
            return $vehicleClass;
        }
    }

    public static function getPaymentTypeWeigh($bridge){
        if($bridge =='all'){
            $paymentType=array(
                '0'=>'1',
                '1'=>'7',
                '2'=>'8',
            );
            return $paymentType;
        }
    }

    public static function getModel($plazaId)
    {

        switch ($plazaId) {
            case 1:
                $model = 'App\Models\GhorashalData';
                break;
            case 9:
                $model = 'App\Models\CharsindurData';
                break;
            case 3:
                $model = 'App\Models\MeghnaData';
                break;
            case 4:
                $model = 'App\Models\GomotiData';
                break;
            case 5:
                $model = 'App\Models\KarnuphuliData';
                break;
            case 10:
                $model = 'App\Models\DhaleshwariData';
                break;
            case 14:
                $model = 'App\Models\ShitalaKhyaData';
                break;
            case 11:
                $model = 'App\Models\BhangaData';
                break;

            case 201:
                $model = 'App\Models\BhairabData';
                break;
            case 202:
                $model = 'App\Models\BhairabData';
                break;
            default:
                return response()->json(['error' => 'Invalid plaza_id'], 400);

        }
        return $model;
    }



}
