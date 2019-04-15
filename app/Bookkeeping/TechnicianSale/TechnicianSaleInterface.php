<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 2019-03-05
 * Time: 11:19
 */
namespace App\Bookkeeping\TechnicianSale;

interface TechnicianSaleInterface
{

    public function getTechniciansWithSale($date);

    public function getTechniciansWithNoSale($date);

    public function add($sales);

    public function update($sale);

    public function delete($saleID);

    public function getTotalSaleAmount($date);

    public function getTotalTipAmount($date);

}
