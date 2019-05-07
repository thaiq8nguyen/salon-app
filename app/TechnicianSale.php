<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TechnicianSale extends Model
{
    protected $fillable = ['technician_id', 'date', 'memo', 'sale_amount', 'tip_amount'];
    protected $hidden = ['created_at', 'updated_at', 'memo'];
    protected $appends = ['day_name'];


    public function technician()
    {
        return $this->belongsTo('App\Technician');
    }

    public function scopeTotalSale($query)
    {
        return $query->selectRaw('SUM(sale_amount) as amount');
    }

    public function scopeTotalTip($query)
    {
        return $query->selectRaw('SUM(tip_amount) as amount');
    }

    public function getDayNameAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['date'])->format('l');
    }


}
