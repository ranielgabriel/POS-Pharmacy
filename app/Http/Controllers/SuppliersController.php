<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name')
        ->get();
        return view('suppliers.index')->with('suppliers', $suppliers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.create');
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
            'supplierName' => 'required',
            'address' => 'required',
            'ltoNumber' => 'required',
            'expirationDate' => 'required|date|after:today',
            'contactPerson' => 'required',
            'contactNumber' => 'required',
            'emailAddress' => 'required|email'
        ]);

        // create supplier
        $supplier = Supplier::create([
            'name' => $request->input('supplierName'),
            'address' => $request->input('address'),
            'email_address' => $request->input('emailAddress'),
            'lto_number' => $request->input('ltoNumber'),
            'expiration_date' => $request->input('expirationDate'),
            'contact_person' => $request->input('contactPerson'),
            'contact_number' => $request->input('contactNumber')
        ]);

        // redirect to index of products
        return redirect('/suppliers')->with('success', 'Supplier successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);
        return view('suppliers.show')->with('supplier', $supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
