<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewUser extends Model
{
    protected $table 		= 'users';
    protected $connection 	= 'mysql2';
}
