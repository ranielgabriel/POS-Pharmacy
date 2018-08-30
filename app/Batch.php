<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    // Table Name
    protected $table = 'batches';

    // Mass Assignment
    protected $fillable = ['purchase_date'];

    // Primary Key
    public $primaryKey = 'id';

    // Relationship connections
    public function inventories(){
        // Foreign key check is 'product_id'
        return $this->hasMany('App\Inventory');
    }
}
