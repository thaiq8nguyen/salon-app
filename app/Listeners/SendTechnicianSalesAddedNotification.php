<?php

namespace App\Listeners;

use App\Events\TechnicianSalesAddedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\TechnicianSalesAddedMail;

use App\Bookkeeping\SquareReceipt\SquareReceiptInterface;
use App\Bookkeeping\TechnicianSale\TechnicianSaleInterface;

class SendTechnicianSalesAddedNotification
{
    public $squareReceipt;
    public $technicianSale;

    public function __construct(SquareReceiptInterface $squareReceipt, TechnicianSaleInterface $technicianSale)
    {
        $this->squareReceipt =  $squareReceipt;
        $this->technicianSale = $technicianSale;
    }

    /**
     * Handle the event.
     *
     * @param  $date
     * @return void
     */
    public function handle($date)
    {
        // Get Square Receipt

        $squareReceipt = $this->squareReceipt->getSquareReceipt($date);
        $receiptItems = $squareReceipt['receiptItems']->toArray();
        $squareReceiptItem['creditCardTip'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Credit Card Tip';
        }))[0];
        $squareReceiptItem['cashReceipt'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Cash Receipt';
        }))[0];
        $squareReceiptItem['creditCardReceipt'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Credit Card Receipt';
        }))[0];
        $squareReceiptItem['giftCardSold'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Gift Card Sold';
        }))[0];
        $squareReceiptItem['giftCardRedeem'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Gift Card Redeem';
        }))[0];
        $squareReceiptItem['merchantFee'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Merchant Fee';
        }))[0];
        $squareReceiptItem['convenienceFee'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Convenience Fee';
        }))[0];
        $squareReceiptItem['discount'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Discount';
        }))[0];
        $squareReceiptItem['otherReceipt'] = array_values(array_filter($receiptItems, function ($item) {
            return $item['name'] == 'Other Receipt';
        }))[0];

        // Get Technician Sales

        $technicianSales = ['sales' => $this->technicianSale->getTechniciansWithSale($date),
            'totalSaleAmount' => $this->technicianSale->getTotalSaleAmount($date),
            'totalTipAmount' => $this->technicianSale->getTotalTipAmount($date)
        ];

        // Compare Square Receipt with Technician Sales

        $summary['technicianSaleTotalCollected'] =
            $technicianSales['totalSale']['amount'] +
            $squareReceiptItem['creditCardTip']['amount'] +
            $squareReceiptItem['convenienceFee']['amount'] -
            $squareReceiptItem['giftCardRedeem']['amount'] +
            $squareReceiptItem['giftCardSold']['amount'];

        $summary['squareReceiptTotalCollected'] =
            $squareReceiptItem['cashReceipt']['amount'] +
            $squareReceiptItem['creditCardReceipt']['amount'];

        // Send email

        $mail = new TechnicianSalesAddedMail($squareReceipt, $technicianSales, $summary);

        Mail::to('discoverylight@yahoo.com')->send($mail);
    }
}
