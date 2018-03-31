<?php

namespace Phpstore\Repository;

use App\Models\Config;
use Cache;

trait ConfigRepository{

  
  /*
  |-------------------------------------------------------------------------------
  |
  | 使用trait 让模型Config 拥有业务逻辑所需的方法
  |
  |-------------------------------------------------------------------------------
  */
  public static function getFromDatabase($code){

  		$instance 	= new static;
  		$res 		= $instance->where('code',$code)->first();
  		if($res){

  			return $res->value;
  		}

  		return false;
  }



  /*
  |-------------------------------------------------------------------------------
  |
  | 获取配置文件
  |
  |-------------------------------------------------------------------------------
  */
  public static function getValue($code){

     //从缓存中获取
     $key           = 'config_'.$code.env('domain');
     if(Cache::has($key)){

        return Cache::get($key);

     }

     //从数据库中去并把取得的值存入缓存
     $self          = new static;
     if($value = $self->getFromDatabase($code)){

          Cache::put($key,$value,3600);
          return Cache::get($key);
     }

     return false;
  }

  /*
  |-------------------------------------------------------------------------------
  |
  | 获取配置文件
  |
  |-------------------------------------------------------------------------------
  */
  public static function get($code){

      $self       =  new static;
      return $self->getValue($code);
  }


  /*
  |-------------------------------------------------------------------------------
  |
  | 返回主要配置文件的字段数组
  |
  |-------------------------------------------------------------------------------
  */
  public static function field(){

     $row            = [
                            'shop_title',
                            'email',
                            'shop_address',
                            'shop_name',
                            'keywords',
                            'shop_desc',
                            'qq',
                            'weixin',
                            'tel',
                            'domain',
                            'shop_logo',
                            'shop_notices',
                            'wap_logo',
                            'user_notices',
                            'icp',
                            'goods_default_img',
                            'search_keywords',
                          ];
      return $row;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  | 获取系统主要配置的配置数组值
  |
  |-------------------------------------------------------------------------------
  */
  public static function getSystemConfigFromDatabase(){

      $arr                    = [];
      $self                   = new static;
      foreach($self->field() as $code){

         if($value = $self->getFromDatabase($code)){

             $arr[$code]      = $value;    
         }
      }

      return $arr;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  | 从缓存或者数据库中获取
  |
  |-------------------------------------------------------------------------------
  */
  public static function systemConfig(){

      if(Cache::has('system_config')){

          return Cache::get('system_config');
      }

      $self               = new static;
      if($value  = $self->getSystemConfigFromDatabase()){

           Cache::put('system_config',$value,3600);
           return  Cache::get('system_config');
      }

      return false;
  }


  

}