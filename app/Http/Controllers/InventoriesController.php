<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Product;
use App\DrugType;
use App\GenericName;
use App\Supplier;
use App\Manufacturer;
use App\Batch;

class InventoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batches = Batch::
        orderBy('id','des')
        ->paginate(10);
        return view('inventories.index')->with('batches',$batches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventories.create');
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
            'brandName' => 'required',
            'genericName' => 'required',
            'manufacturer' => 'required',
            'drugType' => 'required',
            'expirationDate' => 'required',
            'deliveryDate' => 'required',
            'nameOfSupplier' => 'required',
            'quantity' => 'required',
            'batchNumber' => 'required'
        ]);

        // saving to database
        $batch = new Batch();
        $batch = Batch::firstOrCreate([
            'id' => $request->input('batchNumber'),
        ]);

        $genericName = new GenericName();
        $genericName = GenericName::firstOrCreate(
            ['description' => $request->input('genericName')]
        );

        $drugType = new DrugType();
        $drugType = DrugType::firstOrCreate(
            ['description' => $request->input('drugType')]
        );

        $manufacturer = new Manufacturer();
        $manufacturer = Manufacturer::firstOrCreate([
            'name' => $request->input('manufacturer')
        ]);

        $supplier = new Supplier();
        $supplier = Supplier::firstOrCreate([
            'name' => $request->input('nameOfSupplier')
        ]);

        $product = new Product();
        $product = Product::firstOrCreate([
            'brand_name' => $request->input('brandName'),
            'manufacturer_id' => $manufacturer->id,
            'generic_name_id' => $genericName->id,
            'drug_type_id' => $drugType->id
        ]);

        $inventory = new Inventory();
        $inventory = Inventory::create([
            'quantity' => $request->input('quantity'),
            'sold' => 0,
            'expiration_date' => $request->input('expirationDate'),
            'batch_number' => $batch->id,
            'supplier_id' => $supplier->id,
            'product_id' => $product->id,
            'delivery_date' => $request->input('deliveryDate')
        ]);

        return redirect('/inventories')->with('success', 'Inventory successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
