<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Supplier;

class SuppliersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('auth');
        // ->except(['index', 'show']);
    }
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
        if($supplier == null){
            return redirect('/suppliers')->with('error','The supplier you want see does not exist.');
        }else{
            return view('suppliers.show')->with('supplier', $supplier);
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
        $supplier = Supplier::find($id);
        if($supplier == null){
            return redirect('/suppliers')->with('error','The supplier you want see does not exist.');
        }else{
            return view('suppliers.edit')->with('supplier', $supplier);
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
            'supplierName' => 'required',
            'address' => 'required',
            'ltoNumber' => 'required',
            'expirationDate' => 'required|date|after:today',
            'contactPerson' => 'required',
            'contactNumber' => 'required',
            'emailAddress' => 'required|email'
        ]);
        
        $supplier = Supplier::find($id);
        $supplier->name = $request->input('supplierName');
        $supplier->address = $request->input('address');
        $supplier->email_address = $request->input('emailAddress');
        $supplier->lto_number = $request->input('ltoNumber');
        $supplier->expiration_date = $request->input('expirationDate');
        $supplier->contact_person = $request->input('contactPerson');
        $supplier->contact_number = $request->input('contactNumber');
        $supplier->save();

        return redirect('/suppliers/' . $id)->with('success', 'Supplier information has been updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        DB::table('inventories')->where('supplier_id', '=', $id)->delete();

        return redirect('/suppliers')->with('success', 'Supplier has been deleted successfully.');
    }
}
