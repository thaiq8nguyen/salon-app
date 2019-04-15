<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SquareReceiptItem extends Model
{
    protected $fillable = ['square_receipt_id', 'account_id', 'amount', 'memo'];
    protected $hidden = ['created_at', 'updated_at'];

    public function squareReceipt()
    {
        // return $this->hasOne('App\SquareReceipt');
        return $this->belongTo('App\SquareReceipt');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }







}
