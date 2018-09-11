<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\DrugType;
use App\GenericName;
use App\Inventory;
use App\Supplier;
use App\Manufacturer;
use App\User;
use App\Cart;
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
        $products = Product::
        // Order by brand name
        orderBy('brand_name','asc')
        // Status should not be In-stock and Out-of-stock

        // ->where('status', '!=', 'In-stock')
        // ->where('status', '!=', 'Out-of-stock')

        // Return together with genericNames, drugtypes, and inventories
        ->with('genericNames')
        ->with('drugTypes')
        ->with('inventories')

        // paginate with 30 products per page
        // ->paginate(30);

        ->get();

        $user = User::find(Auth::id());

        if($user != null){
            $cart = Cart::
            // find(Auth::id());
            where('user_id','=', $user->id)
            ->get();

            // return the view index from products folder.
            return view('products.index')->with(['products' => $products, 'user' => $user, 'cart' => $cart]);
        }else{
            // return the view index from products folder.
            return view('products.index')->with(['products' => $products, 'user' => $user,]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *`
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show the view for adding product

        // Get all the products
        $products = Product::
        // Order by brand name
        orderBy('brand_name','asc')

        // Status should only be In-stock and Out-of-stock
        ->where('status','=','In-stock')
        ->orWhere('status','=','Out-of-stock')
        ->get();

        // return the view create from the products folder
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

        // find the product
        $product = Product::find($request->input('brandName'));

        // change the status to selling
        $product->status = 'Selling';

        // update the prices
        $product->purchase_price = $request->input('purchasePrice');
        $product->special_price = $request->input('specialPrice');
        $product->walk_in_price = $request->input('walkInPrice');
        $product->promo_price = $request->input('promoPrice');
        $product->distributor_price = $request->input('distributorPrice');

        // save
        $product->save();

        // redirect to index of products
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
        // find the product
        $product = Product::find($id);

        // return the view show from products folder
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