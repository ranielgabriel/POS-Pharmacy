<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Table Name
    protected $table = 'Customers';

    // Primary Key
    public $primaryKey = 'customer_id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function sales_transactions(){
        // Foreign key check is 'sales_transaction_id'
        return $this->belongsTo('App\Sales_Transaction');
    }
}
