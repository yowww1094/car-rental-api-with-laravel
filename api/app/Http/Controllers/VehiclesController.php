<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\VehicleMileage;
use App\Models\VehicleInsurance;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;

class VehiclesController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::with('mileages')->paginate(10);

        if (!$vehicles) {
            return $this->error('', 'Vehicles not found', 404);
        }

        return $this->success($vehicles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleRequest $request)
    {
        $request->validated();

        $vehicle = new Vehicle;
        $vehicle->matricule = $request->matricule;
        $vehicle->model = $request->model;
        $vehicle->model_year = $request->model_year;
        $vehicle->vignette = $request->vignette;
        $vehicle->vehicle_image = $request->vehicle_image;
        $vehicle->manufacturer_id = $request->manufacturer_id;
        $vehicle->user_id = Auth::user()->id;

        $insurance = new VehicleInsurance;
        $insurance->number = $request->number;
        $insurance->agence = $request->agence;
        $insurance->date_start = $request->date_start;
        $insurance->date_end = $request->date_end;
        $insurance->price = $request->price;
        $insurance->user_id = Auth::user()->id;

        $mileage = new VehicleMileage;
        $mileage->mileage = $request->mileage;
        $mileage->user_id = Auth::user()->id;

        $vehicle->save();
        $vehicle->insurances()->save($insurance);
        $vehicle->mileages()->save($mileage);

        if (!$vehicle) {
            return $this->error('', 'Something Went Wrong!!!', 500);
        }

        return $this->success($vehicle, 'Vehicle Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = Vehicle::with('mileages')->with('insurances')->with('maintenances')->find($id);

        if (!$vehicle) {
            return $this->error('', 'Vehicle not found', 404);
        }

        return $this->success($vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleRequest $request, $id)
    {
        $request->validated();

        $vehicle = Vehicle::with('mileages')->find($id);

        if (!$vehicle) {
            return $this->error('', 'Vehicle not found!!!', 500);
        }

        $vehicle->model = $request->model;
        $vehicle->model_year = $request->model_year;
        $vehicle->vignette = $request->vignette;
        $vehicle->vehicle_image = $request->vehicle_image;
        $vehicle->manufacturer_id = $request->manufacturer_id;
        $vehicle->user_id = Auth::user()->id;

        $mileage = new VehicleMileage;
        $mileage['mileage'] = $request->mileage;
        $mileage['user_id'] = Auth::user()->id;


        $vehicle->save();
        $vehicle->mileages()->save($mileage);

        return $this->success($vehicle, 'Vehicle Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::with('mileages')->with('insurances')->with('maintenances')->find($id);

        if (!$vehicle) {
            return $this->error('', 'Vehicle not found!', 500);
        }

        $vehicle->delete();
        return $this->success('', 'Vehicle Deleted Successfully');
    }
}
