<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;
    protected $table='order_products';
    protected $fillable=[
        'order_id',
        'product_id',
        'created_at',
        'quantity',
        'start_date',
        'end_date'
    ];
}
