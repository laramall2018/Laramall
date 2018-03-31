<?php

namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use DB;
use Request;
use Hash;
use Auth;
use Phpstore\Front\UserCommon;
use Phpstore\Crud\ImageLib;
use App\Models\OrderReturn;
use Captcha;


class MyUserController extends UserController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->common       = new Common();
        $this->helper       = new UserCommon();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   处理注册post请求
    |
    |-------------------------------------------------------------------------------
    */
    public function register_post(){

        //验证其他登录项
         $rules                     = [

                                            'username'                  =>'required|min:2|unique:users,username',
                                            'phone'                     =>'required|min:11|max:11',
                                            'password'                  =>'required|min:6|confirmed',
                                            'password_confirmation'     =>'required',
                                            'email'                     =>'email|unique:users,email',
                                            'captcha'                   => 'required|captcha'
                                    ];

         $validator                 = Validator::make(Request::all(),$rules);
         if($validator->fails()){

              $view                 = $this->view('common_info');
              $view->breadcrumb     = $this->common->get_breadcrumb(trans('front.register'));
              $view->back_url       = url('auth/register');

              $info                 = '';

              foreach($validator->messages()->all() as $message){

                 $info              .= '<div class="alert alert-danger">'.$message.'</div>';
              }
              $view->info           = $info;

              return $view;
         }

         //处理注册的业务逻辑
         $model                     = new User();

         $model->username           = request()->username;
         $model->password           = Hash::make(request()->password);
         $model->phone              = request()->phone;
         $model->add_time           = time();
         $model->ip                 = Request::getClientIp();

         //如果你想增加其他字段 这里可以加
         $model->shengao            = request()->shengao;
         //其他字段类推

         if($model->save()){

             $view                  = $this->view('common_info');
             $view->breadcrumb      = $this->common->get_breadcrumb(trans('front.register'));
             $view->back_url        = url('auth/center');
             $view->info           = '<div class="alert alert-success">'.trans('front.register_success').'</div>';

             return $view;
         }
         else{

                $view               = $this->view('common_info');
                $view->breadcrumb   = $this->common->get_breadcrumb(trans('front.register'));
                $view->info         = '<div class="alert alert-danger">'.trans('message.store_error').'</div>';
                $view->back_url     = url('auth/register');
                return $view;

            }
    }




    /*
    |----------------------------------------------------------------------------
    |
    |  读取远程https的json格式数据
    |
    |----------------------------------------------------------------------------
    */
    public function get_https_json($url){


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   ajax检测登录时候 用户输入的验证码是否正确
    |   对应的路由为：
    |
    |-------------------------------------------------------------------------------
    */
    public function captcha_check(){
 
         $captcha               = Request::input('captcha');
         $rules                 = ['captcha'=>'required|captcha'];
         $validator             = Validator::make(Request::all(),$rules);
        
         //验证未通过 则返回错误提示页面
         if($validator->fails()){

            return 'false';

         }
         else{

            return 'true';
         }
    }

}
