<?php

namespace LaraStore\Helpers\Category;
use Phpstore\Grid\Page;
use App\Models\Category;

class GoodsPage{


	protected $category;
	protected $page;
	protected $per_page;
	protected $total;
	protected $current_page;
	protected $last_page;
	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Category $category,Page $page){
    	$this->category 		= $category;
    	$this->page 			= $page;
    	//设置参数
    	$this->boot()->page();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置参数  init
    |
    |-------------------------------------------------------------------------------
    */
    public function boot(){

    	$this->total()->perPage()->currentPage()->lastPage();
    	return $this;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置参数 total
    |
    |-------------------------------------------------------------------------------
    */
    public function total(){
    	$this->total 		= $this->category->presenter()->goods()->total();
    	return $this;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  设置参数 per_page
    |
    |-------------------------------------------------------------------------------
    */
    public function perPage(){
    	$this->per_page 	= Category::list_page_size();
    	return $this;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  设置参数 current_page
    |
    |-------------------------------------------------------------------------------
    */
    public function currentPage(){
    	$this->current_page 	= 1;
    	return $this;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置参数 last_page
    |
    |-------------------------------------------------------------------------------
    */
    public function lastPage(){

    	$this->last_page 	= ceil($this->total / $this->per_page);
    	return $this;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置page的参数
    |
    |-------------------------------------------------------------------------------
    */
    public function page(){

    	$this->page->put('total',$this->total)
    			   ->put('per_page',$this->per_page)
    			   ->put('current_page',$this->current_page)
    			   ->put('last_page',$this->last_page);

    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    | 返回page的值
    |
    |-------------------------------------------------------------------------------
    */
    public function handle(){
    	return  [
    				'current_page'	=> $this->page->get('current_page'),
    				'last_page'		=> $this->page->get('last_page'),
    				'per_page'		=> $this->page->get('per_page'),
    				'total'			=> $this->page->get('total'),
    				'number'		=> $this->page->number(),

    	];
    }
}