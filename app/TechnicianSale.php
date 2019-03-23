<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianSale extends Model
{
    protected $fillable = ['technician_id', 'date', 'memo', 'sale_amount', 'tip_amount'];
    protected $hidden = ['created_at', 'updated_at'];

    public function technician()
    {
        return $this->belongsTo('App\Technician');
    }
}
