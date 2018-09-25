<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Inventory;
use App\ProductSale;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::orderBy('sale_date','desc')
        ->with('productSale')
        ->paginate(10);

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
        ->paginate(25);
        return view('sales.daily')->with('sales', $sales);
    }


    public function monthly($date){

        $sales = Sale::orderBy('created_at','desc')
        ->where('sale_date','LIKE','%' . $date . '%')
        ->with('productSale')
        ->paginate(25);
        return view('sales.monthly')->with(['sales'=> $sales]);
    }
}
