<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCin extends Model
{
    use HasFactory;

    protected $fillable = [
        'cin',
        'cin_image_front',
        'cin_image_back',
        'customer_id',
        'user_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
