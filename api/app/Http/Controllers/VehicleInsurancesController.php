<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleInsurance;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VehicleInsuranceRequest;
use App\Http\Requests\StoreVehicleInsuranceRequest;
use App\Traits\HttpResponses;

class VehicleInsurancesController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insurances = VehicleInsurance::with('vehicle')->paginate(10);

        if (!$insurances) {
            return $this->error('', 'Insurances not found', 404);
        }

        return $this->success($insurances);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleInsuranceRequest $request, $carId)
    {
        $request->validated();

        $vehicle = Vehicle::find($carId);

        if (!$vehicle) {
            return $this->error('', 'Vehicle not found!', 404);
        }

        $insurance = new VehicleInsurance;
        $insurance['number'] = $request->number;
        $insurance['agence'] = $request->agence;
        $insurance['date_start'] = $request->date_start;
        $insurance['date_end'] = $request->date_end;
        $insurance['price'] = $request->price;
        $insurance['user_id'] = Auth::user()->id;

        $vehicle->insurances()->save($insurance);

        if (!$vehicle) {
            return $this->error('', 'Something went wrong', 404);
        }

        return $this->success($vehicle, 'Insurance saved successfully');
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

        $insurance = $vehicle->insurances()->with('vehicle')->find($id);
        if (!$insurance) {
            return $this->error('', 'Insurance not found', 404);
        }

        return $this->success($insurance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleInsuranceRequest $request, $vehicle, $id)
    {
        $request->validated();
        $vehicle = Vehicle::find($vehicle);
        if (!$vehicle) {
            return $this->error('', 'Vehicle not found', 404);
        }

        $insurance = $vehicle->insurances()->find($id);
        if (!$insurance) {
            return $this->error('', 'Insrurance not found', 404);
        }
        $insurance->update([
            'number' => $request->number,
            'agence' => $request->agence,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'price' => $request->price,
        ]);

        if (!$insurance) {
            return $this->error('', 'Something went wrong!!!', 500);
        }

        return $this->success($insurance, 'Insurance updated successfully');
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
            return $this->error('', 'Vehicle not found', 404);
        }

        $insurance = $vehicle->insurances()->find($id);
        if (!$insurance) {
            return $this->error('', 'Insrurance not found', 404);
        }
        $insurance->delete();

        if (!$insurance) {
            return $this->error('', 'Something went wrong', 500);
        }

        return $this->success('', 'Insurance deleted successfully');
    }
}
