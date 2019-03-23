<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SquareReceipt extends Model
{
    protected $fillable = ['date'];
    protected $hidden = ['created_at', 'updated_at'];

    public function items()
    {
        return $this->hasMany('App\SquareReceiptItem');
    }

    public function receiptItems()
    {
        return $this->items()->join('accounts', 'accounts.id', 'square_receipt_items.account_id')
            ->selectRaw('square_receipt_items.id, square_receipt_items.square_receipt_id,accounts.id as accountID, 
            accounts.name, square_receipt_items.amount');
    }
}
