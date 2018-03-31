<?php

namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Phpstore\Base\Common;
use Request;
use Auth;
use DB,Cache;
use BrowserDetect;
use App\Models\Category;
use App\Models\Nav;
use App\Models\Template;
use App\Models\StyleModel;
use App\Models\ArticleCat;
use App\Models\Theme;

class BaseController extends Controller
{
    



    public  $view;
    public  $common;
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
        //中间件 检测用户是否为前台登录用户
        //$this->middleware('demo.auth');
        $this->common                        = new Common();
        
    }


    /*
     * 设定模板文件夹
     *
     */
    public function view($templatename){


        $common                                 = new Common();
        $base_template                          = $this->get_base_template();
        $this->view                             = view($base_template.'.'.$templatename);
        $this->view->copyright                  = Common::copyright();
        $this->view->mobile_version             = Common::mobile_version();
        $this->view->footer_desc                = Template::get('footer_desc');
        $this->view->category                   = Category::getList();
        $this->view->middle_nav                 = Nav::getList('middle');
        $this->view->body_id                    = '';
        $this->view->cart_num                   = $common->get_cart_number();
        $this->view->style_list                 = StyleModel::getList();
        //批量赋值
        $data                                   = \App\Models\Config::systemConfig();

        foreach($data as $key=>$value){

            $this->view->$key                   = $value;
        }
        $this->view->title                      = $data['shop_title'];
        $this->view->address                    = $data['shop_address'];
        $this->view->help                       = ArticleCat::getHelpList();
        //wap
        $wap_config                             = $this->get_wap_config();
        foreach($wap_config as $item){

            $code                               = $item->code;
            $this->view->$code                  = $item->value;
        }

        $this->view->google_font_url            = url();
        $this->view->checkout_url               = url('cart');

        

        return $this->view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 输出json格式的数据
    |
    |-------------------------------------------------------------------------------
    */
    public function toJSON($arr){

        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        exit;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 简化处理 Request方法
    |
    |-------------------------------------------------------------------------------
    */
    public function R($str){

        return Request::input($str);
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  检测前台用户是否登录
    |
    |----------------------------------------------------------------------------
    */
    public function is_front(){

        if(Auth::check('user')){

            return true;
        }

        return false;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  模型为空或者非法操作
    |
    |----------------------------------------------------------------------------
    */
    public function model_is_empty($back_url){


            $common                 = new Common();
            $view                   = $this->view('common_info');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.message_info'));

            $info                   = trans('front.model_is_empty_or_forbidden');
            $cls                    = 'alert alert-danger';
            $i                      = '<i class="fa fa-times"></i>';
            $view->info             = $common->get_message_info($info,$i,$cls);
            $view->back_url         = url($back_url);

            return $view;
    }


    /*
    |----------------------------------------------------------------------------
    |
    |  表单验证失败
    |
    |----------------------------------------------------------------------------
    */
    public function validator_is_fails($validator,$back_url){

            $common                 = new Common();
            $view                   = $this->view('common_info');
            $view->breadcrumb       = $common->get_breadcrumb(trans('front.message_info'));
            $view->info             = $common->get_validator_message($validator);
            $view->back_url         = url($back_url);
            return $view;
    }

    /*
    |----------------------------------------------------------------------------
    |
    |  数据库存储或者更新失败
    |
    |----------------------------------------------------------------------------
    */
    public function operate_database_is_fails($back_url){

            $common                 = new Common();
            $view                   = $this->view('common_info');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.message_info'));

            $info                   = trans('front.operate_database_is_fails');
            $cls                    = 'alert alert-danger';
            $i                      = '<i class="fa fa-times"></i>';
            $view->info             = $common->get_message_info($info,$i,$cls);
            $view->back_url         = url($back_url);

            return $view;
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

        if(BrowserDetect::isTablet()){

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
    public function get_base_template(){

        if($this->is_desktop()){

            return Theme::pc();
        }
        elseif($this->is_mobile()){

            return 'materialize';
        }
        elseif($this->is_tablet()){

            return 'materialize';
        }
        else{

            return Theme::pc();
        }
    }





/*
|-------------------------------------------------------------------------------
|
|  获取移动端的面包屑导航
|
|-------------------------------------------------------------------------------
*/
function breadcrumb_mobile($name,$url){

    $str        = '<nav class="blue">'
                 .'<div class="nav-wrapper">'
                 .'<div class="col s12">'
                 .'<a href="'.url('/').'" class="breadcrumb">'.trans('front.home').'</a>'
                 .'<a href="'.$url.'" class="breadcrumb">'.$name.'</a>'
                 .'</div>'
                 .'</div>'
                 .'</nav>';

    return $str;
}


/*
|-------------------------------------------------------------------------------
|
|  获取移动端的所有配置文件
|
|-------------------------------------------------------------------------------
*/
function get_wap_config(){

    if(Cache::has('wap_config_list')){

        return Cache::get('wap_config_list');
    }
  

    $arr      = $this->get_wap_config_from_db();
    Cache::put('wap_config_list',$arr,3600);

    return Cache::get('wap_config_list');

}


/*
|-------------------------------------------------------------------------------
|
|  获取移动端的所有配置文件 从数据库中获取
|
|-------------------------------------------------------------------------------
*/
function get_wap_config_from_db(){

    $res      = DB::table('wap_config')->get();

    return $res;
}



}