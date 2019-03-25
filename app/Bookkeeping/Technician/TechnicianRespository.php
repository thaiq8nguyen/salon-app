<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-05
 * Time: 11:44
 */

namespace App\Bookkeeping\Technician;

use App\Technician;

class TechnicianRepository implements TechnicianInterface
{
    public function active()
    {
        $result = Technician::where('is_active', 1)->get();

        return $result;
    }

    public function add($technician)
    {
        $result = Technician::create([
            'first_name' => $technician['firstName'], 'last_name' => $technician['lastName'],
            'email' => $technician['email'], 'phone' => $technician['phone'], 'is_active' => 1
        ]);

        return $result;
    }
}
