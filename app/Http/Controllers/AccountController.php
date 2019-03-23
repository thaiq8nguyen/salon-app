<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Account;

class AccountController extends BaseController
{
    public function get()
    {
        $accounts = Account::where('is_active', 1)->orderBy('name', 'asc')->get();

        return $this->sendResponse(['name' => 'accounts', 'value' => $accounts], 'Accounts retrieved successfully');
    }

    public function add(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'accountTypeID' => 'required|exists:account_types,id',
            'accountName' => 'required|unique:accounts,name'
        ]);

        if ($validation->fails()) {
            return $this->sendError('Invalid request parameter', $validation->errors(), '401');
        }

        $newAccount = Account::create([
            'account_type_id' => $request->input('accountTypeID'), 'name' => $request->input('accountName')]);

        return $this->sendResponse(['name' => 'accounts', 'value' => $newAccount], 'New account added successfully');
    }
}
