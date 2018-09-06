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
use App\Batch;

class AjaxController extends Controller
{
    public function searchProducts(Request $request){

        $output =
        '<table class="table table-striped table-bordered table-hover">'.
        '<th><label>Generic Name</label></th>'.
        '<th><label>Brand Name</label></th>'.
        '<th><label>Drug Type</label></th>'.
        '<th><label>Quantity</label></th>'.
        '<th><label>Status</label></th>'.
        '<th><label>Market Price</label></th>'.
        '<th><label>Special Price</label></th>'.
        '<th><label>Walk-In Price</label></th>'.
        '<th><label>Promo Price</label></th>'.
        '<th><label>Distributor\'s Price</label></th>';

        if($request->name != ''){

            // get all products and order by brand name
            // first check if the brand name exist
            // then check if the generic name exist
            $products = Product::orderBy('brand_name','asc')
            ->where('brand_name', 'like', '%' . $request->name . '%')
            ->orWhereHas('genericNames', function($query) use ($request){
                $query->where('description', 'like', '%' . $request->name . '%');
            })
            ->get();

            foreach ($products->sortBy('genericNames.description') as $product) {

                // temporary variable for storing quantity

                $output.='<tr>'.

                '<td>' . $product->genericNames->description . '</td>'.

                '<td><a href="/products/' . $product->id . '" class="">'.$product->brand_name.'</a></td>'.

                '<td>' . $product->drugTypes->description . '</td>'.

                '<td>' . ($product->inventories->sum('quantity') - $product->inventories->sum('sold')) . '</td>'.
                // '<td>' . $quantity . '</td>'.

                '<td>' . $product->status . '</td>'.

                '<td>&#8369 ' . $product->market_price . '</td>'.

                '<td>&#8369 ' . $product->special_price . '</td>'.

                '<td>&#8369 ' . $product->walk_in_price . '</td>'.

                '<td>&#8369 ' . $product->promo_price . '</td>'.

                '<td>&#8369 ' . $product->distributor_price . '</td>';

                if($product->status == 'Selling'){
                $output.= '<td>
                    <center>
                        <button class="btn btn-success modalSellClass" data-toggle="modal" data-target="#modalSell" data-product-id='. $product->id .'>
                            <span class="fa fa-cart-arrow-down"></span>
                        </button>
                    </center>
                </td>'.

                '</tr>';
                }else{
                    $output .= '</tr>';
                }
            }
            $output .= '</table>';
        }
        // return response($products);
        return response()->json([
            'code' => $output
            ]);
    }

    public function searchBatch(Request $request){
        $batch = Batch::find($request->input('batchNumber'));

        if($batch === null){
            return response()->json([
                'batch' => $batch
                ]);
        }else{

            $products = array();

            foreach($batch->inventories as $inventory){
                array_push($products, $inventory->product);
            }

            return response()->json([
                'batch' => $batch,
                'inventories' => $batch->inventories,
                'products' => $products
                ]);
        };
    }

    public function searchProductInfo(Request $request){
        if($request->id != null){

            $product = Product::find($request->id);

            return response()->json([
                'product' => $product,
                'genericNames' => $product->genericNames,
                'manufacturers' => $product->manufacturers,
                'drugTypes' => $product->drugTypes,
                'inventories' => $product->inventories
            ]);
        }
    }

    public function searchSupplier(Request $request){

        $output =
        '<table class="table table-striped table-bordered table-hover" id="tableProducts">'.
        '<th><center><label>Name</label></center></th>'.
        '<th><center><label>Address</label></center></th>'.
        '<th><center><label>LTO Number</label></center></th>'.
        '<th><center><label>Expiration Date</label></center></th>'.
        '<th><center><label>Contact Person</label></center></th>'.
        '<th><center><label>Contact Number</label></center></th>'.
        '<th><center><label>Email Address</label></center></th>';

        if($request->name != ''){

            // get all products and order by brand name
            // first check if the brand name exist
            // then check if the generic name exist
            $suppliers = Supplier::orderBy('name','asc')
            ->where('name', 'like', '%' . $request->name . '%')
            ->orWhere('contact_person', 'like', '%' . $request->name . '%')
            ->get();

            // temporary array for inventory
            // $invent = array();

            // loop to every product
            foreach ($suppliers as $supplier) {

                $output.= '<tr>'.

                '<td><a href="/suppliers/'. $supplier->id. '">'. $supplier->name .'</a></td>'.

                '<td>'. $supplier->address .'</td>'.

                '<td>'. $supplier->lto_number .'</td>'.

                '<td>'. $supplier->expiration_date .'</td>'.

                '<td>'. $supplier->contact_person .'</td>'.

                '<td>'. $supplier->contact_number .'</td>'.

                '<td>'. $supplier->email_address .'</td>'.

            '</tr>';
            }
        }

        $output .= '</table>';

        return response()->json([
            'code' => $output,
            ]);
    }

    public function searchSupplierInfo(Request $request){
        if($request->id != null){
            $supplier = Supplier::find($request->id);

            return response()->json([
                'supplier' => $supplier
            ]);
        }
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
