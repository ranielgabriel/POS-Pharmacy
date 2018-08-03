<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Table Name
    protected $table = 'Products';

    // Primary Key
    public $primaryKey = 'product_id';

    // Timestamps
    public $timestamps = true;

    public function drug_types(){
        // Foreign key check is 'payment_method_id'
        // Products table has a relationship of 1 : 1 in Drug_Types Table
        return $this->hasOne('App\Drug_Type');
    }

    public function sales_transactions(){
        // The name of the intermediate table is products_in_transactions
        return $this->belongsToMany('App\Sales_Transaction','products_in_transactions');
    }

    public function generic_names(){
        // The name of the intermediate table is products_generic_names
        return $this->belongToMany('App\Generic_Name','products_generic_names');
    }
}
