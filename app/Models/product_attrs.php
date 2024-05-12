<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Product_attrs extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','attribute_color_id','image','stock','price'];

    public function getColor($attribute_color_id)
    {
        return $color = DB::table('attributes')->where('id',$attribute_color_id)->first();

    }
    public function getSize($attribute_size_id)
    {
        return $color = DB::table('attributes')->where('id',$attribute_size_id)->first();

    }
}