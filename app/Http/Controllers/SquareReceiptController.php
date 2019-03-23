<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Bookkeeping\SquareReceipt\SquareReceiptInterface;

class SquareReceiptController extends BaseController
{
    protected $square;

    public function __construct(SquareReceiptInterface $square)
    {
        $this->square = $square;
    }

    public function getDailySquareReceipt(Request $request)
    {
        $results = $this->square->getSquareReceipt($request->input('date'));

        return $this->sendResponse(
            ['name' => 'receipts', 'value' => $results],
            'Square receipts retrieved successfully'
        );
    }

    public function redeemGiftCard(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'amount' => 'numeric|between:1,500',
            'receiptItemID' => 'numeric|exists:square_receipt_items,id'
        ]);

        if ($validation->fails()) {
            return $this->sendError('Invalid request parameters', $validation->errors(), 400);
        }

        $result = $this->square->redeemGiftCard($request->all());

        return $this->sendResponse(
            ['name' => 'redeemed', 'value' => $result],
            'Gift card has been redeemed successfully'
        );
    }
}
