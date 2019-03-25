<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-13
 * Time: 14:24
 */

namespace App\Bookkeeping\SquareReceipt;

use Carbon\Carbon;
use App\SquareReceipt;
use App\SquareReceiptItem;

class SquareReceiptRepository implements SquareReceiptInterface
{
    public function getSquareReceipt($date)
    {

        $sale = SquareReceipt::with('receiptItems')->where('date', $date)->first();

        return $sale;
    }

    public function updateSquareReceipt($date)
    {
        if ($date) {
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        } else {
            $carbonDate = Carbon::now()->startOfDay();
        }

        $results = [];

        $client = new SquareClient();

        $items = $client->getSquareReceipt($carbonDate);

        $sale = SquareReceipt::updateOrCreate(['date' => $date]);

        foreach ($items as $item) {
            $receiptItems = SquareReceiptItem::updateOrCreate(
                ['square_receipt_id' => $sale->id, 'account_id' => $item['accountID']],
                ['account_id' => $item['accountID'], 'amount' => $item['amount']]
            );
            array_push($results, $receiptItems);
        }

        return $results;
    }

    public function testUpdateSquareReceipt($date)
    {
        $results = [];
        $carbonDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();

        $client = new SquareClient();

        $items = $client->getSquareReceipt($carbonDate);

        return $items;
    }

    public function redeemGiftCard($redeem)
    {
        $item = SquareReceiptItem::find($redeem['receiptItemID']);

        $item->amount = $redeem['amount'];

        $item->save();

        return $item;
    }


}
