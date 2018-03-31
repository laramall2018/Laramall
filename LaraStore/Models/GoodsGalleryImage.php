<?php

namespace LaraStore\Models;
use LaraStore\Models\CommonTrait;
use App\Models\GoodsGallery;

class GoodsGalleryImage{

  use CommonTrait;
  protected $gallery;

  /*
  |-------------------------------------------------------------------------------
  |
  |  构造函数
  |
  |-------------------------------------------------------------------------------
  */
  public function __construct(GoodsGallery $gallery){

  	  $this->gallery 		= $gallery;
  }



  /*
  |-------------------------------------------------------------------------------
  |
  |  缩略图
  |
  |-------------------------------------------------------------------------------
  */
  public function thumb(){
  	 return $this->src($this->gallery->thumb);
  }
  
  /*
  |-------------------------------------------------------------------------------
  |
  |  详情页面图片
  |
  |-------------------------------------------------------------------------------
  */
  public function img(){
  	return $this->src($this->gallery->img);
  }

  /*
  |-------------------------------------------------------------------------------
  |
  |  原始图片
  |
  |-------------------------------------------------------------------------------
  */
  public function originalImg(){
  	return $this->src($this->gallery->original);
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  魔术方法获取 把属性绑定到对象
  |
  |-------------------------------------------------------------------------------
  */
  public function __get($field){

  	return (in_array($field,['thumb','img','originalImg']))?  call_user_func([$this,$field]) : false;
  }


}