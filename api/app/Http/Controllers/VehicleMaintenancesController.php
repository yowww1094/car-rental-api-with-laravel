<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleMaintenance;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VehicleMaintenanceRequest;
use App\Traits\HttpResponses;

class VehicleMaintenancesController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maintenance = VehicleMaintenance::with('vehicle')->paginate(10);

        if (!$maintenance) {
            return $this->error('', 'Maintenances not found', 404);
        }

        return $this->success($maintenance);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleMaintenanceRequest $request, $carId)
    {
        $request->validated();

        $vehicle = Vehicle::find($carId);
        if (!$vehicle) {
            return $this->error('', 'Vehicle not found!', 404);
        }

        $maintenance = new VehicleMaintenance;
        $maintenance['type'] = $request->type;
        $maintenance['garage'] = $request->garage;
        $maintenance['description'] = $request->description;
        $maintenance['price'] = $request->price;
        $maintenance['maintenance_date'] = $request->maintenance_date;
        $maintenance['user_id'] = Auth::user()->id;

        $vehicle->maintenances()->save($maintenance);

        if (!$maintenance) {
            return $this->error('', 'Something went wrong', 404);
        }

        return $this->success($maintenance, 'Maintenance saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($vehicle, $id)
    {
        $vehicle = Vehicle::find($vehicle);
        if (!$vehicle) {
            return $this->error('', 'Vehicle not found', 404);
        }

        $maintenance = $vehicle->maintenances()->with('vehicle')->find($id);
        if (!$maintenance) {
            return $this->error('', 'Maintenance not found', 404);
        }

        return $this->success($maintenance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleMaintenanceRequest $request, $vehicle, $id)
    {
        $request->validated();

        $vehicle = Vehicle::find($vehicle);
        if (!$vehicle) {
            return $this->error('', 'Vehicle not found!', 404);
        }

        $maintenance = VehicleMaintenance::find($id);
        if (!$maintenance) {
            return $this->error('', 'Maintenance not found!', 404);
        }

        $maintenance->update([
            'type' => $request->type,
            'garage' => $request->garage,
            'description' => $request->description,
            'price' => $request->price,
            'maintenance_date' => $request->maintenance_date,
        ]);

        if (!$maintenance) {
            return $this->error('', 'Something went wrong!!!', 500);
        }

        return $this->success($maintenance, 'Maintenance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vehicle, $id)
    {
        $vehicle = Vehicle::find($vehicle);
        if (!$vehicle) {
            return $this->error('', 'Vehicle not found!', 404);
        }

        $maintenance = VehicleMaintenance::find($id);
        if (!$maintenance) {
            return $this->error('', 'Maintenance not found!', 404);
        }

        $maintenance->delete();
        if (!$maintenance) {
            return $this->error('', 'Something went wrong!!!', 500);
        }

        return $this->success('', 'Maintenance deleted successfully');
    }
}
