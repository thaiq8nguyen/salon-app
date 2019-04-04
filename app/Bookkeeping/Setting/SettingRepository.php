<?php

namespace App\Bookkeeping\Setting;

use Carbon\Carbon;

class SettingRepository implements SettingInterface
{
    public function settings()
    {
        $setting = [];

        $today = Carbon::now()->format('Y-m-d');

        return ['endDate' => $today];
    }

}
