<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMileage extends Model
{
    use HasFactory;

    protected $fillable = [
        'mileage',
        'vehicle_id',
        'user_id',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
