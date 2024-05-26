<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete


class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['full_name', 'email','address', 'password','status','active_token','forgot_token','role','phone'];
}
