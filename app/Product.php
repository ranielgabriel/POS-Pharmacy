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

    public function sales_transactions(){
        // The name of the intermediate table is products_in_transactions
        return $this->belongsToMany('App\Sales_Transaction','products_in_transactions');
    }
}
