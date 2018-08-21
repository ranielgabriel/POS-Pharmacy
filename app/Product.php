<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Table Name
    protected $table = 'products';
    protected $fillable = [
    'brand_name',
    'generic_name_id',
    'manufacturer',
    'drug_type_id',
    'market_price',
    'special_price',
    'walk_in_price',
    'promo_price',
    'distributor_price',
    'updated_at',
    'created_at'];

    // Primary Key
    public $primaryKey = 'id';

    public function drugTypes(){
        // Foreign key check is 'payment_method_id'
        // Products table has a relationship of 1 : 1 in Drug_Types Table
        return $this->belongsTo('App\DrugType','drug_type_id');
    }

    function inventories(){
        return $this->hasMany('App\Inventory');
    }

    // function sales_transactions(){
    //     // The name of the intermediate table is products_in_transactions
    //     return $this->belongsToMany('App\SalesTransaction','products_in_transactions');
    // }

    public function genericNames(){
        // The name of the intermediate table is products_generic_names
        return $this->belongsTo('App\GenericName','generic_name_id');
    }
}
