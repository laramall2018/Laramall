<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table  		= 'supplier';
    protected $fillable 	= [
    	'username','email','phone','add_time','ip','reg_from','password','sort_order','tag',
    ];
}
