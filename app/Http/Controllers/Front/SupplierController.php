<?php
/*
|-------------------------------------------------------------------------------
|
|  供货商控制器
|
|-------------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Front;

use App\User;
use App\Supplier;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use App\Models\Article;
use Auth;
use Request;
use DB;
use Hash;


class SupplierController extends BaseController
{


    public $common;
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

        $this->common               = new Common();
    }


    


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示注册表单
    |
    |-------------------------------------------------------------------------------
    */
    public function register(){

        if(Auth::check('supplier')){

            return redirect('supplier/center');
        }

        $view                       = $this->view('supplier.register');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.supplier'));
        

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理注册表单 post
    |
    |-------------------------------------------------------------------------------
    */
    public function  register_store(){

        if(Auth::check('supplier')){

            return '供货商已经登录';
        }

       


        $username                   = Request::input('username');
        $password                   = Request::input('password');
        $phone                      = Request::input('phone');
        $email                      = Request::input('email');

        $rules                      = [

                                        'username'  =>'required|min:2',
                                        'password'  =>'required',
                                        'email'     =>'required|email',
                                        'phone'     =>'required',
        ];

        $validator                  = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $view                   = $this->view('supplier.validate');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.supplier_register'));
            $view->messages         = $validator->messages();
            $view->back_url         = url('supplier/register');

            return $view;
        }


        $model                      = new Supplier();
        $model->username            = $username;
        $model->password            = Hash::make($password);
        $model->email               = $email;
        $model->phone               = $phone;
        $model->tag                 = 0;
        
        //注册成功 进入未审核状态
        if($model->save()){

            $view                   = $this->view('supplier.info');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.supplier'));
            $view->info             = '<i class="fa fa-check"></i>您已经成功递交申请，我们会尽快审核。请耐心等待';
            $view->back_url         = url('supplier/center');

            return $view;  
        }
        else{

            $view                   = $this->view('supplier.info');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.supplier'));
            $view->info             = '<i class="fa fa-check"></i>申请失败';
            $view->back_url         = url('supplier/register');

            return $view;  

        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  供货商登录
    |
    |-------------------------------------------------------------------------------
    */
    public function login(){

        if(Auth::check('supplier')){

            return redirect('supplier/center');
        }

        $view                     = $this->view('supplier.login');
        $view->breadcrumb         = $this->common->get_breadcrumb(trans('front.supplier_login'));
        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  供货商登录 post 请求
    |
    |-------------------------------------------------------------------------------
    */
    public function login_post(){

        $email                      = Request::input('email');
        $password                   = Request::input('password');


        $rules                      = [

                                    'email'     =>'required|email',
                                    'password'  =>'required',
        ];

        $validator                  = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $view                   = $this->view('supplier.validate');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.supplier_login'));
            $view->messages         = $validator->messages();
            $view->back_url         = url('supplier/login');

            return $view;
        }

        if(Auth::attempt('supplier',['email'=>$email,'password'=>$password],true)){

            return redirect('supplier/center');
        }


        return  redirect('supplier/login');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  更新资料
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

        if(!Auth::check('supplier')){

            return redirect('supplier/login');
        }

            $username               = Request::input('username');
            $email                  = Request::input('email');
            $phone                  = Request::input('phone');
            $password               = Request::input('password');

            $id                     = Auth::user('supplier')->id;
            $model                  = Supplier::find($id);

            $rules                  = [

                                        'username'  =>'required|unique:supplier,username,'.$id,
                                        'email'     =>'required|unique:supplier,email,'.$id,
                                        'phone'     =>'required',

            ];

            $validator              = Validator::make(Request::all(),$rules);

            if($validator->fails()){

                $view                   = $this->view('supplier.validate');
                $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.supplier_center'));
                $view->messages         = $validator->messages();
                $view->back_url         = url('supplier/center');
            }


            $model->username        = $username;
            $model->email           = $email;
            $model->phone           = $phone;

            if($password){

                $model->password    = Hash::make($password);
            }

            $model->save();

            return redirect('supplier/center');


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  供货商管理中心
    |
    |-------------------------------------------------------------------------------
    */
    public function center(){

         if(!Auth::check('supplier')){


            return redirect('supplier/login');
         }

         $view                  = $this->view('supplier.center');
         $view->breadcrumb      = $this->common->get_breadcrumb(trans('front.supplier_center'));
         $view->user            = Auth::user('supplier');

         return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  注册前端的ajax验证用户名重名
    |
    |-------------------------------------------------------------------------------
    */
    public function register_validate(){

        $username               = Request::input('username');

        $row                    = Supplier::where('username',$username)->first();

        if($row){

            return 'false';
        }

        return 'true';

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  供货商退出
    |
    |-------------------------------------------------------------------------------
    */
    public function logout(){

        if(Auth::check('supplier')){

            Auth::logout('supplier');
        }

        return redirect('supplier/login');
    }


}