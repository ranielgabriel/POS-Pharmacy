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
        $products = Product::join('generic_names as gn', 'gn.id', '=', 'generic_name_id')
        // orderBy('brand_name','asc')
        ->orderBy('gn.description')
        ->where('status', '!=', 'In-stock')
        ->where('status', '!=', 'Out-of-stock')
        ->paginate(10);
        return view('products.index')->with('products' , $products);

        // $products = GenericName::orderBy('description','asc')
        // ->whereHas('products', function ($query){
        //     $query->where('status', '!=', 'In-stock')->where('status', '!=', 'Out-of-stock');
        // })
        // ->paginate(50);
        // return view('products.index')->with('products' , $products);
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
            'marketPrice' => 'required',
            'specialPrice' => 'required',
            'walkInPrice' => 'required',
            'promoPrice' => 'required',
            'distributorPrice' => 'required',
            'quantity' => 'gt:0'
        ]);

        $product = Product::find($request->input('brandName'));
        $product->status = 'Selling';
        $product->market_price = $request->input('marketPrice');
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
        //     'market_price' => $request->input('marketPrice'),
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