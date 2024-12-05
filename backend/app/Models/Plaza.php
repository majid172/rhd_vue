<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plaza extends Model
{
    use HasFactory;
    protected $connection = 'oracle';
    protected $table = 'plaza_tb';
    protected $primaryKey = 'plaza_id';
    protected $guarded = ['id'];

    public function bridges()
    {
        return $this->belongsTo(Bridge::class, 'bridge_id');
    }

}
