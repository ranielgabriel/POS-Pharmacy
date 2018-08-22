<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;

class AjaxController extends Controller
{
    public function searchProducts(Request $request){
        // Get all the products from the database
        // Paginate with 25 products per page
        // $products = DB::table('products')
        //     ->join('generic_names', 'products.generic_name_id', '=', 'generic_names.id')
        //     ->join('drug_types', 'products.drug_type_id', '=', 'drug_types.id')
        //     ->join('inventories', 'products.id', '=', 'inventories.product_id')
        //     ->join('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
        //     ->where('brand_name', 'like', '%' . $request->name . '%')
        //     ->orWhere('generic_names.description', 'like','%' . $request->name . '%')
        //     ->orWhere('manufacturers.name', 'like', '%' . $request->name . '%')
        //     ->get();

        $products = Product::orderBy('brand_name','asc')
        ->join('generic_names', 'products.generic_name_id', '=', 'generic_names.id')
        ->join('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
        ->where('brand_name', 'like', '%' . $request->name . '%')
        ->orWhere('generic_names.description', 'like','%' . $request->name . '%')
        ->orWhere('manufacturers.name', 'like', '%' . $request->name . '%')
        ->get();
        return response()->json($products);
    }

    // public function index(){
    //     $msg = "This is a simple message.";
    //     return response()->json(array('msg'=> $msg), 200);
    //  }
}
