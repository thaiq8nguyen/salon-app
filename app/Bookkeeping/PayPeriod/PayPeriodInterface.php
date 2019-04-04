<?php

namespace App\Bookkeeping\PayPeriod;

interface PayPeriodInterface
{

    public function current();

    public function previous();

    public function getPayPeriodByID($payPeriodID);

    public function generatePayPeriods();

}
