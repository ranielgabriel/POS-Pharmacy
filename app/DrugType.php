<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugType extends Model
{
    // Table Name
    protected $table = 'drug_types';

    // Mass Assignment
    protected $fillable = ['description'];

    // Primary Key
    public $primaryKey = 'id';

    // Relationship connections
    public function products(){
        // Foreign key check is 'product_id'
        return $this->hasMany('App\Product');
    }
}
