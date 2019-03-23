<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['date', 'memo'];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function transactionItems()
    {
        return $this->hasMany('App\TransactionItem');
    }
}
