<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-13
 * Time: 14:24
 */

namespace App\Bookkeeping\SquareReceipt;

interface SquareReceiptInterface
{
    public function getSquareReceipt($date);

    public function updateSquareReceipt($date);

    public function redeemGiftCard($redeem);

    public function testUpdateSquareReceipt($date);

}
