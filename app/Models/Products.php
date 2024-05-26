<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['id','name','description','image','category_id','price','sale_price'];

    public function getCategoryName()
    {
        return $this->belongsTo(Categories::class,'category_id');
    }

    public function scopeSearch($query){
        $query = $query->where('name','like','%'.request()->keyword.'%');
        return $query;
    }
    public function imgs()
    {
        return $this ->hasMany(Product_images::class,'product_id');
    }

}


