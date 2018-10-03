<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sale;
use App\Inventory;
use App\ProductSale;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::orderBy('created_at','desc')
        ->with('productSale')
        ->paginate(30);

        // $sales = ProductSale::orderBy('id')
        // // ->with('productSale')
        // ->with('inventory')
        // // ->groupBy('sale_id')
        // ->paginate(10);
        return view('sales.index')->with('sales',$sales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function daily($date){
        $sales = Sale::orderBy('created_at','desc')
        ->where('sale_date','LIKE','%' . $date . '%')
        ->with('productSale')
        ->get();
        return view('sales.daily')->with('sales', $sales);
    }


    public function monthly($date){

        $sales = Sale::orderBy('created_at','desc')
        ->where('sale_date','LIKE','%' . $date . '%')
        ->with('productSale')
        ->get();

        // $sales = DB::table('sales')
        // ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
        // ->join('products', 'product_sales.product_id', '=', 'products.id')
        // ->join('generic_names', 'products.generic_name_id', '=', 'generic_names.id')
        // ->join('drug_types', 'products.drug_type_id', '=', 'drug_types.id')
        // ->join('inventories', 'products.id', '=', 'inventories.product_id')
        // ->join('suppliers', 'inventories.supplier_id', '=', 'suppliers.id')
        // ->select('sales.*','product_sales.*','products.brand_name','generic_names.description as genericNamesDescription','drug_types.description as drugTypesDescription')
        // ->orderBy('generic_names.description','asc')
        // ->where('sale_date','LIKE','%' . $date . '%')
        // ->get();

        return view('sales.monthly')->with(['sales'=> $sales]);
    }

    public function printDaily($date){
        $fpdf = new Fpdf();
        $fpdf::AddPage();
        $fpdf::Output();
    }
}
