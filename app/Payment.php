<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Table Name
    protected $table = 'Payments';

    // Primary Key
    public $primaryKey = 'payment_id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function payment_methods(){
        // Foreign key check is 'payment_method_id'
        // Payment table has a relationship of 1 : 1 in Payment_Methods Table
        return $this->hasOne('App\Payment_Method');
    }

    public function sales_transactions(){
        // Foreign key check is 'sales_transaction_id'
        return $this->hasOne('App\Sales_Transaction');
    }
}
