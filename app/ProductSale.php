<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    // Table Name
    protected $table = 'product_sales';
    protected $fillable = [
    'product_id',
    'sale_id',
    'inventory_id',
    'quantity',
    'price'
    ];

    // Primary Key
    public $primaryKey = 'id';

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function inventory(){
        return $this->belongsTo('App\Inventory');
    }

    public function sale(){
        return $this->belongsTo('App\Sale');
    }
}
