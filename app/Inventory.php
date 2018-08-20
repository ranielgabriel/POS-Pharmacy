<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // Table Name
    protected $table = 'inventories';

    // Primary Key
    public $primaryKey = 'inventory_id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function products(){
        return $this->hasOne('App\Product');
    }
}
