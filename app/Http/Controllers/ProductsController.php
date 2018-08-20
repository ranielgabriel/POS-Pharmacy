<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Drug_Type;
use App\Generic_Name;
use App\Inventory;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the products from the database
        // Paginate with 25 products per page
        $products = Product::orderBy('brand_name','asc')->paginate(25);

        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show the view for adding product
        return view('products.create');
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
            'marketPrice' => 'required',
            'specialPrice' => 'required',
            'walkInPrice' => 'required',
            'promoPrice' => 'required',
            'distributorPrice' => 'required',
            'expirationDate' => 'required',
            'nameOfSupplier' => 'required',
            'quantity' => 'required',
            'batchNumber' => 'required'
        ]);

        // saving to database
        $newProduct = new Product();
        $newProduct->brand_name = $request->input('brandName');
        $newProduct->manufacturer = $request->input('manufacturer');
        $newProduct->market_price = $request->input('marketPrice');
        $newProduct->special_price = $request->input('specialPrice');
        $newProduct->walkIn_price = $request->input('walkInPrice');
        $newProduct->promo_price = $request->input('promoPrice');
        $newProduct->distributor_price = $request->input('distributorPrice');

        $newGenericName = new Generic_Name();
        $newGenericName->name = $request->input('genericName');

        $newDrugType = new Drug_Type();
        $newDrugType->description = $request->input('drugType');

        $newInventory = new Inventory();
        $newInventory->expiration_date = $request->input('expirationDate');
        $newInventory->name_of_supplier = $request->input('nameOfSupplier');
        $newInventory->quantity = $request->input('quantity');
        $newInventory->batch_number = $request->input('batchNumber');
        // $product->user_id = auth()->user()->id;
        $newProduct->save();
        $newGenericName->save();
        $newDrugType->save();
        $newInventory->save();

        return redirect('/products')->with('success', 'Product successfully added.');
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