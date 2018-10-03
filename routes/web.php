<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index');

// Resource
Route::resource('/products', 'ProductsController');
Route::resource('/inventories', 'InventoriesController');
Route::resource('/suppliers', 'SuppliersController');
Route::resource('/cart', 'CartsController');
Route::resource('/customers', 'CustomersController');
Route::resource('/returns', 'ReturnInventoriesController');
Route::resource('/sales', 'SalesController');

// Post
Route::post('/searchProducts','AjaxController@searchProducts');
Route::post('/searchBatch','AjaxController@searchBatch');
Route::post('/searchProductInfo','AjaxController@searchProductInfo');
Route::post('/searchProductQuantityInfo','AjaxController@searchProductQuantityInfo');
Route::post('/searchSupplierInfo','AjaxController@searchSupplierInfo');
Route::post('/searchSupplierInfoById','AjaxController@searchSupplierInfoById');
Route::post('/searchBySaleId','AjaxController@searchBySaleId');
Route::post('/searchProductSaleInfo','AjaxController@searchProductSaleInfo');
Route::post('/searchSupplier','AjaxController@searchSupplier');
Route::post('/insertSale','AjaxController@insertSale');

Route::get('/sales/daily/{date}','SalesController@daily');
Route::get('/sales/daily/print/{date}', function(Codedge\Fpdf\Fpdf\Fpdf $fpdf, $date) {
    
    $sales = App\Sale::orderBy('created_at','desc')
        ->where('sale_date','LIKE','%' . $date . '%')
        ->with('productSale')
        ->get();

    $fpdf->AddPage();
    $fpdf->SetFont('Arial', '', 12);

    foreach($sales as $sale){
        $fpdf->Write(10, $sale);
    }

    $fpdf->Output();
    exit();

});
Route::get('/sales/monthly/{date}','SalesController@monthly');

// Get
Route::get('/getDrugTypes','AjaxController@getDrugTypes');
Route::get('/getGenericNames','AjaxController@getGenericNames');
Route::get('/getBrandNames','AjaxController@getBrandNames');
Route::get('/getManufacturers','AjaxController@getManufacturers');
Route::get('/getSuppliers','AjaxController@getSuppliers');
