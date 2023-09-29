<?php

namespace Database\Seeders;

use App\Models\VehicleManufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carBrands = [
            ['manufacturer' => 'Volvo'], 
            ['manufacturer' => 'Audi'],
            ['manufacturer' => 'Toyota'],
            ['manufacturer' => 'Mercedes'],
            ['manufacturer' => 'Dacia'],
            ['manufacturer' => 'Skoda'],
        ];

        foreach ($carBrands as $carBrand) {
            VehicleManufacturer::create($carBrand);
        }
            
        
    }
}
