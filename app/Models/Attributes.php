<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete


class Attributes extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['attribute_group_id','name'];


}
