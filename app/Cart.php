<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Table Name
    protected $table = 'carts';

    // Mass Assignment
    protected $fillable = [
        'product_id',
        'user_id',
    ];

    // Primary Key
    public $primaryKey = 'id';

    // Relationship connections
    public function user(){
        // Foreign key check is 'user_id'
        return $this->belongsTo('App\User');
    }

    public function product(){
        // Foreign key check is 'user_id'
        return $this->belongsTo('App\Product');
    }
}
