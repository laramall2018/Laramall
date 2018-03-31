<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\ThemeRepository;

class Theme extends Model
{
	use ThemeRepository;
    protected $table  		= 'themes';

    protected $fillable 	= ['name','type','is_checked'];

}
