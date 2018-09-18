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

// Post
Route::post('/searchProducts','AjaxController@searchProducts');
Route::post('/searchBatch','AjaxController@searchBatch');
Route::post('/searchProductInfo','AjaxController@searchProductInfo');
Route::post('/searchProductQuantityInfo','AjaxController@searchProductQuantityInfo');
Route::post('/searchSupplierInfo','AjaxController@searchSupplierInfo');
Route::post('/searchSupplier','AjaxController@searchSupplier');
Route::post('/insertSale','AjaxController@insertSale');

// Get
Route::get('/getDrugTypes','AjaxController@getDrugTypes');
Route::get('/getGenericNames','AjaxController@getGenericNames');
Route::get('/getManufacturers','AjaxController@getManufacturers');
Route::get('/getSuppliers','AjaxController@getSuppliers');
