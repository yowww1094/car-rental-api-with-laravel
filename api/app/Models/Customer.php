<?php

namespace App\Models;

use App\Models\CustomerCin;
use App\Models\CustomerDriverLicence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'user_id',
    ];
    
    public function cin()
    {
        return $this->hasOne(CustomerCin::class);
    }

    public function driver_licence()
    {
        return $this->hasOne(CustomerDriverLicence::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

}
