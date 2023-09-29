<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDriverLicence extends Model
{
    use HasFactory;

    protected $fillable =[
        'driver_licence',
        'driver_licence_image_front',
        'driver_licence_image_back',
        'customer_id',
        'user_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
