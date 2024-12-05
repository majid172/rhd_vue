<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $connection = 'oracle';
    protected $table = 'users';

    protected $primaryKey = 'id';
    protected $fillable = [
        'roles',
        'name',
        'username',
        'email_address',
        'nid_id',
        'bridge_id',
        'counter_key',
        'password',
        'images',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function bridges()
    {
        return $this->belongsToMany(Bridge::class);
    }

//    public function transaction()
//    {
//        return $this->hasOne(AllTransaction::class);
//    }
}

