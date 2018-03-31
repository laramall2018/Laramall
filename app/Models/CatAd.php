<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CommonRepository;

class CatAd extends Model{

	use CommonRepository;
	protected $table = 'cat_ad';


	/*
	|----------------------------------------------------------------------------
	|
	|  返回图片字段
	|
	|----------------------------------------------------------------------------
	*/
	public function icon_field(){

		return 'img_src';
	}


	/*
	|----------------------------------------------------------------------------
	|
	|  和分类关系为 一对多关联
	|
	|----------------------------------------------------------------------------
	*/
	public function category(){

		return $this->belongsTo(Category::class,'cat_id','id');
	}

}