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
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('auth')
        ->except(['index', 'show']);
    }
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
        // find the product
        $product = Product::find($id);

        // return the view show from products folder
        return view('products.edit')->with('product', $product);
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

        $this->validate($request,[
            'brandName' => 'required',
            'genericName' => 'required',
            'manufacturer' => 'required',
            'drugType' => 'required',
            'purchasePrice' => 'required',
            'specialPrice' => 'required',
            'walkInPrice' => 'required',
            'promoPrice' => 'required',
            'distributorPrice' => 'required'
        ]);

        $product = Product::find($id);
        $product->brand_name = $request->input('brandName');
        
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

        $product->generic_name_id = $genericName->id;
        $product->manufacturer_id = $manufacturer->id;
        $product->drug_type_id = $drugType->id;

        $product->purchase_price = $request->input('purchasePrice');
        $product->special_price = $request->input('specialPrice');
        $product->walk_in_price = $request->input('walkInPrice');
        $product->promo_price = $request->input('promoPrice');
        $product->distributor_price = $request->input('distributorPrice');

        $product->save();

        return redirect('/products/' . $id)->with('success','Product successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        DB::table('inventories')->where('product_id', '=', $id)->delete();
        DB::table('carts')->where('product_id', '=', $id)->delete();

        return redirect('/products')->with('success', '"' . $product->genericNames->description .' ' . $product->brand_name . '" successfully deleted.');
    }

}