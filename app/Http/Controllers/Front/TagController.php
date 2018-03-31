<?php

namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use Request;
use App\Models\Tag;
use App\Models\Category;

class TagController extends BaseController
{


    public $common;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

            parent::__construct();
            
            $this->common          = new Common();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 首页显示控制器
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                       = $this->view('tag');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.tag_list'));
        $view->title                = $this->view->title.'-'.trans('front.tag_list');
        $view->cat                  = Category::first();
        $view->tag_list             = Tag::paginate(50);
        

        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取首页商品个数配置
    |
    |-------------------------------------------------------------------------------
    */
    public function get_tp_goods_number($code){

        $num    = 8;
        if($res = $this->common->get_template_config($code)){

            return $res;
        }


        return $num;
    }


}