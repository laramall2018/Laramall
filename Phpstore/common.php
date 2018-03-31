<?php

use \DB;
use \Cache;
/*
|-------------------------------------------------------------------------------
|
|  测试函数
|
|-------------------------------------------------------------------------------
*/
function phpstore_version(){

	$str   = 'PHPStore-B2C <span>V2.2-LTS</span>';

	return $str;
}


/*
|-------------------------------------------------------------------------------
|
|  获取移动端的面包屑导航
|
|-------------------------------------------------------------------------------
*/
function breadcrumb_mobile($name,$url){

	$str 		= '<nav class="blue">'
    			 .'<div class="nav-wrapper">'
      			 .'<div class="col s12">'
        		 .'<a href="'.url('/').'" class="breadcrumb">'.trans('front.home').'</a>'
        		 .'<a href="'.$url.'" class="breadcrumb">'.$name.'</a>'
      			 .'</div>'
    			 .'</div>'
  				 .'</nav>';

  	return $str;
}


/*
|-------------------------------------------------------------------------------
|
|  获取移动端的所有配置文件
|
|-------------------------------------------------------------------------------
*/
function get_wap_config(){

    if(Cache::has('wap_config_list')){

        return Cache::get('wap_config_list');
    }
  

    $arr      = get_wap_config_from_db();
    Cache::put('wap_config_list',$arr,3600);

    return Cache::get('wap_config_list');

}


/*
|-------------------------------------------------------------------------------
|
|  获取移动端的所有配置文件 从数据库中获取
|
|-------------------------------------------------------------------------------
*/
function get_wap_config_from_db(){

    $res      = DB::table('wap_config')->get();

    return $res;
}