<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllTransaction extends Model
{
    use HasFactory;

    protected $connection = 'oracle';
    protected $table = 'all_transactions_tb';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;
//    public function vehicleRegistration()
//    {
//        return $this->belongsTo(MeghnaVehicleReg::class, 'vehicle_id', 'vehicle_reg_id');
//    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_name', 'image_name'); // Adjust as necessary
    }


    public function plaza()
    {
        return $this->belongsTo(Plaza::class, 'plaza_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

//    public function ntmc()
//    {
//        return $this->belongsTo(MeghnaNtmc::class, 'registration_number', 'registration_number');
//    }

//    public function Cuser()
//    {
//        return $this->belongsTo(MeghnaUser::class, 'canceled_by', 'id');
//    }
}


