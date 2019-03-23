<?php

namespace App\Http\Controllers;

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

}
