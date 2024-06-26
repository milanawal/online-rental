<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table='profile';
    protected $fillable=[
        'user_id',
        'first_name',
        'last_name',
        'country',
        'state',
        'district',
        'city',
        'address_1',
        'address_2',
        'mobile_1',
        'mobile_2',
        'citizenship',
        'verified',
        'status',
        'created_at',
        'updated_at',
        'pincode'
    ];
}
