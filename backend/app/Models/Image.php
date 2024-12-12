<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $connection = 'image';
    protected $table = 'images';

    public function allTransactions()
    {
        return $this->hasOne(AllTransaction::class, 'image_name', 'image_name'); // Adjust as necessary
    }


    public function getImageData()
    {
        return $this->image_data ? base64_encode($this->image_data) : null;
    }
}
