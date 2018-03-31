<?php namespace App\Http\Controllers\Admin;

use Artisan;
use Auth;
use Cache;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Request;
use URL;
use Validator;

class AdminLoginController extends BaseController{



    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */


    public $page;
    public $tag;
    public $view;
    public $layout;
    public $form;
    public $crud;
    public $row;
    public $form_to_model;
    public $admin_login_url;

    function __construct(){

    	parent::__construct();

        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        $this->sysinfo              = new Sysinfo();

        $this->sysinfo->put('page','');
        $this->sysinfo->put('tag','');

        $this->title                = '后台登陆';
        $this->admin_login_url      = env('ADMIN_LOGIN_URL');
    }


    /*
    |------------------------------------------------------------------
    |
    |  显示所有管理员列表
    |
    |------------------------------------------------------------------
    */

    public function login(){

        if(Auth::check('admin')){

            return redirect('admin/index');
        }

        $view                       = $this->view('login');
        $view->title                = $this->title;
        $view->admin_login_url      = $this->admin_login_url;

        return $view;
    }


   


    /*
    |---------------------------------------------------------------------
    |
    |  登陆验证
    |
    |---------------------------------------------------------------------
    */
    public function login_post(){

        $username       = Request::input('username');
        $password       = Request::input('password');
        $remember       = Request::input('remember');

        if($remember == 1){

            $tag   = true;
        }
        else{

            $tag   = false;
        }

        if(Auth::attempt("admin",['username'=>$username,'password'=>$password],$tag)){

           
            return redirect('admin/index');
        }
        else{

            return redirect($this->admin_login_url)->with('error_info','用户名密码错误');
        }
    } 


    /*
    |---------------------------------------------------------------------
    |
    |  退出登陆
    |
    |---------------------------------------------------------------------
    */
    public function logout(){

        if(Auth::check('admin')){

            Auth::logout('admin');
            return redirect($this->admin_login_url);
        }
    }


    /*
    |---------------------------------------------------------------------
    |
    |  清除缓存
    |
    |---------------------------------------------------------------------
    */
    public function cache_clear(){

        Cache::flush();
        return redirect('admin/index');
    }
}
