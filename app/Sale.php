<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    // Table Name
    protected $table = 'sales';
    protected $fillable = [
        'customer_id',
        'sale_date'
    ];

    // Primary Key
    public $primaryKey = 'id';

    public function customer(){
        return $this->belongsTo('App\Customer');
    }

    public function productSale(){
        return $this->hasMany('App\ProductSale');
    }
}
