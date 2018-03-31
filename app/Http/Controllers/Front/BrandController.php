<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,Auth,Validator;
use Phpstore\Base\Common;
use App\Models\Brand;
use App\Models\Goods;

class BrandController extends BaseController
{   

    public $common;
    

    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        parent::__construct();

        $this->common       = new Common();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有品牌列表页面
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                       = $this->view('brand_list');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.brand_list'));
        $view->brand_list           = Brand::orderBy('sort_order')->paginate(20);
        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 显示品牌详情
    |
    |-------------------------------------------------------------------------------
    */
    public function show($id){

        $model                     = Brand::find($id);
        if(empty($model)){

            return $this->view('404');
        }

        $view                      = $this->view('brand_detail');
        $view->breadcrumb          = $this->common->get_breadcrumb(trans('front.brand_detail'));
        $view->model               = $model;
        $view->goods_list          = $model->goods()->paginate(20);

        return $view;
    }
}
