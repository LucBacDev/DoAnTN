<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_cart extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','price','sale_price','description','size_id','color_id','image','status','category_id','brand_id','origin','year'];

}
