<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Technician
 * @package App
 */
class Technician extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'is_active'];
    protected $hidden = ['user_id','created_at', 'updated_at', 'is_active'];

    public function sales()
    {
        return $this->hasMany('App\TechnicianSale');
    }

    public function sale()
    {
        return $this->hasOne('App\TechnicianSale');
    }




}
