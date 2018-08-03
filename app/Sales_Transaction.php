<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_Transaction extends Model
{
    // Table Name
    protected $table = 'Sales_Transactions';

    // Primary Key
    public $primaryKey = 'sales_transaction_id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function customers(){
        // Foreign key check is 'customer_id'
        // Sales_Transactions table has a relationship of 1 : 1 in Customers
        return $this->hasOne('App\Customer');
    }

    public function payments(){
        // Foreign key check is 'payment_id'
        return $this->belongsToMany('App\Payment');
    }

    public function products(){
        // The name of the intermediate table is products_in_transactions
        return $this->belongsToMany('App\Product','products_in_transactions');
    }
}
