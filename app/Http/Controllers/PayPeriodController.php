<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookkeeping\PayPeriod\PayPeriodInterface;

class PayPeriodController extends BaseController
{
    protected $payPeriod;

    public function __construct(PayPeriodInterface $payPeriod)
    {
        $this->payPeriod = $payPeriod;
    }

    public function payPeriod(Request $request)
    {
        $payPeriods = '';
        if ($request->has('filter')) {
            if ($request->input('filter') == 'current') {
                $payPeriods = $this->payPeriod->current();
            }
        }


        return $this->sendResponse(
            [
            'name' => 'payPeriods',
            'value' => $payPeriods
            ],
            'Pay period retrieved successfully'
        );
    }
    public function generatePayPeriods()
    {
        $payPeriods = $this->payPeriod->generatePayPeriods();

        return $this->sendResponse([
            'name' => 'payPeriods',
            'value' => $payPeriods], 'Pay periods generated successfully');
    }
}
