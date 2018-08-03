<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generic_Name extends Model
{
    // Table Name
    protected $table = 'Generic_Names';

    // Primary Key
    public $primaryKey = 'generic_name_id';

    // Timestamps
    public $timestamps = true;

    public function products(){
        // The name of the intermediate table is products_generic_names
        return $this->belongToMany('App\Product','products_generic_names');
    }
}
