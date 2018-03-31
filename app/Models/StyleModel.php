<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\StyleModelRepository;

class StyleModel extends Model
{
    
    use StyleModelRepository;
    protected $table = 'style';
    /*
    |-------------------------------------------------------------------------------
    |
    | 是否被选中
    |
    |-------------------------------------------------------------------------------
    */
    public function is_checked(){

    	$arr 	= [
    				'未选中',
    				'选中',
    	];

    	if(in_array($this->is_checked,[0,1])){

    		return $arr[$this->is_checked];
    	}

    	return $arr[0];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取第一个被选中的配色方案
    |
    |-------------------------------------------------------------------------------
    */
    public static function wap(){

    	$color 	= StyleModel::where('is_checked',1)->first();

    	if($color){

    		return $color->style_value;
    	}

    	return '#baad7c';
    }
}
