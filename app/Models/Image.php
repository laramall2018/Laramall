<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CommonRepository;
use Phpstore\Repository\ImageRepository;

class Image extends Model{

	use CommonRepository,ImageRepository;
	protected $table = 'image';
	protected $appends = ['imgOss'];

	/*
	|----------------------------------------------------------------------------
	|
	|  返回图片链接字段
	|
	|----------------------------------------------------------------------------
	*/
	public function icon_field(){

		return 'img_src';
	}

}