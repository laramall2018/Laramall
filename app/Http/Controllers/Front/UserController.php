<?php

namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Goods;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\CollectGoods;
use Phpstore\Base\Common;
use DB;
use Request;
use Hash;
use Auth;
use Phpstore\Front\UserCommon;
use Phpstore\Crud\ImageLib;
use App\Models\OrderReturn;
use Captcha;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\Config;


class UserController extends BaseController
{
    

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    public $common;
    public $helper;
    public $img;
    public $weixin;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->common       = new Common();
        $this->helper       = new UserCommon();
        $this->weixin       = new \Phpstore\Weixin\Common();

        $this->beforeFilter('throttle:5,1', ['only' =>['login_post']]);

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 登录表单界面
    |
    |-------------------------------------------------------------------------------
    */
    public function login_form(){

       

        if($this->helper->is_front()){

            return redirect('auth/center');
        }


        $view                       = $this->view('login');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.login'));
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.login'),url('auth/login'));
        
        return  $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成微信登录链接
    |
    |-------------------------------------------------------------------------------
    */
    public function weixin_login(){

        return redirect($this->weixin->get_code_url());

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  跳转到 auth/weixin/login?code=code 获取code
    |
    |-------------------------------------------------------------------------------
    */
    public function weixin_login_code(){

        //获取用户信息
        $json   = $this->weixin->userInfo(request()->code);
        //使用微信账号登录
        return $this->weixin->login($json);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理登录的post请求
    |
    |-------------------------------------------------------------------------------
    */
    public function login_post(Request $request){

         $username     = request()->username;
         $password     = request()->password;

         $rules         = [
                                    'captcha' => 'required|captcha',
                                    'username'=> 'required|min:2',
                                    'password'=> 'required|min:6'
                          ];
         $messages      = [
                                     'username.min'       =>'用户名称必须为2位或者以上',
                                     'password.min'       =>'密码必须为6位以上',
                                     'captcha.captcha'    =>'验证码不正确',
         ];
         
         $validator     = Validator::make(request()->all(),$rules,$messages);

         //验证表单数据格式
         if($validator->fails()){

            return redirect('auth/login')->withInput()->withErrors($validator->messages());
         }

         if(Auth::attempt("user",['username' => $username, 'password' => $password],true)){

               //登录成功 写入登录ip
               $user                = User::find(Auth::user('user')->id);
               $user->login_ip      = request()->ip();
               $user->save();

               return redirect('auth/center');
         }

         else{

              

               $view                       = $this->view('validate');
               $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.login'));
               $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.login'),url('auth/login'));
               $view->info                 = trans('message.user_or_password_error');
               $view->back_url             = url('auth/login');
               $view->url_name             = trans('front.back_to_pre');

               return $view;
         }

         
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   处理注册表单
    |
    |-------------------------------------------------------------------------------
    */
    public function register_form(){

        if($this->helper->is_front()){

            return redirect('auth/center');
        }

        if(Config::get('register_closed') == 1){

                $view               = $this->view('common_info');
                $view->breadcrumb   = $this->common->get_breadcrumb(trans('front.register'));
                $view->info         = '<div class="alert alert-danger">暂停注册</div>';
                $view->back_url     = url('/');
                return $view;
        }

        $view                       = $this->view('register');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.register'));
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.register'),url('auth/register'));
        

        return  $view;


    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   处理注册post请求
    |
    |-------------------------------------------------------------------------------
    */
    public function register_post(){


         $username                  = Request::input('username');
         $phone                     = Request::input('phone');
         $password                  = Request::input('password');
         $password_confirmation     = Request::input('password_confirmation');

        
         //验证其他登录项

         $rules                     = [

                                            'username'                  =>'required|min:2|unique:users,username',
                                            'password'                  =>'required|min:6|confirmed',
                                            'password_confirmation'     =>'required',
                                            'email'                     =>'required|email|unique:users,email',
                                            'captcha'                   =>'required|captcha'
                                    ];

         $validator                 = Validator::make(Request::all(),$rules);

         if($validator->fails()){

             
              if($this->is_mobile()){

                 return redirect('auth/register')->withInput()->withErrors($validator->messages());
              }

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



         

         if($model = User::create(request()->all())){


             $data['add_time']      = time();
             $data['ip']            = request()->getClientIP();
             $data['password']      = Hash::make(request()->password);
             $data['reg_from']      = 'pc';
             

             if(\BrowserDetect::isMobile()){
                $data['reg_from']   = 'mobile';
             }
             
             User::where('id',$model->id)->update($data);

             $view                  = $this->view('common_info');
             $view->breadcrumb      = $this->common->get_breadcrumb(trans('front.register'));
             

             if($this->is_mobile()){

                 $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('front.register'),url('auth/register'));
              }

             $view->back_url        = url('auth/center');
             $view->info            = '<div class="alert alert-success"><p>'.trans('front.register_success').'</p></div>';
             $view->url_name        = trans('front.to_auth_center');


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
    |-------------------------------------------------------------------------------
    |
    |   ajax检测注册用户是否重名
    |
    |-------------------------------------------------------------------------------
    */
    public function register_check(){

        $username       = Request::input('username');

        $res            = DB::table('users')->where('username',$username)->first();

        if(empty($res)){

            return 'true';
        }

        return 'false';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   ajax检测登录时候 用户输入的验证码是否正确
    |
    |-------------------------------------------------------------------------------
    */
    public function captcha_check(){
 
         $captcha               = request()->captcha;
         $rules                 = ['captcha'=>'required|captcha'];
         $validator             = Validator::make(request()->all(),$rules);
        
         //验证未通过 则返回错误提示页面
         if($validator->fails()){

            return 'false';

         }
         else{

            return 'true';
         }
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   刷新验证码
    |
    |-------------------------------------------------------------------------------
    */
    public function captcha_ajax(){

       
        $img             = captcha_src('flat');

        return $this->toJSON(['img'=>$img]);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 处理用户中心
    |
    |-------------------------------------------------------------------------------
    */
    public function user_center(){

        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }

        $view                           = $this->view('user_center');
        $view->breadcrumb               = $this->common->get_breadcrumb(trans('front.user_center'));
        $view->menu_tag                 = 'center';
        $view->rank                     = $this->get_rank_info();
        $view->sex_name                 = $this->get_sex_name(Auth::user('user')->sex);
        $view->last_login_time          = $this->get_last_login_time(Auth::user('user')->last_login_time);
        $view->user                     = Auth::user('user');

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 用户资料
    |
    |-------------------------------------------------------------------------------
    */
    public function profile(){

       if(!Auth::check('user')){

           return redirect('auth/login');
       }

       $view                          = $this->view('user_profile');
       $view->user                    = Auth::user('user');
       $view->back_url                = url('auth/center');
       return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 用户资料编辑
    |
    |-------------------------------------------------------------------------------
    */
    public function profile_edit(){

        if(!Auth::user('user')){

            return redirect('auth/login');
        }

        if(!$this->is_mobile()){

           return redirect('auth/center');
        }

        $view                       = $this->view('user_profile_edit');
        $view->breadcrumb_mobile    = $this->breadcrumb_mobile(trans('mobile.auth.profile.edit'),url('auth/profile/edit'));
        $view->user                 = Auth::user('user');
        $view->back_url             = url('auth/profile');

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 处理用户的资料修改
    |
    |-------------------------------------------------------------------------------
    */
    public function user_update(){

        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }

        $user                   = User::find(Auth::user()->id);
        
        $new_password           = Request::input('new_password');

        $rules                  = [ 'email'=>'required|email|unique:users,email,'.$user->id];

        $validator              = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $view                   = $this->view('common_info');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.user_center'));
            $view->back_url         = url('auth/center');
            $view->info             = $this->get_validator_info($validator);

            return $view;
        }

        //更新用户信息
        $user->update(request()->all());
        //更新密码
        $user->password();
        //更新用户头像
        $user->img();
        
        return redirect('auth/center');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 用户中心订单列表
    |
    |-------------------------------------------------------------------------------
    */
    public function order(){

        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }


        $view                   = $this->view('user_order');
        $view->menu_tag         = 'order';
        $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.order_list'));
        $view->breadcrumb_mobile = $this->breadcrumb_mobile(trans('front.order_list'),url('auth/order'));
        $view->order_list       = $this->helper->get_order_list();
        $view->user             = Auth::user('user');

        return $view;


    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 用户中心查看 具体一条订单信息
    |
    |-------------------------------------------------------------------------------
    */
    public function order_preview($id){



        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }

        $id                     = intval($id);

        $cart_common            = new \Phpstore\Front\CartCommon();
        $order                  = Order::find($id);

        $view                   = $this->view('user_order_detail');
        $view->menu_tag         = 'order';
        $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.order_detail'));
        $view->order            = Order::find($id);
        $view->order_goods      = $order->order_goods()->get();
        $view->order_status     = $this->helper->get_order_status($id);
        $view->pay_btn          = $cart_common->get_pay_btn($order);
        $view->user             = Auth::user('user');

        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 用户中心查看 取消订单
    |
    |-------------------------------------------------------------------------------
    */
    public function order_cancel($id){

        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }

        $order          = Order::find($id);

        if(empty($order)){

            return redirect('auth/order');
        }

        $order->cancel_status   = 1;
        $order->save();

        return redirect('auth/order'); 

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 用户中心查看收藏列表
    |
    |-------------------------------------------------------------------------------
    */
    public function collect(){

        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }

        $view                       = $this->view('user_collect');
        $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.collect'));
        $view->menu_tag             = 'collect';

        $collect_goods              = DB::table('collect_goods as cg')
                                        ->leftjoin('goods as g','g.id','=','cg.goods_id')
                                        ->where('cg.user_id','=',Auth::user()->id)
                                        ->select('g.goods_name','cg.goods_id','cg.add_time','cg.id')
                                        ->paginate(10);

        $view->collect_goods        = $collect_goods;
        $view->user                 = Auth::user('user');
        return $view;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 用户中心查看收藏列表
    |
    |-------------------------------------------------------------------------------
    */
    public function collect_del($id){

        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }


        $id         = intval($id);
        $model      = CollectGoods::find($id);

        if($model){

            $model->delete();
        }

        return redirect('auth/collect');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 用户中心查看退货单
    |
    |-------------------------------------------------------------------------------
    */
    public function order_return(){

        if(!Auth::check('user')){

            return redirect('auth/login');
        }


        $view                   = $this->view('order_return');
        $view->menu_tag         = 'order.return';
        $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.order_return_list'));
        $view->return_list      = $this->helper->get_order_return_list();
        $view->user             = Auth::user('user');

        return $view;


    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 申请退货表单状态
    |
    |-------------------------------------------------------------------------------
    */
    public function return_send(){

        if(!Auth::check('user')){

            return redirect('auth/login');
        }


        $view                   = $this->view('return_form');
        $view->menu_tag         = 'order.return';
        $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.order_return_list'));
        $view->order_list       = DB::table('order_info')
                                    ->where('user_id',Auth::user('user')->id)
                                    ->where('pay_status',1)
                                    ->where('return_status',0)
                                    ->where('cancel_status',0)
                                    ->get();

        return $view;


    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 申请退货表单状态 post
    |
    |-------------------------------------------------------------------------------
    */
    public function return_post(){

        if(!Auth::check('user')){

            return redirect('auth/login');
        }

        $rules              = [

                                'order_id'=>'required|unique:order_return,order_id',
                                'username'=>'required',
                                'type'    =>'required',
                                'return_note'=>'required',
        ];

        $validator          = Validator::make(Request::all(),$rules);

        //验证没通过 则返回提示页面
        if($validator->fails()){

            $view                   = $this->view('common_info');
            $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.order_return_send'));
            $view->back_url         = url('auth/return/send');
            $view->info             = $this->get_validator_info($validator);

            return $view;
        }

        

        if($model = OrderReturn::create(request()->all())){

                $model->add_time        = time();
                $model->ip              = request()->getClientIP();
                $model->return_status   = 1;
                $model->save();

                //修改订单的退货状态
                $order                  = Order::find(request()->order_id);
                $order->return_status   = 1;
                $order->save();

                $view                   = $this->view('common_info');
                $view->breadcrumb       = $this->common->get_breadcrumb(trans('front.order_return_send'));
                $info                   = '您已经递交退货申请,请等待管理员批准';
                $i                      = '<i class="fa fa-check"></i>';
                $cls                    = 'alert-success';
                $view->info             = $this->get_message_info($info ,$i,$cls);
                $view->back_url         = url('auth/return');

                return $view;
            }


            return redirect('auth/return');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 查看详细的退货单
    |
    |-------------------------------------------------------------------------------
    */
    public function return_preview($id){

        if(!Auth::check('user')){

            return redirect('auth/login');
        }

        $model                          = OrderReturn::find($id);


        if(empty($model)){

            $view                       = $this->view('common_info');
            $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.order_return'));

            $info                       = '您访问的模型不存在';
            $i                          = '<i class="fa fa-times"></i>';
            $cls                        = 'alert-danger';
            $view->info                 = $this->get_message_info($info,$i,$cls);
            $view->back_url             = url('auth/return');

            return $view;

        }

           $view                        = $this->view('return_preview');
           $view->model                 = $model;
           $view->breadcrumb            = $this->common->get_breadcrumb(trans('front.order_return'));
           $view->menu_tag              = 'order.return';
           $view->return_goods          = $model->order->order_goods()->get();
           $view->order                 = $model->order;
           $view->user                  = Auth::user('user');
           return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 取消退货单
    |
    |-------------------------------------------------------------------------------
    */
    public function return_cancel($id){

        if(!Auth::check('user')){

            return redirect('auth/login');
        }

        $model          = OrderReturn::find($id);

        if(empty($model)){

            $view                       = $this->view('common_info');
            $view->breadcrumb           = $this->common->get_breadcrumb(trans('front.order_return'));

            $info                       = '您访问的模型不存在';
            $i                          = '<i class="fa fa-times"></i>';
            $cls                        = 'alert-danger';
            $view->info                 = $this->get_message_info($info,$i,$cls);
            $view->back_url             = url('auth/return');

            return $view;
        }

        $order                          = Order::find($model->order_id);
        $order->return_status           = 0;
        $order->save();
        //删除退货单
        $model->delete();

        return redirect('auth/return');

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 退出登录
    |
    |-------------------------------------------------------------------------------
    */
    public function logout(){

        if(!$this->helper->is_front()){

            return  redirect('auth/login');
        }

        //把登录的时间写入最后登录时间字段
        $user                       = Auth::user('user');
        $user->last_login_time      = time();
        $user->save();

        Auth::logout('user');

        return redirect('auth/login');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户等级信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_rank_info(){

        if(!Auth::check('user')){

            return false;
        }

        $rank_id        = Auth::user('user')->rank_id;

        if($rank_id == 0){

            return false;
        }

        $res            = DB::table('user_rank')->where('id',$rank_id)->first();

        if(empty($res)){

            return false;
        }


        return $res;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取验证信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_validator_info($validator){

        $messages       = $validator->messages();
        $str            = '';

        if(empty($messages)){

            return $str;
        }

        foreach($messages->all() as $message){

            $str  .= '<div class="alert alert-danger">'
                    .'<i class="fa fa-times"></i>'
                    .$message
                    .'</div>';
        }

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 生成前台模板需要的提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_message_info($info,$i,$cls){

        $str            = '<div class="alert '.$cls.'">'
                          .$i
                          .$info
                          .'</div>';
        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取性别名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_sex_name($sex){


        $row        = ['男','女','保密'];
        if(in_array($sex,[0,1,2])){

            return $row[$sex];
        }

        return $row[2];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取上次登录的时间
    |
    |-------------------------------------------------------------------------------
    */
    public function get_last_login_time($last_login_time){

         $last_login_time       = intval($last_login_time);

         if($last_login_time == 0){

            return '';
         }

         return date('Y/m/d',$last_login_time);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取退货单中的商品列表
    | order_info                id         order_sn
    | order_goods               order_id   goods_id    goods_name    shop_price
    | goods_gallery             goods_img  thumb       img
    |
    |-------------------------------------------------------------------------------
    */
    public function get_return_goods_list($order_sn){

        $res                = DB::table('order_goods as og')
                                //订单表和订单产品表 以订单编号关联
                                ->leftjoin('order_info as oi','oi.id','=','og.order_id')
                                ->leftjoin('goods_gallery as gg','gg.goods_id','=','og.goods_id')
                                ->where('oi.order_sn','=',$order_sn)
                                ->select('og.*','gg.thumb','gg.img')
                                ->get();
        return $res;


    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取错误提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function geErrorMessageInfo($messages){

        $str    = '';

        foreach($messages->all() as $message){

           $str  .= '<div class="alert alert-danger"><i class="fa fa-times"></i>'.$message.'</div>';
        }

        return $str;
    }
}