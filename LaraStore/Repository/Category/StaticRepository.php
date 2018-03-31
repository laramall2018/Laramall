<?php

namespace LaraStore\Repository\Category;
use Cache;
use LaraStore\Helpers\Cache\Common;
use App\Models;
use App\Models\Config;

trait StaticRepository{


	  /*
    |-------------------------------------------------------------------------------
    |
    | 商品分页大小
    |
    |-------------------------------------------------------------------------------
    */
    public static function list_page_size(){

       return ($value = Config::getValue('list_page_size')) ? intval($value) : 20;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 商品分页大小
    |
    |-------------------------------------------------------------------------------
    */
    public static function pages(){

        return (new static)->list_page_size();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类列表
    |
    |-------------------------------------------------------------------------------
    */
    public static function getList(){

    	$key 			= 'category_list_home_';
    	$self 			= new static;
    	if(Cache::has($key)){

    		return Cache::get($key);
    	}
        $value 		= $self->where('depth',0)->orderBy('id','asc')->get();
        Cache::put($key,$value,3600);
        return Cache::get($key);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 缓存帮助函数
    |
    |-------------------------------------------------------------------------------
    */
    public static function cacheHelper(){

    	$cache  =  new Common();
    	return $cache->put('time',3600)->put('param','')->put('func',new static);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类的递进式select option 从缓存中获取
    |
    |-------------------------------------------------------------------------------
    */
    public static function cat_select(){
    	
        $cache = (new static)->cacheHelper();
        return $cache->put('key','get_all_category_select_option_list')
        	  		     ->put('method','getSelectFromDatabase')
        	  		     ->handle();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类的递进式select option
    |
    |-------------------------------------------------------------------------------
    */
    public static function getSelectFromDatabase(){


        $str        = '<option value="">请选择</option>';
        $self       = new static;
        $roots      = $self->roots()->get();

        foreach($roots as $root){

            $child_str  = $self->cat_child($root);

            $str    .= '<option value="'.$root->id.'">'.$root->cat_name.'</option>'
                    .$child_str;
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取子节点option
    |
    |-------------------------------------------------------------------------------
    */
    public static function cat_child($node){

        $str        = '';
        $self       = new static;
        foreach($node->children()->get() as $item){

            //获取间距
            $padding = '';
            for($i = 0; $i<$item->depth;$i++){

                $padding .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            }

            $child_str = $self->cat_child($item);
            $str   .= '<option value="'.$item->id.'">'.$padding.$item->cat_name.'</option>'
                   .$child_str;
        }

        return $str;
    }

  

  	/*
  	|-------------------------------------------------------------------------------
  	|
  	|  使用缓存包装获取模型
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public static function getModel($id){
 
       $self 	 = new static;
       $cache    = $self->cacheHelper();
       return    $cache->put('key','get_model_from_table_'.$self->table.'_by_id_'.$id)
       			    	->put('method','find')
       			    	->handle();

    }


  	/*
  	|-------------------------------------------------------------------------------
  	|
  	|  返回数据表名称
  	|
  	|-------------------------------------------------------------------------------
  	*/
  	public static function getTableName(){
       return (new static)->table;
  	}


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类目录
    |
    |-------------------------------------------------------------------------------
    */
    public static function catalog(){

        $str                    = '<ul class="collection">';
        $self                   = new static;
        foreach($self->roots()->get() as $root){

             $child_str         = $self->catalog_children($root);

             $str              .= '<li class="collection-item"><a href="'.$root->url().'">'
                              
                               .$root->cat_name
                               .'</a>'
                               .$child_str
                               .'</li>';
        }

        $str                   .= '</ul>';

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类目录 子目录
    |
    |-------------------------------------------------------------------------------
    */
    public static function catalog_children($node){

        $str            = '<ul>';
        $self           = new static;
        foreach($node->children()->get() as $item){

                $child_str  = $self->catalog_children($item);

                $str    .= '<li><a href="'.$item->url().'">'
                        .$item->cat_name
                        .'</a>'
                        .$child_str
                        .'</li>';
        }

        $str           .= '</ul>';

        return $str;
    }

}