<?php

namespace App\Bookkeeping\PayPeriod;

use Carbon\Carbon;
use App\PayPeriod;

class PayPeriodRepository implements PayPeriodInterface
{
    public function current()
    {
        $date = Carbon::now()->format('Y-m-d');

        $period = PayPeriod::whereDate('begin_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->firstOrFail();

        return $period;
    }

    public function previous()
    {
    }

    public function getPayPeriodByID($payPeriodID)
    {
    }

    public function generatePayPeriods()
    {
        // Should run every 2 months
        $dates = [];
        $now = Carbon::now();
        $date = Carbon::createFromFormat('Y-m-d', $now->year.'-'.$now->month.'-15');

        // Generate an array containing the pay dates 1 month ahead
        for ($index = 0; $index < 5; $index++) {
            $days = $date->daysInMonth;

            if ($days === 28) {
                if ($date->day === 15) {
                    $date->addDays(13);
                } elseif ($date->day === 28) {
                    $date->addDays(15);
                }
            } elseif ($days === 29) { // Leap year
                if ($date->day === 15) {
                    $date->addDays(14);
                } elseif ($date->day === 29) {
                    $date->addDays(15);
                }
            } elseif ($days == 30) {
                if ($date->day === 15) {
                    $date->addDays(15);

                } elseif ($date->day === 30) {
                    $date->addDays(15);
                }
            } elseif ($days == 31) {
                if ($date->day === 15) {
                    $date->addDays(15);
                } elseif ($date->day === 30) {
                    $date->addDays(16);
                }
            }

            $payDate =  clone $date;
            $dates[] = $payDate;

        }

        //Generate an array containing arrays of period begin date, end date and pay date
        $periods = [];
        for ($index = 0; $index < 4; $index++) {
            $date = clone $dates[$index];

            if ($dates[$index]->day === 30) {
                $payDate = $dates[$index]->format('Y-m-d');
                $beginDate = $dates[$index]->subDays(16)->format('Y-m-d');
                $endDate = $date->subDays(2)->format('Y-m-d');
            } elseif ($dates[$index]->day === 15) {
                if ($dates[$index]->daysInMonth === 30 && $dates[$index-1]->daysInMonth === 31) {
                    $payDate = $dates[$index]->format('Y-m-d');
                    $beginDate = $dates[$index]->subDays(17)->format('Y-m-d');
                    $endDate = $date->subDays(2)->format('Y-m-d');
                } elseif ($dates[$index]->daysInMonth === 31 && $dates[$index-1]->daysInMonth === 30) {
                    $payDate = $dates[$index]->format('Y-m-d');
                    $beginDate = $dates[$index]->subDays(16)->format('Y-m-d');
                    $endDate = $date->subDays(2)->format('Y-m-d');
                } else {
                    $payDate = $dates[$index]->format('Y-m-d');
                    $beginDate = $dates[$index]->subDays(17)->format('Y-m-d');
                    $endDate = $date->subDays(2)->format('Y-m-d');
                }

            }

            array_push($periods, [
                'begin_date' => $beginDate,
                'end_date' => $endDate,
                'pay_date' => $payDate,

                ]);
        }


        foreach ($periods as $period) {
            PayPeriod::create(['begin_date' => $period['begin_date'], 'end_date' => $period['end_date'],
                'pay_date' => $period['pay_date']]);

        }
    }

}
