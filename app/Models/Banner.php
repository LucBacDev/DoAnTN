<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete


class Banner extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status','category_id', 'image'];
}
