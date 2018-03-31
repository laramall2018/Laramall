<?php

namespace App\Http\Controllers\Front;

use App\User;
use App\Models\Category;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use Phpstore\Base\Goodslib;
use Request;
use DB;
use Phpstore\Front\Grid;
use Phpstore\Grid\Page;


class CategoryController extends BaseController
{


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct()
    {

        parent::__construct();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理商品分类页面
    |
    |-------------------------------------------------------------------------------
    */
    public function index($id){


    	$common 					= new Common();
    	$model 						= Category::find($id);
        
    	if(empty($model)){

    		return $this->view('404');
    	}

    	$view 						= $this->view('category');
    	$view->title 				= $this->view->title.'-'.$model->cat_name;
    	$view->cat 					= $model;
    	$view->breadcrumb 			= $common->get_breadcrumb($model->cat_name);
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile($model->cat_name,$model->url());
        $view->entity               = new \LaraStore\Entity\CategoryEntity();
        $view->id                   = $id;
        
    	return $view; 


    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理商品分类页的ajax排序
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){

        $info           = Request::input('info');
        $info           = json_decode($info);

        $min            = intval($info->min);
        $max            = intval($info->max);
        $cat_id         = intval($info->cat_id);
        $brand_id       = intval($info->brand_id);

        //获取属性
        $attr           = $info->attr;
        //获取排序
        $sort_name      = $info->sort_name;
        $sort_value     = $info->sort_value;

        $grid           = new Grid();

        //设置相关参数
        $grid->put('min',$min);
        $grid->put('max',$max);
        $grid->put('cat_id',$cat_id);
        $grid->put('brand_id',$brand_id);
        $grid->put('attr',$attr);
        $grid->put('sort_name',$sort_name);
        $grid->put('sort_value',$sort_value);

        //设置分页
        $per_page       = intval(Category::list_page_size());
        $current_page   = $info->current_page;
        $total          = intval($grid->total());
        $last_page      = ceil($total/$per_page);

        //如果当前分页大于最后一页
        if($current_page > $last_page){

            $current_page = 1;
        }
        
        $page           = new Page();
        $page->put('current_page',$current_page);
        $page->put('last_page',$last_page);
        $page->put('per_page',$per_page);
        $page->put('total',$total);

        //给grid组件设置分页信息
        $grid->put('page',$page);

        return $grid->render();

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理自定义页面
    |
    |-------------------------------------------------------------------------------
    */
    public function diy_url($diy_url){

    	$model 			= Category::where('diy_url',$diy_url)->first();

    	if(empty($model)){

    		return $this->view('404');
    	}

    	return $this->index($model->id);
    }


   
    /*
    |-------------------------------------------------------------------------------
    |
    | 获取所有分类目录
    |
    |-------------------------------------------------------------------------------
    */
    public function catalog(){

        $common                     = new Common();
        $view                       = $this->view('catalog');
        $view->breadcrumb           = $common->get_breadcrumb(trans('front.catalog'));
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.catalog'),url('catalog'));
        $view->catalog              = Category::catalog();

        return $view;


    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 移动版本的分类
    |
    |-------------------------------------------------------------------------------
    */
    public function catalog_mobile($id){

        $root                       = Category::find($id);
        if(empty($root)){

            return $this->view('404');
        }

        if($root->isRoot()){

            $back_url               = url('catalog');
        }
        else{

            $back_url               = url('catalog/'.$root->parent()->first()->id);
        }

        $view                       = $this->view('catalog_mobile');
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile($root->cat_name,url('catalog'));
        $view->root                 = $root;
        $view->back_url             = $back_url;

        return $view;


    }
}