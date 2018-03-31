<?php

namespace Phpstore\Repository;

use App\Models\Goods;
use Config;
use App\Models\Template;
use Storage;
use Cache;

trait GoodsRepository{

  
   /*
   |-------------------------------------------------------------------------------
   |
   | 获取商品的链接
   |
   |-------------------------------------------------------------------------------
   */
   public function url(){

      return ($this->diy_url) ? url('goods/'.$this->diy_url) : url('goods/'.$this->id);

   }

  /*
  |-------------------------------------------------------------------------------
  |
  | 使用trait 让模型Goods 拥有业务逻辑所需的方法
  |
  |-------------------------------------------------------------------------------
  */
  public static function createListByAttr(Array $row){

      if(!count($row)){

         return [];
      }
      $goods_list          = [];
      //循环商品列表
      foreach($row as $item){

         $goods_attr        = $item['goods_attr'];

         //如果属性是 200/400/500 拆分成3个商品
         $goods_attr_arr    = preg_split('/\//', $goods_attr);
         //循环拆分开来的商品属性
         foreach($goods_attr_arr as $attr){

            $goods_list[]      = [

                                  'goods'         =>$item['goods'],
                                  'goods_attr'    =>$attr,
                                  'goods_number'  =>$item['goods_number'],
            ];  
         }

      }

      return $goods_list;
  }



  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品的缩略图
  |
  |-------------------------------------------------------------------------------
  */
  public function getThumbFromDatabase(){

      $self         = new static;
      if($this->goods_thumb){

          return $self->icon($this->goods_thumb);
      }

      if($this->gallery()->first()){

          return $self->icon($this->gallery()->first()->thumb);
      }

      return '';

  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  从缓存获取商品的缩略图
  |
  |-------------------------------------------------------------------------------
  */
  public function thumb(){

      $key      =  'goods_thumb_'.$this->id;

      if(Cache::has($key)){

         return Cache::get($key);
      }

      if($value = $this->getThumbFromDatabase()){

            Cache::put($key,$value,3600);

            return Cache::get($key);
      }

      return false;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  获取图片的链接
  |
  |-------------------------------------------------------------------------------
  */
  public static function icon($img){
      
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



  /*
  |-------------------------------------------------------------------------------
  |
  |  生成商品的货号
  |
  |-------------------------------------------------------------------------------
  */
  public static function create_goods_sn(){

      return 'ps-'.date('YmdHij').'-'.str_random(3);
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |   获取推荐商品
  |
  |-------------------------------------------------------------------------------
  */
  public static function recommend($tag){

      //只获取新品 热销 精品 促销商品
      if(!in_array($tag,['new','hot','best','promote'])){

         return false;
      }

      //设置映射数组
      $data             = [
                              'new'       => 'is_new',
                              'hot'       => 'is_hot',
                              'best'      => 'is_best',
                              'promote'   => 'is_promote',
      ];
      $cls              = new static;

      //获取推荐商品的个数
      $num              = $cls->get_recommend_num($tag);

      $key              = 'goods_'.$tag;
      if(Cache::has($key)){

        return Cache::get($key);
      }
      if($value = $cls->getGoodsFromDatabase($data[$tag],$num)){

          Cache::put($key,$value,3600);
          return Cache::get($key);
      }

      return false;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |   获取商品信息
  |
  |-------------------------------------------------------------------------------
  */
  public static function getGoodsFromDatabase($tag,$num){

         $self                                          = new static;
         $row                                           = $self->where($tag,1)->take($num)->get();

         foreach($row as $item){

              $item['thumb']                            = $item->thumb();
              $item['url']                              = $item->url();
              $item['short_goods_name']                 = str_limit($item->goods_name,25,'..');
              $gallerys                                 = [];

              foreach($item->gallery()->get() as $key=>$gallery){

                      $gallerys[$key]['thumbOss']        = $gallery->thumb();
                      $gallerys[$key]['imgOss']          = $gallery->img();
                      $gallerys[$key]['originalOss']     = $gallery->_original();
                      $gallerys[$key]['id']              = $gallery->id;
              }

              $item['gallerys']                         = $gallerys;
         }

         return $row;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |   获取推荐商品的个数
  |
  |-------------------------------------------------------------------------------
  */
  public static function get_recommend_num($tag){

      $data             = [
                            'new'     =>'new_goods_number',
                            'hot'     =>'hot_goods_number',
                            'best'    =>'best_goods_number',
                            'promote' =>'promote_goods_number',
      ];

      if(!in_array($tag,['new','hot','best','promote'])){

          return 10;
      }

      return  (Template::get($data[$tag])) ? intval(Template::get($data[$tag])): 10;
  }



  /*
  |-------------------------------------------------------------------------------
  |
  |  删除商品和相册的图片
  |
  |-------------------------------------------------------------------------------
  */
  public function  ImageDelete(){

      //删除oss端的图片
      (Storage::has($this->goods_thumb)) ?  Storage::delete($this->goods_thumb) :'';
      //删除本地的图片
      (Storage::disk('local')->has($this->goods_thumb)) ? Storage::disk('local')->delete($this->goods_thumb) : '';

      //删除商品相册的图片
      foreach($this->gallery()->get() as $gallery){
          //删除商品相册图片
          $gallery->ImageDelete();
      }
      
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  获取格式化后的价格
  |
  |-------------------------------------------------------------------------------
  */
  public function formatePrice($tag){


     return  (in_array($tag,['shop_price','market_price','promote_price'])) ? '￥'.$this->$tag : 'false';
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  从缓存中获取商品相册
  |
  |-------------------------------------------------------------------------------
  */
  public function getGallery(){

     $key             = 'get_goods_gallery_from_goods_id_is_'.$this->id;
     return (Cache::has($key)) ? (Cache::get($key)) : $this->getGalleryFromDatabase();
  }

  /*
  |-------------------------------------------------------------------------------
  |
  |  从数据库中获取数据
  |
  |-------------------------------------------------------------------------------
  */
  public function getGalleryFromDatabase(){

      return $this->gallery()->get();
  }



  /*
  |-------------------------------------------------------------------------------
  |
  |  从缓存获取数据
  |
  |-------------------------------------------------------------------------------
  */
  public static function getModel($id){

      $self             = new static;
      $key              = 'get_goods_model_by_id_is_'.$id;
      $funcName         = 'find';
      $param            = $id;
      return $self->getCacheData(compact('key','funcName','param'));
  }



  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品分类名称 From Database;
  |
  |-------------------------------------------------------------------------------
  */
  public function getCatName(){

     return ($this->category)? $this->category->cat_name : false;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品分类名称 From  Cache
  |
  |-------------------------------------------------------------------------------
  */
  public function cat_name(){

     $self            = new static;
     $key             = 'get_goods_cat_name_by_goods_id_is_'.$this->id;
     $funcName        = 'getCatName';
     $obj             = $this;
     return $this->getCacheData(compact('key','funcName','obj'));
  }



  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品品牌名称 From  database
  |
  |-------------------------------------------------------------------------------
  */
  public function getBrandName(){

     return ($this->brand)? $this->brand->brand_name : false;
  }

  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品品牌名称 From  Cache
  |
  |-------------------------------------------------------------------------------
  */
  public function brand_name(){

      $self             = new static;
      $key              = 'get_goods_brand_name_by_goods_id_is_'.$this->id;
      $funcName         = 'getBrandName';
      $obj              = $this;

      return $self->getCacheData(compact('key','funcName','obj'));
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  get goods select form option list
  |
  |-------------------------------------------------------------------------------
  */
  public static function option(){
     $str         = '<option value="0">请选择</option>';
     foreach((new static)->all() as $goods){
        $str     .= '<option value="'.$goods->id.'">'.$goods->goods_name.'</option>';
     }
     return $str;
  }


  /*
  |-------------------------------------------------------------------------------
  |
  |  获取商品缩略图链接
  |
  |-------------------------------------------------------------------------------
  */
  public function getThumbOssAttribute(){
      return $this->image()->thumb();
  }

}