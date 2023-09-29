<?php

namespace App\Http\Controllers;

use App\Models\VehicleManufacturer;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class VehicleManifacturersController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufacturers = VehicleManufacturer::all();

        if (!$manufacturers) {
            return $this->error('', 'Manufacturers not found!', 404);
        }

        return $this->success($manufacturers);
    }
}
