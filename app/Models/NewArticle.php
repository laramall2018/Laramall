<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewArticle extends Model
{
    protected $table="article";
    protected $connection = 'mysql2';
}
