<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['account_type_id', 'name', 'description'];

    public function squareReceiptItems()
    {
        return $this->hasMany('App\SquareReceiptItem');
    }
}
