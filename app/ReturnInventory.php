<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnInventory extends Model
{
    // Table Name
    protected $table = 'return_inventories';

    protected $fillable = [
        'product_id',
        'quantity',
        'sold',
        'expiration_date'
    ];
    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function batch(){
        return $this->belongsTo('App\Batch', 'batch_number');
    }
}
