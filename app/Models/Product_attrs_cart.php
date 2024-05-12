<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_attrs_cart extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','attribute_color_id','attribute','image','stock'];

}
