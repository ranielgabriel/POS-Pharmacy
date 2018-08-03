<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Method extends Model
{
    // Table Name
    protected $table = 'Payment_Methods';

    // Primary Key
    public $primaryKey = 'payment_method_id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function payments(){
        // Foreign key check is 'payment_id'
        return $this->belongsTo('App\Payment','payment_id');
    }
}
