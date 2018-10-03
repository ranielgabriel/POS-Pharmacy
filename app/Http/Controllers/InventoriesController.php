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
        // Get all the batches
        $batches = Batch::
        // Order by Id
        orderBy('id','des')
        ->whereHas('inventories')
        // Paginate by 10 batches per page
        ->paginate(10);

        // return the view index from inventories folder
        return view('inventories.index')->with('batches', $batches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all the suppliers
        $suppliers = Supplier::
        // Order by Name
        orderBy('name')
        ->get();

        // return the view create from inventories folder
        return view('inventories.create')->with('suppliers', $suppliers);
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
            'expirationDate' => 'required|date|after:today',
            'deliveryDate' => 'required|date',
            'quantity' => 'required',
            'batchNumber' => 'required',
            'supplierName' => 'required',
            'address' => 'required',
            'ltoNumber' => 'required',
            'ltoNumberExpirationDate' => 'required|date|after:today',
            'contactPerson' => 'required',
            'contactNumber' => 'required',
            'emailAddress' => 'required|email'
        ]);

        // saving to database

        // find if exist or create if not
        $batch = new Batch();
        $batch = Batch::firstOrCreate([
            'id' => $request->input('batchNumber'),
        ]);

        // find if exist or create if not
        $genericName = new GenericName();
        $genericName = GenericName::firstOrCreate(
            ['description' => $request->input('genericName')]
        );

        // find if exist or create if not
        $drugType = new DrugType();
        $drugType = DrugType::firstOrCreate(
            ['description' => $request->input('drugType')]
        );

        // find if exist or create if not
        $manufacturer = new Manufacturer();
        $manufacturer = Manufacturer::firstOrCreate(
            ['name' => $request->input('manufacturer')]
        );

        // find
        $supplier = new Supplier();
        $supplier = Supplier::firstOrCreate(
            ['name' => $request->input('supplierName'),
            'address' => $request->input('address'),
            'email_address' => $request->input('emailAddress'),
            'lto_number' => $request->input('ltoNumber'),
            'expiration_date' => $request->input('ltoNumberExpirationDate'),
            'contact_person' => $request->input('contactPerson'),
            'contact_number' => $request->input('contactNumber')]
        );

        // find if exist or create if not
        $product = new Product();
        $product = Product::firstOrCreate([
            'brand_name' => $request->input('brandName'),
            'manufacturer_id' => $manufacturer->id,
            'generic_name_id' => $genericName->id,
            'drug_type_id' => $drugType->id
        ]);
        if($product->status == 'Out-of-stock'){
            $product->status = 'In-stock';
            $product->save();
        }

        // create an inventory
        $inventory = new Inventory();
        $inventory = Inventory::create([
            'quantity' => $request->input('quantity'),
            'sold' => 0,
            'expiration_date' => $request->input('expirationDate'),
            'batch_number' => $batch->id,
            'supplier_id' => $supplier->id,
            'product_id' => $product->id,
            'delivery_date' => $request->input('deliveryDate'),
            'isReturn' => 0
        ]);

        // redirect to index of inventories
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
        $batch = Batch::find($id);
        if($batch == null){
            return redirect('/inventories')->with('error','The batch you are looking for does not exist.');
        }else{
            return view('inventories.show')->with('batch', $batch);
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
        // Get all the suppliers
        $suppliers = Supplier::
        // Order by Name
        orderBy('name')
        ->get();

        $inventory = Inventory::find($id);
        if($inventory == null){
            return redirect('/inventories')->with('error','The batch you are looking for does not exist.');
        }else{
            return view('inventories.edit')->with(['inventory' => $inventory, 'suppliers' => $suppliers]);
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
            'brandName' => 'required|exists:products,brand_name',
            'genericName' => 'required|exists:generic_names,description',
            'manufacturer' => 'required|exists:manufacturers,name',
            'drugType' => 'required|exists:drug_types,description',
            'expirationDate' => 'required|date|after:today',
            'deliveryDate' => 'required|date',
            'supplierName' => 'required|exists:suppliers,id',
            'quantity' => 'required',
            'batchNumber' => 'required|exists:batches,id'
        ]);

        // saving to database

        // find if exist or create if not
        $batch = new Batch();
        $batch = Batch::firstOrCreate([
            'id' => $request->input('batchNumber'),
        ]);

        // find if exist or create if not
        $genericName = new GenericName();
        $genericName = GenericName::firstOrCreate(
            ['description' => $request->input('genericName')]
        );

        // find if exist or create if not
        $drugType = new DrugType();
        $drugType = DrugType::firstOrCreate(
            ['description' => $request->input('drugType')]
        );

        // find if exist or create if not
        $manufacturer = new Manufacturer();
        $manufacturer = Manufacturer::firstOrCreate(
            ['name' => $request->input('manufacturer')]
        );

        // find
        $supplier = new Supplier();
        $supplier = Supplier::find($request->input('supplierName'));

        // find if exist or create if not
        $product = new Product();
        $product = Product::firstOrCreate([
            'brand_name' => $request->input('brandName'),
            'manufacturer_id' => $manufacturer->id,
            'generic_name_id' => $genericName->id,
            'drug_type_id' => $drugType->id
        ]);

        if($product->status == 'Out-of-stock'){
            $product->status = 'In-stock';
            $product->save();
        }

        // create an inventory
        $inventory = Inventory::find($id);
        $inventory->quantity = $request->input('quantity');
        $inventory->expiration_date = $request->input('expiration_date');
        $inventory->batch_number = $batch->id;
        $inventory->supplier_id = $supplier->id;
        $inventory->product_id = $product->id;
        $inventory->delivery_date = $request->input('delivery_date');
        $inventory->save();

        // $inventory = Inventory::create([
        //     'quantity' => $request->input('quantity'),
        //     'sold' => 0,
        //     'expiration_date' => $request->input('expirationDate'),
        //     'batch_number' => $batch->id,
        //     'supplier_id' => $supplier->id,
        //     'product_id' => $product->id,
        //     'delivery_date' => $request->input('deliveryDate')
        // ]);

        // redirect to index of inventories
        return redirect('/inventories/' . $id )->with('success', 'Inventory updated successfully.');
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
