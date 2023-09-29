<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerCin;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerDriverLicence;
use App\Http\Requests\CustomerRequest;

class CustomersController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with('cin')->paginate(10);

        if (!$customers) {
            return $this->error('', 'Customer not found', 404);
        }

        return $this->success([
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $request->validated();

        $customer = new Customer;
        $cin = new CustomerCin;
        $driver_licence = new CustomerDriverLicence;

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->user_id = Auth::user()->id;
        
        $cin->cin = $request->cin;
        $cin->cin_image_front = $request->cin_image_front;
        $cin->cin_image_back = $request->cin_image_back;

        $driver_licence->driver_licence = $request->driver_licence;
        $driver_licence->driver_licence_image_front = $request->driver_licence_image_front;
        $driver_licence->driver_licence_image_back = $request->driver_licence_image_back;

        $customer->save();
        $customer->cin()->save($cin);
        $customer->driver_licence()->save($driver_licence);

        if (!$customer) {
            return $this->success('', 'Something went wrong!');
        }

        return $this->success($customer, 'Customer Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with('cin')->with('driver_licence')->find($id);

        if(!$customer){
            return $this->error('', 'Customer not found', 404);
        }

        return $this->success([
                'customers' => $customer,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $request->validated();

        $customer = Customer::findOrFail($id);

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->user_id = Auth::user()->id;

        $cin = [];
        $cin['cin'] = $request['cin'];
        $cin['cin_image_front'] = $request['cin_image_front'];
        $cin['cin_image_back'] = $request['cin_image_back'];

        $driver_licence = [];
        $driver_licence['driver_licence'] = $request['driver_licence'];
        $driver_licence['driver_licence_image_front'] = $request['driver_licence_image_front'];
        $driver_licence['driver_licence_image_back'] = $request['driver_licence_image_back'];

        $customer->save();
        $customer->cin()->update($cin);
        $customer->driver_licence()->update($driver_licence);

        if (!$customer) {
            return $this->error('', 'Something went wrong!', 500);
        }

        return $this->success($customer, 'Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::with('cin')->with('driver_licence')->findOrFail($id);
        $customer->delete();

        if (!$customer) {
            return $this->error('', 'Something went wrong!', 500);
        }

        return $this->success('', 'Customer Deleted Successfully');
    }
}
