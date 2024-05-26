<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete


class Product_combination extends Model
{
    use HasFactory;
    protected $fillable = ['product_attribute_id','attribute_id'];

}
