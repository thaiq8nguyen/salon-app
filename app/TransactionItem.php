<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['transaction_id', 'account_id', 'amount', 'memo', 'reference'];
    protected $hidden = ['created_at', 'updated_at'];

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }
}
