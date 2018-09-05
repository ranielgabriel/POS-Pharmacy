<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'address',
        'email_address',
        'lto_number',
        'expiration_date',
        'contact_person',
        'contact_number'
    ];

    public $primaryKey = 'id';

    public function inventories(){
        return $this->hasMany('App\Inventory');
    }
}
