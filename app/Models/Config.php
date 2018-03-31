<?php

namespace App\Models;

/**
 * Created by PhpStorm.
 * User: swh
 * Date: 15/9/9
 * Time: 下午1:52
 */


use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\ConfigRepository;

class Config extends Model
{	
	use ConfigRepository;
    protected $table = 'sys_config';

}
