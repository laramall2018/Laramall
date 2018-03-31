<?php
/*
|-------------------------------------------------------------------------------
|
|  新闻前端控制器
|
|-------------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use App\Models\ArticleCat;

class ArticleCatController extends BaseController
{


    /*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
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
    |  新闻分类页面
    |
    |-------------------------------------------------------------------------------
    */
    public function index($id){

        $model                      = ArticleCat::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $common                     = new Common();
        $view                       = $this->view('article_cat');
        $view->article_list         = $common->get_article_list($id);
        $view->breadcrumb           = $common->get_breadcrumb($model->cat_name);
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile($model->cat_name,$model->url());
        $view->cat                  = $model;
        $view->cat_id               = $model->id;
        $view->article_category     = ArticleCat::where('parent_id',0)->get();
        $view->model                = $model;
                
        return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  为新闻自定义链接做路由跳转
    |
    |-------------------------------------------------------------------------------
    */
    public function diy_url($diy_url){

        $model                          = ArticleCat::where('diy_url',$diy_url)->first();

        if(empty($model)){

            return $this->view('404');
        }

        return $this->index($model->id);

    }


}