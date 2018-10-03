<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';

    protected $fillable = ['name'];

    public $primaryKey = 'id';

    public function product(){
        return $this->hasMany('App\Product');
    }
}
