<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Bookkeeping\TechnicianSale\TechnicianSaleInterface;

class TechnicianSaleController extends BaseController
{
    protected $sale;

    public function __construct(TechnicianSaleInterface $sale)
    {
        $this->sale = $sale;
    }

    public function get(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required|date',
            'sales' => 'required'
        ]);

        if ($validation->fails()) {
            return $this->sendError('Missing request parameters', $validation->errors(), 400);
        }

        $result = '';
        $message = '';

        if ($request->has('date') && $request->has('sales')) {
            if ($request->input('sales') == 'yes') {
                $result = $this->sale->getTechniciansWithSale($request->input('date'));
            } elseif ($request->input('sales') == 'no') {
                $result = $this->sale->getTechniciansWithNoSale($request->input('date'));
            }
            $message = 'Technician sales are retrieved successfully';
        }

        return $this->sendResponse(['name' => 'technicians', 'value' => $result], $message);
    }

    public function add(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required|date',
            'sales.*.technicianID' => 'required|exists:technicians,id',
            'sales.*.amount' => 'required|numeric|between:1,500',
            'sales.*.tipAmount' => 'numeric|between:0,200'
        ]);

        if ($validation->fails()) {
            return $this->sendError("Missing request parameters", $validation->errors(), 400);
        }

        $result = $this->sale->add($request->all());

        $message = 'Technician sales are recorded successfully';

        return $this->sendResponse(['name' => 'sale', 'value' => $result], $message);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|exists:technician_sales,id',
            'saleAmount' => 'required|numeric|between:1,500',
            'tipAmount' => 'numeric|between:0,200'
        ]);

        if ($validation->fails()) {
            return $this->sendError('Missing request parameters', $validation->errors(), 400);
        }

        $result = $this->sale->update($request->all());
        $message = 'Technician sale is updated successfully';

        return $this->sendResponse(['name' => 'sale', 'value' => $result], $message);
    }

    public function delete($saleID)
    {
        $validation = Validator::make(['saleID' => $saleID], [
            'saleID' => 'required|exists:technician_sales,id'
        ]);

        if ($validation->fails()) {
            return $this->sendError('Missing sale id', $validation->errors(), 400);
        }
        $result = $this->sale->delete($saleID);
        $message = 'Technician sale is deleted successfully';

        return $this->sendResponse(['name' => 'sale', 'value' => $result], $message);
    }

}
