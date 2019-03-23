<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-13
 * Time: 09:44
 */

namespace App\Bookkeeping\SquareReceipt;

use Carbon\Carbon;
use GuzzleHttp\Client;

use Config;

class SquareClient
{
    protected $client;
    protected $requestHeaders;
    protected $dates;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://connect.squareup.com/v1/']);
        $this->requestHeaders = ['Authorization' => Config::get('square.Authorization'),
            'Accept' => 'application/json'];
    }



    public function getPayments($date)
    {
        $this->setDatesQuery($date);

        $requestPath = Config::get('square.LocationID') . '/payments?' . $this->dates;

        $payments = [];

        $moreResult = true;

        while ($moreResult) {
            $response = $this->client->get($requestPath, ['headers' => $this->requestHeaders]);

            $payments = array_merge($payments, \GuzzleHttp\json_decode($response->getBody()));
            if (array_key_exists('Link', $response->getHeaders())) {
                $paginationHeader = $response->getHeaders()['Link'][0];
                if (strpos($paginationHeader, "rel='next'") !== false) {
                    $requestPath = explode('>', explode('<', $paginationHeader)[1])[0];
                } else {
                    $moreResult = false;
                }
            } else {
                $moreResult = false;
            }
        }
        $seenPaymentID = [];
        $uniquePayments = [];

        foreach ($payments as $payment) {
            if (array_key_exists($payment->id, $seenPaymentID)) {
                continue;
            }
            $seenPaymentID[$payment->id] = true;
            array_push($uniquePayments, $payment);
        }
        return $payments;
    }

    public function getSquareReceipt($date)
    {
        $creditCardTip = 0;
        $merchantFee = 0;
        $refund = 0;
        $discount = 0;

        $cash = 0;
        $creditCard = 0;
        $convenienceFee = 0;
        $giftCardSold = 0;

        $payments = $this->getPayments($date);

        foreach ($payments as $payment) {
            $creditCardTip += $payment->tip_money->amount;
            $merchantFee += $payment->processing_fee_money->amount;
            $refund += $payment->refunded_money->amount;
            $discount += $payment->discount_money->amount;

            foreach ($payment->tender as $tender) {
                if ($tender->type == 'CASH') {
                    $cash += $tender->total_money->amount;
                } elseif ($tender->type == 'CREDIT_CARD') {
                    $creditCard += $tender->total_money->amount;
                }
            }
            foreach ($payment->itemizations as $item) {
                if ($item->name == 'Convenience Fee') {
                    $convenienceFee += $item->gross_sales_money->amount;
                } elseif ($item->name == 'Gift Certificate') {
                    $giftCardSold += $item->gross_sales_money->amount;
                }
            }
        }
        return [
                ['accountID' => 5, 'amount' => $this->formatMoney($creditCardTip)],
                ['accountID' => 7, 'amount' => $this->formatMoney(abs($merchantFee))],
                ['accountID' => 8, 'amount' => $this->formatMoney($refund)],
                ['accountID' => 9, 'amount' => $this->formatMoney($discount)],
                ['accountID' => 1, 'amount' => $this->formatMoney($cash)],
                ['accountID' => 2, 'amount' => $this->formatMoney($creditCard)],
                ['accountID' => 10, 'amount' => 0.0], // Gift Card Redeem
                ['accountID' => 3, 'amount' => $this->formatMoney($giftCardSold)], //Gift Card Sold
                ['accountID' => 6, 'amount' => $this->formatMoney($convenienceFee)]
        ];
        /*return [
            ['accountName' => 'creditCardTip', 'amount' => $this->formatMoney($creditCardTip)],
            ['accountName' => 'merchantFee', 'amount' => $this->formatMoney(abs($merchantFee))],
            ['accountName' => 'refund', 'amount' => $this->formatMoney($refund)],
            ['accountName' => 'discount', 'amount' => $this->formatMoney($discount)],
            ['accountName' => 'cashReceipt', 'amount' => $this->formatMoney($cash)],
            ['accountName' => 'creditCardReceipt', 'amount' => $this->formatMoney($creditCard)],
            ['accountName' => 'giftCardRedeem', 'amount' => 0.0], // Gift Card Redeem
            ['accountName' => 'giftCardSold', 'amount' => $this->formatMoney($giftCardSold)], //Gift Card Sold
            ['accountName' => 'convenienceFee', 'amount' => $this->formatMoney($convenienceFee)]
        ];*/
    }


    /**
     *
     * @param Carbon $beginTime
     */
    private function setDatesQuery(Carbon $beginTime)
    {
        $newTime = clone $beginTime;
        $endTime = $newTime->addDay();

        $this->dates = http_build_query([
            'begin_time' => $beginTime->toIso8601String(),
            'end_time' => $endTime->toIso8601String()
        ]);
    }
    private function formatMoney($money)
    {
        return money_format('%+.2n', $money/100);
    }
}
