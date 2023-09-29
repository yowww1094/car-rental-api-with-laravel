<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'model',
        'model_year',
        'vignette',
        'vehicle_image',
        'manufacturer_id',
        'user_id',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(VehicleManufacturer::class);
    }

    public function insurances()
    {
        return $this->hasMany(VehicleInsurance::class)->latest();
    }

    public function maintenances()
    {
        return $this->hasMany(VehicleMaintenance::class)->latest();
    }

    public function mileages()
    {
        return $this->hasMany(VehicleMileage::class)->latest();
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
