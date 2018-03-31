<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\GoodsGalleryRepository;
use LaraStore\Models\GoodsGalleryImage;

class GoodsGallery extends Model{

	use GoodsGalleryRepository;
	protected $table    = 'goods_gallery';
    protected $appends  = ['thumbOss'];
    public    $imgOss;


	//批量导入白名单
	protected $fillable = array('thumb', 'img', 'original','img_desc');


	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个商品可以有多张相册图片
    |
    |-------------------------------------------------------------------------------
    */
	public function goods(){

		// 模型 + 外键 + 编号（如果是id 可以省略)
		return $this->belongsTo('App\Models\Goods','goods_id');
	}


	/*
    |-------------------------------------------------------------------------------
    |
    | 根据上传的商品图片 生成2种尺寸的图片信息
    |
    |-------------------------------------------------------------------------------
    */
    public function arr(){

        return $this->toArray();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取图片
    |
    |-------------------------------------------------------------------------------
    */
    public function image(){

        return (new GoodsGalleryImage($this));
    }

}