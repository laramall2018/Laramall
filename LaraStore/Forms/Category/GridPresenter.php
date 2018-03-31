<?php

namespace LaraStore\Forms\Category;

use LaraStore\Grid\Grid;
use Phpstore\Grid\Page;
use App\Models\Category;
use LaraStore\Forms\Category\CacheHelper;

class GridPresenter{

	protected $form;
	protected $max;
    protected $min;
    protected $brand_id;
    protected $cat_id;
    protected $goods_attr_ids;
    protected $goods_field_ids;
    protected $sort_name;
    protected $sort_value;
    protected $current_page;
    protected $total;
    protected $per_page;
    protected $last_page;
    protected $category;
    protected $page;
    protected $grid;
	/*
    |-------------------------------------------------------------------------------
    |
    |   构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(GridForm $form){

    	$this->form  		= $form;
    	$this->handle();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   初始化
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){

    	//初始化基本参数
    	$this->baseBoot();
    	//初始化分类模型
    	$this->categoryBoot();
    	//初始化grid
    	$this->gridBoot();
    	//初始化page组件
    	$this->pageBoot();
    	//把page组件赋值给grid 并更新grid
    	$this->gridUpdate();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   设置基础参数
    |
    |-------------------------------------------------------------------------------
    */
    public function baseBoot(){

    	$this->cat_id           	= $this->form->attributes()->cat_id;
        $this->max              	= $this->form->attributes()->max;
        $this->min              	= $this->form->attributes()->min;
        $this->brand_id         	= $this->form->attributes()->brand_id;
        $this->goods_attr_ids   	= $this->form->attributes()->goods_attr_ids;
        $this->goods_field_ids      = $this->form->attributes()->goods_field_ids;
        $this->sort_name        	= $this->form->attributes()->sort_name;
        $this->sort_value       	= $this->form->attributes()->sort_value;
        $this->current_page     	= $this->form->attributes()->current_page;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   设置模型
    |
    |-------------------------------------------------------------------------------
    */
    public function categoryBoot(){

    	$this->category  		  = Category::find($this->cat_id);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   设置 grid
    |
    |-------------------------------------------------------------------------------
    */
    public function gridBoot(){

    	$grid = new Grid($this->category);
    	$grid->put('max',$this->max)
    		 ->put('min',$this->min)
    		 ->put('brand_id',$this->brand_id)
    		 ->put('cat_id',$this->cat_id)
    		 ->put('goods_attr_ids',$this->goods_attr_ids)
             ->put('goods_field_ids',$this->goods_field_ids)
    		 ->put('sort_name',$this->sort_name)
    		 ->put('sort_value',$this->sort_value)
    		 ->put('current_page',$this->current_page);
    	$this->grid = $grid;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   设置 page
    |
    |-------------------------------------------------------------------------------
    */
    public function pageBoot(){

    	$page  							= new Page();
    	$this->per_page 				= Category::pages();
    	$this->total 					= $this->grid->total();
    	$this->last_page 				= ceil($this->total / $this->per_page);

    	$page->put('current_page',$this->current_page)
    		 ->put('per_page',$this->per_page)
    		 ->put('total',$this->total)
    		 ->put('last_page',$this->last_page);

    	$this->page 			= $page;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  更新grid的page
    |
    |-------------------------------------------------------------------------------
    */
    public function gridUpdate(){

    	$this->grid->put('page',$this->page);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取
    |
    |-------------------------------------------------------------------------------
    */
    public function get($key){

    	return $this->$key;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取page
    |
    |-------------------------------------------------------------------------------
    */
    public function page(){

    	return $this->page;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取grid
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){

    	return $this->grid;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   返回cache
    |
    |-------------------------------------------------------------------------------
    */
    public function cache(){

    	return new CacheHelper($this);
    }
}