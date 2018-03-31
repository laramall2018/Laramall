<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CommonRepository;

class UserRank extends Model
{	
	use CommonRepository;
    protected $table = 'user_rank';

    

    /*
  	|-------------------------------------------------------------------------------
  	|
  	|  返回图标的字段名
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public  function icon_field(){

  		return 'rank_pic';
  	}
}
