<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug_Type extends Model
{
    // Table Name
    protected $table = 'Drug_Types';

    // Primary Key
    public $primaryKey = 'drug_type_id';

    // Timestamps
    public $timestamps = true;

    // Relationship connections
    public function payments(){
        // Foreign key check is 'payment_id'
        return $this->belongsTo('App\Product');
    }
}
