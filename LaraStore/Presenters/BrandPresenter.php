<?php

namespace LaraStore\Presenters;
use App\Models\Brand;

use LaraStore\Models\CommonTrait;

class BrandPresenter{

	use PresenterTrait,CommonTrait;
	protected $brand;

	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Brand $brand){
    	$this->brand 		= $brand;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取logo
    |
    |-------------------------------------------------------------------------------
    */
    public function brand_logo(){
       if($this->brand->brand_logo){
       		return url($this->brand->brand_logo);
       }
       return url('front/images/brand-def-logo.png');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取品牌下商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_list(){

        $arr        = [];
        $rows       = $this->brand->goods()->get();
        foreach($rows as $item){

            $arr[]  = [
                            'id'                =>$item->id,
                            'goods_name'        =>$item->goods_name,
                            'short_goods_name'  =>str_limit($item->goods_name,20,'..'),
                            'thumb'             =>$item->image()->thumb(),
                            'thumbOss'          =>$item->image()->thumb(),
                            'url'               =>$item->url(),
                            'shop_price'        =>$item->shop_price,
                            'gallerys'          =>$item->presenter()->gallerys(),
            ];
        }

        return $arr;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取oss里面的图片logo
    |
    |-------------------------------------------------------------------------------
    */
    public function logo(){

        return  ($this->brand->brand_logo)? $this->src($this->brand->brand_logo) : url('front/images/brand-def-logo.png');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取oss里面的图片logo html
    |
    |-------------------------------------------------------------------------------
    */
    public function logoHtml(){

        return '<img src="'.$this->logo().'" class="img-thumbnail" style="width:120px;">';
    }
}