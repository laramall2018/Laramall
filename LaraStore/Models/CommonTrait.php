<?php

namespace LaraStore\Models;

use Config;

trait CommonTrait{

  /*
  |-------------------------------------------------------------------------------
  |
  |  获取图片的链接
  |
  |-------------------------------------------------------------------------------
  */
  public function src($img){
      
        //获取filesystems的存储介质
        $config       = Config::get('filesystems.default');
        //key:vlaue值
        $arr        = [
                    'oss'     => env('ALIOSS_BASEURL').$img,
                    'local'   => url($img),
        ];
        //返回相应的值
        return  (in_array($config,['oss','local'])) ? $arr[$config] : false;
  }

}