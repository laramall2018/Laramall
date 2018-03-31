<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CommonRepository;
use Phpstore\Repository\SliderRepository;
class Slider extends Model{

	use CommonRepository,SliderRepository;
	protected $table = 'slider';


	/*
    |-------------------------------------------------------------------------------
    |
    |   返回图片字段
    |
    |-------------------------------------------------------------------------------
    */
    public function icon_field(){

    	return 'img_src';
    }

}