<?php

namespace App\Bookkeeping\TechnicianSale;

use Carbon\CarbonPeriod;
use App\Technician;
use App\TechnicianSale;

use App\Events\TechnicianSalesAddedEvent;

class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function getTechniciansWithSale($date)
    {
        $technicianSales = Technician::with(['sale' => function ($query) use ($date) {
            $query->where('date', $date);
        }])->whereHas('sale', function ($query) use ($date) {
            $query->where('date', $date);
        })->orderBy('first_name', 'asc')->get();

        return $technicianSales->makeHidden(['phone', 'email', 'technician_image']);
    }

    public function getTechniciansWithNoSale($date)
    {
        $technicianSales = Technician::whereDoesntHave('sale', function ($query) use ($date) {
            $query->where('date', $date);
        })->get();

        return $technicianSales->makeHidden(['phone', 'email']);
    }

    public function getTechnicianSalesByPeriod($period)
    {
        /*$technicians = Technician::with(['sales' => function ($query) use ($period) {
            $query->select('technician_id', 'date', 'sale_amount', 'tip_amount')
                ->whereBetween('date', [$period['begin'], $period['end']]);
        }])->whereHas('sales', function ($query) use ($period) {
            $query->whereBetween('date', [$period['begin'], $period['end']]);
        })->get()->makeHidden(['first_name', 'last_name', 'email', 'phone', 'technician_image']);

        $dates = [];

        $period = CarbonPeriod::create($period['begin'], $period['end']);

        foreach ($period as $date) {
            $dates[] =  $date->format('Y-m-d');
        }

        $techs = [];
        $results = [];
        foreach ($dates as $date) {
            foreach ($technicians as $technician) {
                foreach ($technician->sales as $sale) {
                    if ($date == $sale['date']) {
                        $techs[] = [
                            'technician' => $technician['full_name'],
                            'amount' => $sale['sale_amount'],
                            'tip_amount' => $sale['tip_amount']];
                    }
                }
            }
            $results[] = ['date' => $date, 'technicians' => $techs];
        }*/

        $results = TechnicianSale::with(['technician' => function ($query) {
            $query->select(['id', 'last_name', 'first_name', 'technician_image']);
        }])->whereBetween('date', [$period['begin'], $period['end']])->orderBy('date','asc')->get();

        return $results;
    }

    public function add($sales)
    {
        $technicianSales = [];

        foreach ($sales['sales'] as $sale) {
            $technician = Technician::find($sale['technicianID']);
            $sale = new TechnicianSale([
                'date' => $sales['date'],
                'sale_amount' => $sale['amount'],
                'tip_amount' => $sale['tipAmount']
            ]);
            $technicianSale = $technician->sales()->save($sale);
            $technicianSales[] = $technicianSale;


        }

        return $technicianSales;

        //event(new TechnicianSalesAddedEvent($sales['date']));
    }

    public function update($updateSale)
    {
        $sale = TechnicianSale::find($updateSale['saleID']);
        $sale->sale_amount = $updateSale['saleAmount'];
        $sale->tip_amount = $updateSale['tipAmount'];
        $sale->save();

        return $sale;
    }

    public function delete($saleID)
    {
        $sale = TechnicianSale::find($saleID);
        $sale->delete();

        return $sale;
    }

    public function getTotalSaleAmount($date)
    {
        return TechnicianSale::totalSale()->where('date', $date)->first();
    }

    public function getTotalTipAmount($date)
    {
        return TechnicianSale::totalTip()->where('date', $date)->first();
    }

}
