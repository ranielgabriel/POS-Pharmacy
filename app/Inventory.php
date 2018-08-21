<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // Table Name
    protected $table = 'inventories';

    protected $fillable = [
        'name_of_supplier',
        'product_id',
        'quantity',
        'expiration_date',
        'batch_number',
    ];
    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function products(){
        return $this->belongsTo('App\Product');
    }

    public function suppliers(){
        return $this->belongsTo('App\Supplier');
    }
}
