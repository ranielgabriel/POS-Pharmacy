<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // Table Name
    protected $table = 'inventories';

    protected $fillable = [
        'supplier_id',
        'product_id',
        'quantity',
        'sold',
        'expiration_date',
        'batch_number',
    ];
    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

    public function batches(){
        return $this->belongsTo('App\Batch', 'batch_number');
    }
}
