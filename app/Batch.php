<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    // Table Name
    protected $table = 'batches';

    // Mass Assignment
    protected $fillable = [
        'id'
    ];

    // Primary Key
    public $primaryKey = 'id';

    // Relationship connections
    public function inventories(){
        return $this->hasMany('App\Inventory', 'batch_number');
    }
}
