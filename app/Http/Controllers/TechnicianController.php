<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Bookkeeping\Technician\TechnicianInterface;

class TechnicianController extends BaseController
{
    protected $technician;

    public function __construct(TechnicianInterface $technician)
    {
        $this->technician = $technician;
    }

    public function getActive()
    {
        $technicians = $this->technician->active();
        $result = ['name' => 'technicians', 'value' => $technicians];

        return $this->sendResponse($result, 'Active technicians retrieved successfully');
    }

    public function add(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phone' => 'required|unique:technicians,phone'
        ]);

        if ($validation->fails()) {
            return $this->sendError('Invalid request parameters', $validation->errors(), 401);
        }

        $newTechnician = $this->technician->add($request->all());

        return $this->sendResponse([
            'name' => 'technician', 'value' => $newTechnician], 'New technician added successfully');
    }

}
