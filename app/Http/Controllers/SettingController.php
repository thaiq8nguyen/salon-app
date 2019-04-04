<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookkeeping\Setting\SettingInterface;

class SettingController extends BaseController
{
    protected $setting;

    public function __construct(SettingInterface $setting)
    {
        $this->setting = $setting;
    }

    public function getSettings()
    {
        $result = $this->setting->settings();

        return $this->sendResponse([
            'name' => 'settings', 'value' => $result], 'Setting parameters retrieved successfully');
    }

}
