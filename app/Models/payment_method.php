<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete


class payment_method extends Model
{
    use HasFactory;
    protected $fillable = ['id','p_transaction_id','p_user_id','p_money','p_note','p_vnp_reponse_code','p_code_vnpay','p_code_bank','p_time'];
}
