<?php namespace Phpstore\Base;

use HTML;
use Phpstore\Base\Lang;
use View;
class Sysinfo{

    protected $title;
    protected $description;
    protected $keywords;
    protected $appname;
    protected $copyright;
    protected $menu;
    protected $row;
    protected $view;
    protected $view2;
    protected $url;
    protected $path_url;
    protected $page;
    protected $tag;
    protected $action_name;


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){


        $this->title            = Lang::get('title');
        $this->description      = Lang::get('description');
        $this->keywords         = Lang::get('keywords');
        $this->appname          = Lang::get('appname');
        $this->copyright        = Lang::get('copyright');
        $this->action_name      = Lang::get('action_name');
        $this->form_validate_url 	  = '';

        $menu                   = new \Phpstore\Base\Menu();
        $this->menu             = $menu->menu();
        $this->path_url         = $this->get_path_url('系统提示');
        $this->row              = ['title','description','keywords','appname','menu','copyright','path_url','action_name','form_validate_url'];

        $this->view             = view('simple.info');
        $this->view2            = view('simple.validator');
        $this->view3            = view('simple.info');

        //初始化系统模板变量
        $this->init();



    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  系统初始化
    |
    |-------------------------------------------------------------------------------
    */
    public function init(){

        //把变量赋值给模板文件
        foreach($this->row as $item){

            $this->view->$item              = $this->$item;
            $this->view2->$item             = $this->$item;
            $this->view3->$item             = $this->$item;
        }


    }





    /*
    |-------------------------------------------------------------------------------
    |
    |  初始化变量 方法put
    |
    |-------------------------------------------------------------------------------
    */
     public function put($key , $value){

        $this->$key                 = $value;
        $this->view->$key           = $value;
        $this->view2->$key          = $value;
        $this->view3->$key          = $value;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回信息提示页面
    |
    |-------------------------------------------------------------------------------
    */
    public function info(){

        return $this->view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回信息提示页面 不自动跳转
    |
    |-------------------------------------------------------------------------------
    */
    public function no_jump_info(){

        return $this->view3;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  模型为空或者非法操作
    |
    |-------------------------------------------------------------------------------
    */
    public function forbidden(){

        $this->put('info',Lang::get('forbidden'));
        return $this->view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  操作执行失败
    |
    |-------------------------------------------------------------------------------
    */
    public function fails(){

        $this->put('info',Lang::get('fails'));
        return $this->view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  批量选择为空或者未选择
    |
    |-------------------------------------------------------------------------------
    */
    public function batchEmpty(){

        $this->put('info',Lang::get('empty'));
        return $this->view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  登陆失败提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function login_error(){

        $this->put('info','账号密码错误');
        $this->put('url',HTML::link('admin/login','重新登陆'));
        $this->view->page = '';
        $this->view->tag  = '';
        return $this->view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  返回信息提示页面 验证错误提示页面
    |
    |-------------------------------------------------------------------------------
    */
    public function error(){

        $this->view2->messages      = $this->validator->messages();

        return $this->view2;
    }


    /*
    |--------------------------------------------------------------------------
    |
    | 返回面包屑导航
    |
    |--------------------------------------------------------------------------
    */
    public function get_path_url($url){

        $str  =     '<div class="row">'
                   .'<div class="col-md-12">'
                   .'<h3 class="page-title">'
                   .'PHPSTORE <small>'.Lang::get('home').'</small>'
                   .'</h3>'
                   .'<ul class="page-breadcrumb breadcrumb">'
                   .'<li>'
                   .'<i class="fa fa-home"></i>'
                   .HTML::link('admin/index','')
                   .Lang::get('home')
                   .'</a>'
                   .'<i class="fa fa-angle-right"></i>'
                   .'</li>'
                   .'<li>'
                   .$url
                   .'</li>'
                   .'</ul></div></div>';

        return $str;
    }
}
