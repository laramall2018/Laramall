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
use App\Models\Article;
use App\Models\ArticleCat;

class ArticleController extends BaseController
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
    |  新闻详情页面
    |
    |-------------------------------------------------------------------------------
    */
    public function index($id){

        $model                      = Article::find($id);

        if(empty($model)){

            return $this->view('404');
        }

        $common                     = new Common();
        $view                       = $this->view('article');
        $view->article_info         = $common->get_article_info($id);
        $view->breadcrumb           = $common->get_breadcrumb($model->title);
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile($model->title,url('article/'.$id));
        $view->model                = $model;
        $view->article_category     = ArticleCat::where('parent_id',0)->get();
        $view->cat_id               = $model->cat_id;
                
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

        $model                          = Article::where('diy_url',$diy_url)->first();

        if(empty($model)){

            return $this->view('404');
        }

        return $this->index($model->id);

    }


}