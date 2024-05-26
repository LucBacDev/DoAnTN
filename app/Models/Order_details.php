<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete


class Order_details extends Model
{
    use HasFactory;
    protected $fillable = ['id','order_id', 'pro_id', 'name','color','size', 'quantity', 'unit_price', 'size', 'status', 'created_at', 'updated_at'];
}
