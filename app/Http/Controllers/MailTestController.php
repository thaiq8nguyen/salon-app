<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookkeeping\SquareReceipt\SquareReceiptInterface;
use App\Bookkeeping\TechnicianSale\TechnicianSaleInterface;
use App\Mail\TechnicianSalesAddedMail;

class MailTestController extends Controller
{
    protected $squareReceipt;
    protected $technicianSale;

    public function __construct(SquareReceiptInterface $squareReceipt, TechnicianSaleInterface $technicianSale)
    {
        $this->squareReceipt =  $squareReceipt;
        $this->technicianSale = $technicianSale;
    }
    public function view()
    {
        $squareReceipt = $this->squareReceipt->getSquareReceipt('2019-04-06');
        $totalSaleAmount = $this->technicianSale->getTotalSaleAmount('2019-04-06');
        $totalTipAmount = $this->technicianSale->getTotalTipAmount('2019-04-06');

        $technicianSales = ['sales' => $this->technicianSale->getTechniciansWithSale('2019-04-06'),
            'totalSale' => $totalSaleAmount,
            'totalTip' => $totalTipAmount
        ];
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

        $summary['technicianSaleTotalCollected'] =
            $technicianSales['totalSale']['amount'] +
            $squareReceiptItem['creditCardTip']['amount'] +
            $squareReceiptItem['convenienceFee']['amount'] -
            $squareReceiptItem['giftCardRedeem']['amount'] +
            $squareReceiptItem['giftCardSold']['amount'];

        $summary['squareReceiptTotalCollected'] =
            $squareReceiptItem['cashReceipt']['amount'] +
            $squareReceiptItem['creditCardReceipt']['amount'];

        return new TechnicianSalesAddedMail($squareReceipt, $technicianSales, $summary);
    }
}
