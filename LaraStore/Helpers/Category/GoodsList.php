<?php

namespace LaraStore\Helpers\Category;
use App\Models\Category;
use App\Models\Goods;

class GoodsList{

	protected $category;
	protected $key;
	protected $value;
	protected $page;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Category $category){
    	$this->category 		= $category;
    	$this->key 				= (request()->key)?:'id';
    	$this->value 			= (request()->value)?:'desc';
    	$this->page 			= Category::list_page_size();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  包装下 获取商品列表函数 array格式
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){
        return $this->toArray();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  包装下 获取商品列表函数 对象格式
    |
    |-------------------------------------------------------------------------------
    */
    public function query(){
        return $this->pageQuery()->get();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 是否有子结点
    |
    |-------------------------------------------------------------------------------
    */
    public function hasChild(){
    	return (count($this->category->ids()) > 1)? true:false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  基础查询
    |
    |-------------------------------------------------------------------------------
    */
    public function baseQuery(){

    	return ($this->hasChild())? $this->whereInQuery() : $this->whereQuery();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  whereIn查询
    |
    |-------------------------------------------------------------------------------
    */
    public function whereInQuery(){

    	return Goods::whereIn('cat_id',$this->category->ids());
    }


    /*
    |-------------------------------------------------------------------------------
    |
	| where查询
    |
    |-------------------------------------------------------------------------------
    */
    public function whereQuery(){
    	return Goods::where('cat_id',$this->category->id);
    }



    
    /*
    |-------------------------------------------------------------------------------
    |
	|  orderBy查询
    |
    |-------------------------------------------------------------------------------
    */
    public function sortQuery(){
    	return  $this->baseQuery()->orderBy($this->key,$this->value);
    }


    /*
    |-------------------------------------------------------------------------------
    |
	|  paginate分页
    |
    |-------------------------------------------------------------------------------
    */
    public function pageQuery(){
    	return $this->sortQuery()->take($this->page);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取分类下商品总记录
    |
    |-------------------------------------------------------------------------------
    */
    public function total(){
        return count($this->baseQuery()->get());
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  进一步格式化商品列表数据
    |
    |-------------------------------------------------------------------------------
    */
    public function toArray(){
        $arr        = [];
        foreach($this->pageQuery()->get() as $goods){
            $arr[]  =[
                'id'                =>$goods->id,
                'goods_name'        =>$goods->goods_name,
                'short_goods_name'  =>str_limit($goods->goods_name,25,'..'),
                'cat_id'            =>$goods->cat_id,
                'brand_id'          =>$goods->brand_id,
                'shop_price'        =>$goods->shop_price,
                'thumb'             =>$goods->thumb(),
                'url'               =>$goods->url(),
                'gallerys'          =>$goods->presenter()->gallerys(),
            ];
        }

        return $arr;
    }
}