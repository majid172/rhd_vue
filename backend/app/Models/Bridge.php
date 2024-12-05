<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Bridge extends Model
{
    use HasFactory;

    protected $connection = 'oracle';
    protected $table = 'bridges';
    protected $fillable = [
        'id',
        'road_division_name',
        'bridge_name',
        'location',
        'bridge_road_type',
        'short_name',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function plazas()
    {
        return $this->hasMany(Plaza::class, 'bridge_id');
    }
}
