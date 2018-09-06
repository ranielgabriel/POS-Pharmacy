<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\DrugType;
use App\GenericName;
use App\Inventory;
use App\Supplier;
use App\Manufacturer;
use Carbon\Carbon;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('brand_name','asc')
        // whereHas('genericNames', function($query){
        //     $query->orderBy('description','asc');
        // })
        ->where('status', '!=', 'In-stock')
        ->where('status', '!=', 'Out-of-stock')
        ->with('genericNames')
        ->with('drugTypes')
        ->with('inventories')
        ->paginate(30);
        return view('products.index')->with('products' , $products);
    }

    /**
     * Show the form for creating a new resource.
     *`
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show the view for adding product
        $products = Product::orderBy('brand_name','asc')
        ->where('status','=','In-stock')
        ->orWhere('status','=','Out-of-stock')
        ->get();

        return view('products.create')->with('products', $products);
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
            'purchasePrice' => 'required',
            'specialPrice' => 'required',
            'walkInPrice' => 'required',
            'promoPrice' => 'required',
            'distributorPrice' => 'required',
            'quantity' => 'gt:0'
        ]);

        $product = Product::find($request->input('brandName'));
        $product->status = 'Selling';
        $product->purchase_price = $request->input('purchasePrice');
        $product->special_price = $request->input('specialPrice');
        $product->walk_in_price = $request->input('walkInPrice');
        $product->promo_price = $request->input('promoPrice');
        $product->distributor_price = $request->input('distributorPrice');
        $product->save();

        // saving to database
        // $genericName = new GenericName();
        // $genericName = GenericName::firstOrCreate(
        //     ['description' => $request->input('genericName')]
        // );

        // $drugType = new DrugType();
        // $drugType = DrugType::firstOrCreate(
        //     ['description' => $request->input('drugType')]
        // );

        // $manufacturer = new Manufacturer();
        // $manufacturer = Manufacturer::firstOrCreate([
        //     'name' => $request->input('manufacturer')
        // ]);

        // $product = new Product();
        // $product = Product::firstOrCreate([
        //     'brand_name' => $request->input('brandName'),
        //     'purchase_price' => $request->input('marketPrice'),
        //     'special_price' => $request->input('specialPrice'),
        //     'walk_in_price' => $request->input('walkInPrice'),
        //     'promo_price' => $request->input('promoPrice'),
        //     'distributor_price' => $request->input('distributorPrice'),
        //     'manufacturer_id' => $manufacturer->id,
        //     'generic_name_id' => $genericName->id,
        //     'drug_type_id' => $drugType->id,
        //     'status' => 'Selling'
        // ]);

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
        $product = Product::find($id);
        // $product = Product::where('id','=',$id)->get();
        // where('products.id','=',$id)
        // ->join('inventories as i','i.product_id','=','products.id')
        // ->orderBy('i.expiration_date')
        // ->get();
        return view('products.show')->with('product', $product);
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