<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;
    protected $table='bank_detail';
    protected $fillable=[
        'id',
        'user_id',
        'bank_name',
        'account_name',
        'account_number',
        'phone_number',
        'status',
        'created_at',
        'updated_at',
        'branch'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
