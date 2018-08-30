<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\GenericName;
use App\Inventory;
use App\DrugType;
use App\Manufacturer;
use App\Supplier;

class AjaxController extends Controller
{
    public function searchProducts(Request $request){

        $output =
        '<table class="table table-striped table-bordered table-hover">'.
        '<th><label>Brand Name</label></th>'.
        '<th><label>Generic Name</label></th>'.
        '<th><label>Drug Type</label></th>'.
        '<th><label>Quantity</label></th>'.
        '<th><label>Market Price</label></th>'.
        '<th><label>Special Price</label></th>'.
        '<th><label>Walk-In Price</label></th>'.
        '<th><label>Promo Price</label></th>'.
        '<th><label>Distributor\'s Price</label></th>'.
        '<th><label>Action</label></th>';

        if($request->name != ''){
            $products = Product::orderBy('brand_name','asc')
            ->where('brand_name', 'like', '%' . $request->name . '%')
            ->orWhereHas('genericNames', function($query) use ($request){
                $query->where('description', 'like', '%' . $request->name . '%');
            })
            ->get();

            $invent = array();
            foreach ($products as $product) {

                $quantity = null;
                $quantity = array();

                foreach ($product->inventories as $productInventory) {
                    array_push($quantity, $productInventory->quantity);
                    array_push($invent, $productInventory);
                    // $quantity += $productInventory->quantity;
                }

                $output.='<tr>'.

                '<td><a href="/products/' . $product->id . '" class="">'.$product->brand_name.'</a></td>'.

                '<td>' . $product->genericNames->description . '</td>'.

                '<td>' . $product->drugTypes->description . '</td>'.

                '<td>' . array_sum($quantity) . '</td>'.
                // '<td>' . $quantity . '</td>'.

                '<td>&#8369 ' . $product->market_price . '</td>'.

                '<td>&#8369 ' . $product->special_price . '</td>'.

                '<td>&#8369 ' . $product->walk_in_price . '</td>'.

                '<td>&#8369 ' . $product->promo_price . '</td>'.

                '<td>&#8369 ' . $product->distributor_price . '</td>'.

                '<td><button class="btn btn-success" data-toggle="modal" data-target="#modalSell"><span class="badge">Sell</span></button></td>'.

                '</tr>';

            }
        }
        // return response($products);
        return response()->json([
            'code' => $output]);
    }

    public function getDrugTypes(){
        $drugTypes = DrugType::orderBy('description','asc')
        ->select('description')
        ->get();
        return response($drugTypes);
    }

    public function getGenericNames(){
        $genericNames = GenericName::orderBy('description','asc')
        ->select('description')
        ->get();
        return response($genericNames);
    }

    public function getManufacturers(){
        $manufacturers = Manufacturer::orderBy('name','asc')
        ->select('name')
        ->get();
        return response($manufacturers);
    }

    public function getSuppliers(){
        $suppliers = Supplier::orderBy('name','asc')
        ->select('name')
        ->get();
        return response($suppliers);
    }

}
