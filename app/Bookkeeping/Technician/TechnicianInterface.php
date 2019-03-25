<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-05
 * Time: 11:42
 */

namespace App\Bookkeeping\Technician;

interface TechnicianInterface
{

    public function active();

    public function add($technician);

}
