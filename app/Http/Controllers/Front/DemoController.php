<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use BrowserDetect;

class DemoController extends Controller
{
    


    /*
    |-------------------------------------------------------------------------------
    |
    | 演示站显示页面
    |
    |-------------------------------------------------------------------------------
    */
    public function index()
    {
         
         $title             = trans('index.title');
         $google_font_url   = url();
         $template_name     = $this->get_template_name();

         return view($template_name,compact('title','google_font_url'));
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 演示账户登录
    |
    |-------------------------------------------------------------------------------
    */
    public function login(){

        $password       = request()->password;
        $username       = 'demo';

        if(Auth::attempt("demo",['username' => $username, 'password' => $password])){

             return redirect('demo');
        }

        else{

            return redirect('demo');
        }

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 登出
    |
    |-------------------------------------------------------------------------------
    */
    public function logout(){

        if(Auth::check('demo')){

            Auth::logout('demo');

            return redirect('demo');
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  判断是否是移动端
    |
    |-------------------------------------------------------------------------------
    */
    public function is_mobile(){

        if(BrowserDetect::isMobile()){

            return true;
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  判断是否是平板电脑
    |
    |-------------------------------------------------------------------------------
    */
    public function is_tablet(){

        if(BrowserDetect::isTablet()){

            return true;
        }

        return false;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  判断是否是pc版本
    |
    |-------------------------------------------------------------------------------
    */
    public function is_desktop(){

        if(BrowserDetect::isDesktop()){

            return true;
        }

        return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取基础模板目录
    |
    |-------------------------------------------------------------------------------
    */
    public function get_template_name(){

        if($this->is_desktop()){

            return 'demo.index';
        }
        elseif($this->is_mobile()){

            return 'demo.mobile';
        }
        elseif($this->is_tablet()){

            return 'demo.mobile';
        }
        else{

            return 'demo.index';
        }
    }



    
}
