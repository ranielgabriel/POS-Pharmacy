<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use App\Supplier;
use App\Inventory;

class ReturnInventoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        $returnInventories = Inventory::orderBy('created_at','asc')
        ->where('isReturn','=',1)
        ->get();
        return view('returnInventories.index')->with(['returnInventories' => $returnInventories, 'user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('brand_name','asc')
        ->get();
        return view('returnInventories.create')->with('products',$products);
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
            'productId' => 'required',
            'brandName' => 'required',
            'genericName' => 'required',
            'manufacturer' => 'required',
            'drugType' => 'required',
            'expirationDate' => 'required|exists:inventories,expiration_date',
            'quantity' => 'gt:0'
        ]);

        $inventory = Inventory::find($request->inventoryId);
        
        $returnedInventory = new Inventory();
        $returnedInventory = Inventory::create([
            'quantity' => $request->input('quantity'),
            'sold' => 0,
            'expiration_date' => $request->input('expirationDate'),
            'batch_number' => $inventory->batch_number,
            'supplier_id' => $inventory->supplier_id,
            'product_id' => $inventory->product_id,
            'delivery_date' => $inventory->delivery_date,
            'isReturn' => 1
        ]);

        return redirect('/returns')->with('success','Product has been successfully returned.');
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
