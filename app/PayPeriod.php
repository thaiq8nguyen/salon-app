<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayPeriod extends Model
{
    protected $fillable = ['begin_date','end_date','pay_date', 'is_paid'];
    protected $hidden = ['created_at', 'updated_at'];
}
