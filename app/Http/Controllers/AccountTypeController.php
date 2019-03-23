<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountType;

class AccountTypeController extends BaseController
{
    public function get()
    {
        $accountTypes = AccountType::where('is_active', 1)->orderBy('name', 'asc')->get();

        return $this->sendResponse(
            ['name' => 'accountTypes', 'value' => $accountTypes],
            'Account types retrieved successfully'
        );
    }
}
