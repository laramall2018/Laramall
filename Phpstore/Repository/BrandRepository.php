<?php

namespace Phpstore\Repository;

use LaraStore\Cache\Helper;
use LaraStore\Presenters\BrandPresenter;

trait BrandRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 生成品牌下拉表单选项
    |
    |-------------------------------------------------------------------------------
    */
    public static function brand_option(){

    	$self 				= new static;
    	$key 				= 'admin_brand_option_list_is';
    	$funcName 			= 'getBrandOptionListFromDatabase';
    	return $self->getCacheData(compact('key','funcName'));
    	
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 从数据库中获取品牌下拉表单选项
    |
    |-------------------------------------------------------------------------------
    */
    public static function getBrandOptionListFromDatabase(){

        $str                = '<option value="">请选择</option>';
        $self 				= new static;
        foreach($self->get() as $item){

            $str            .= '<option value="'.$item->id.'">'.$item->brand_name.'</option>';
        }

        return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取品牌下商品数量
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_number(){

    	return count($this->goods);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取品牌的链接
    |
    |-------------------------------------------------------------------------------
    */
    public function url(){

        return ($this->diy_url)? url('brand/'.$this->diy_url): url('brand/'.$this->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置 presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){
        return new BrandPresenter($this);
    }


}