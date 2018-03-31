<?php

namespace LaraStore\Presenters;
use App\Models\Category;
use LaraStore\Presenters\PresenterTrait;
use LaraStore\Helpers\Category\CacheHelper;
use LaraStore\Helpers\Category\PriceList;
use LaraStore\Helpers\Category\BrandList;
use LaraStore\Helpers\Category\GoodsList;
use LaraStore\Helpers\Category\Attribute;
use LaraStore\Helpers\Category\GoodsPage;
use LaraStore\Helpers\Category\Field;
use Phpstore\Grid\Page;


class CategoryPresenter{

	use PresenterTrait;
	protected $category;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Category $category){
    	$this->category 	= $category;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回缓存
    |
    |-------------------------------------------------------------------------------
    */
    public function cache(){
        return new CacheHelper($this->category);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的品牌列表
    |
    |-------------------------------------------------------------------------------
    */
    public function brand(){
        return new BrandList($this->category);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的价格区间
    |
    |-------------------------------------------------------------------------------
    */
    public function price(){
        return new PriceList($this->category);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品列表
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){
        return new GoodsList($this->category);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 设置分页
    |
    |-------------------------------------------------------------------------------
    */
    public function page(){
        return new GoodsPage($this->category, new Page);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的商品属性组合结构(属性名称：属性值)
    |
    |-------------------------------------------------------------------------------
    */
    public function attr(){
        return new Attribute($this->category);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取分类下的商品规格组合结构(规格名称：规格值)
    |
    |-------------------------------------------------------------------------------
    */
    public function field(){

        return new Field($this->category);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取父亲结点名称
    |
    |-------------------------------------------------------------------------------
    */
    public function father(){

        return ($this->category->isRoot())? '': $this->category->parent()->first()->cat_name;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有子节点
    |
    |-------------------------------------------------------------------------------
    */
    public function children(){
        return $this->category->children()->get();
    }


}