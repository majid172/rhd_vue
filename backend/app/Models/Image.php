<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $connection = 'image';
    protected $table = 'images';

    public function transaction()
    {
        return $this->hasOne(AllTransaction::class, 'image_name', 'image_name');
    }
}
