<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\User;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('name','asc')
        ->get();

        $user = User::find(Auth::user()->id);
        return view('customers.index')->with(['customers' => $customers, 'user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request,[
            'name' => 'required|string',
            'contactNumber' => 'nullable|string',
            'address' => 'nullable|string',
            'details' => 'nullable|string|max:255'
        ]);

        // create new customer
        $customer = new Customer();
        $customer = Customer::create([
            'name' => $request->input('name'),
            'contact_number' => $request->input('contactNumber'),
            'address' => $request->input('address'),
            'details' => $request->input('details'),
        ]);

        // redirect to index of products
        return redirect('/customers')->with('success', 'Customer successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if($customer == null){
            return redirect('/customers')->with('error', 'The customer you want to see does not exist.');
        }else{
            return view('customers.show')->with('customer', $customer);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        if($customer == null){
            return redirect('/customers')->with('error', 'The customer you want to see does not exist.');
        }else{
            return view('customers.edit')->with('customer', $customer);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate request
        $this->validate($request,[
            'name' => 'required|string',
            'contactNumber' => 'nullable|string',
            'address' => 'nullable|string',
            'details' => 'nullable|string|max:255'
        ]);

        $customer = Customer::find($id);
        $customer->name = $request->input('name');
        $customer->contact_number = $request->input('contactNumber');
        $customer->address = $request->input('address');
        $customer->details = $request->input('details');
        $customer->save();

        return redirect('/customers/' . $id)->with('success', 'Customer successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return redirect('/customers')->with('success', 'Customer deleted successfully.');
    }
}
