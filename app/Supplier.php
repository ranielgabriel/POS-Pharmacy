<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = ['name'];

    public $primaryKey = 'id';

    public function inventories(){
        return $this->hasMany('App\Inventory');
    }
}
