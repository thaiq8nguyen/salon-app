<?php

namespace App\Bookkeeping\TechnicianSale;

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
