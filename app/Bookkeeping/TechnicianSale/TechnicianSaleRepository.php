<?php

namespace App\Bookkeeping\TechnicianSale;

use App\Technician;
use App\TechnicianSale;

class TechnicianSaleRepository implements TechnicianSaleInterface
{
    public function getTechniciansWithSale($date)
    {
        $technicianSales = Technician::with(['sale' => function ($query) use ($date) {
            $query->where('date', $date);
        }])->whereHas('sale', function ($query) use ($date) {
            $query->where('date', $date);
        })->orderBy('first_name', 'asc')->get();

        return $technicianSales->makeHidden(['phone', 'email']);
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
        foreach ($sales['sales'] as $sale) {
            $newSale = TechnicianSale::create(['technician_id' => $sale['technicianID'],
                    'date' => $sales['date'],
                'sale_amount' => $sale['amount'], 'tip_amount' => $sale['tipAmount']]);

        }
        return 'success';
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
}
