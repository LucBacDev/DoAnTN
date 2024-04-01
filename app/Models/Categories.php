<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'status', 'parent_id'];
    use HasFactory;
    public static function search($query){
        $query = $query->where('name','like','%'.request()->keyword.'%');
        return $query;
    }
}