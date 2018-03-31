<?php

namespace LaraStore\Repository\Category;

use LaraStore\Presenters\CategoryPresenter;
use LaraStore\Helpers\Category\PriceList;
use LaraStore\Helpers\Category\BrandList;
use LaraStore\Helpers\Category\GoodsList;
use LaraStore\Helpers\Category\CacheHelper;
use Phpstore\Crud\ImageLib;
use App\Models\Goods;
use App\Models\Category;


trait BaseRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 获取分类的链接
    |
    |-------------------------------------------------------------------------------
    */
    public function url(){
        return ($this->diy_url)? url('category/'.$this->diy_url) : url('category/'.$this->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 上传分类图标
    |
    |-------------------------------------------------------------------------------
    */
    public function img(){

        $img                = new ImageLib();
        $img->put('file_name','cat_img');
        $img->put('dir','category');

        if($upload_img  = $img->upload_image()){

            //删除旧图片
            $this->delete_img();
            $this->cat_img  = $upload_img;
            $this->save();
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 删除商品分类图标
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_img(){

        if($this->cat_img){

            @unlink(public_path().'/'.$delete_img);
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置结点的套嵌属性
    |
    |-------------------------------------------------------------------------------
    */
    public function node(){

        $parent_id          = request()->parent_id;
        $parent_id          = intval($parent_id);
        $self               = new static;
        $parent             = $self->find($parent_id);

        //如果存在父亲结点
        if(!empty($parent)){

            $this->makeChildOf($parent);
        }
        //不存在父亲结点 则设置为 root结点
        else{

            $this->makeRoot();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 套嵌关系异常
    | 1.让自己成为自己的父亲结点
    | 2.让自己的子类结点 成为自己的父亲结点
    |
    |-------------------------------------------------------------------------------
    */
    public function chain_error(){

        $arr                = [];
        $parent_id          = request()->parent_id;
        $parent_id          = intval($parent_id);   

        //获取结点的所有子类结点和自己组成的集合
        foreach($this->getDescendantsAndSelf() as $item){

            $arr[]      = $item->id;
        }

        if(in_array($parent_id , $arr)){

            return true;
        }

        return false;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 返回结点的所有子类结点和自己组成的集合 用于查询商品分类下的所有商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function child_node_and_self_list(){

        $arr                = [];

        foreach($this->getDescendantsAndSelf() as $item){

            $arr[]          = $item->id;
        }
        return $arr;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回结点的所有子类结点和自己组成的集合 用于查询商品分类下的所有商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function  ids(){
        return $this->child_node_and_self_list();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取子类
    |
    |-------------------------------------------------------------------------------
    */
    public function  getChildren(){

    	return $this->presenter()->cache()->children();
    }

    
    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中获取商品价格的grade区间
    |
    |-------------------------------------------------------------------------------
    */
    public function price(){
        
        return $this->presenter()->cache()->price();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中 获取分类下的所有品牌
    |
    |-------------------------------------------------------------------------------
    */
    public function brand(){

        return $this->presenter()->cache()->brand();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中 获取分类下的商品属性-属性值组合结构
    |
    |-------------------------------------------------------------------------------
    */
    public function attr(){

        return $this->presenter()->cache()->attr();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中 获取分类下的商品规格-规格值组合结构
    |
    |-------------------------------------------------------------------------------
    */
    public function field(){

        return $this->presenter()->cache()->field();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中 获取分类下的商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_list(){
        return $this->presenter()->cache()->goods_list();
    }

   
    /*
    |-------------------------------------------------------------------------------
    |
    | 获取父亲结点
    |
    |-------------------------------------------------------------------------------
    */
    public function father(){

        return $this->presenter()->cache()->father();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置 presenter
    |
    |-------------------------------------------------------------------------------
    */
    public function presenter(){
        return new CategoryPresenter($this);
    }
}