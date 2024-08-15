<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'order_project';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'order_code',
        'order_name',
        'order_owner',
        'status',
        'create_date',
        'total_price',
        'VAT'
    ];
}
