<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Table Name
    protected $table = 'customers';

    // Mass Assignment
    protected $fillable = [
        'name',
        'contact_number',
        'address',
        'details',
    ];

    // Primary Key
    public $primaryKey = 'id';
}
