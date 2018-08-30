<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\GenericName;
use App\Inventory;

class AjaxController extends Controller
{
    public function searchProducts(Request $request){

        $output =
        '<table class="table table-striped table-bordered table-hover">'.
        '<th>Brand Name</th>'.
        '<th>Generic Name</th>'.
        '<th>Drug Type</th>'.
        '<th>Quantity</th>'.
        '<th>Market Price</th>'.
        '<th>Special Price</th>'.
        '<th>Walk-In Price</th>'.
        '<th>Promo Price</th>'.
        '<th>Distributor\'s Price</th>'.
        '<th>Action</th>';

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

                foreach ($product->inventories as $productInventory) {
                    // array_push($quantity, $productInventory->quantity);
                    array_push($invent, $productInventory);
                    $quantity += $productInventory->quantity;
                }

                $output.='<tr>'.

                '<td><a href="/products/' . $product->id . '" class="">'.$product->brand_name.'</a></td>'.

                '<td>' . $product->genericNames->description . '</td>'.

                '<td>' . $product->drugTypes->description . '</td>'.

                // '<td>' . array_sum($quantity) . '</td>'.
                '<td>' . $quantity . '</td>'.

                '<td>' . $product->market_price . '</td>'.

                '<td>' . $product->special_price . '</td>'.

                '<td>' . $product->walk_in_price . '</td>'.

                '<td>' . $product->promo_price . '</td>'.

                '<td>' . $product->distributor_price . '</td>'.

                '<td><button class="btn btn-success" data-toggle="modal" data-target="#modalSell">Sell</button></td>'.

                '</tr>';

            }
        }
        // return response($products);
        return response()->json([
            'code' => $output]);
    }
}
