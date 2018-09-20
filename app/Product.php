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
    'manufacturer_id',
    'drug_type_id'
    ];

    // Primary Key
    public $primaryKey = 'id';

    public function drugTypes(){
        return $this->belongsTo('App\DrugType','drug_type_id');
    }

    public function inventories(){
        return $this->hasMany('App\Inventory');
    }

    public function productSale(){
        return $this->hasMany('App\ProductSale');
    }

    public function returnInventories(){
        return $this->hasMany('App\ReturnInventory');
    }

    public function manufacturers(){
        return $this->belongsTo('App\Manufacturer','manufacturer_id');
    }

    public function genericNames(){
        // The name of the intermediate table is products_generic_names
        return $this->belongsTo('App\GenericName','generic_name_id');
    }
}
