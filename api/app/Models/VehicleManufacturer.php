<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer',
    ];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }
}
