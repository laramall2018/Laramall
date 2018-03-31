<?php
/*
|-------------------------------------------------------------------------------
|
|  支付宝wap支付插件
|
|-------------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common as BaseCommon;
use App\Models\ArticleCat;
use App\Models\Payment;
use App\Models\Order;
use DB;
use Request;
use HTML;
use Phpstore\AlipayWap\AlipaySubmit;
use Phpstore\AlipayWap\AlipayNotify;
use Phpstore\Alipay\Common as AlipayCommon;


class AlipayWapController extends BaseController
{


    public $common;
    public $base;
    public $alipay_config;
    /*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct()
    {   

        $this->common           = new AlipayCommon();
        $this->base             = new BaseCommon();


    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取alipay-wap的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function get_alipay_wap_config(){

        $row            = Payment::where('pay_code','alipay')->first();
        $alipay_config  = [];
        $pid            = '';
        $account        = '';

        if(!empty($row)){

            $pid        = $row->pid;
            $account    = $row->account;
        }


        $alipay_config['partner']                       = $pid;

        //收款支付宝账号，一般情况下收款账号就是签约账号
        $alipay_config['seller_id']                     = $account;

        //商户的私钥（后缀是.pen）文件相对路径
        $alipay_config['private_key_path']              = public_path().'/alipaywap/key/rsa_private_key.pem';

        //支付宝公钥（后缀是.pen）文件相对路径
        $alipay_config['ali_public_key_path']           = public_path().'/alipaywap/key/alipay_public_key.pem';

        //签名方式 不需修改
        $alipay_config['sign_type']                     = strtoupper('RSA');

        //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['input_charset']                 = strtolower('utf-8');

        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert']                        = public_path().'/alipaywap/cacert.pem';

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']                     = 'http';

        return $alipay_config;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理支付宝的wap支付post请求
    |
    |-------------------------------------------------------------------------------
    */ 
    public function alipaywap(){


        //支付类型
        $payment_type               = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url                 = url('alipay-wap/notify_url.php');
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url                 = url('alipay-wap/return_url.php');
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
        $out_trade_no               = Request::input('WIDout_trade_no');
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject                    = Request::input('WIDsubject');
        //必填

        //付款金额
        $total_fee                  = Request::input('WIDtotal_fee');
        //必填

        //商品展示地址
        $show_url                   = Request::input('WIDshow_url');
        //必填，需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //订单描述
        $body                       = Request::input('WIDbody');
        //选填

        //超时时间
        $it_b_pay                   = Request::input('WIDit_b_pay');
        //选填

        //钱包token
        $extern_token               = Request::input('WIDextern_token');
        //选填

        $alipay_config              = $this->get_alipay_wap_config();



        //构造要请求的参数数组，无需改动
        $parameter                  = array(
                    
                    "service"           => "alipay.wap.create.direct.pay.by.user",
                    "partner"           => trim($alipay_config['partner']),
                    "seller_id"         => trim($alipay_config['seller_id']),
                    "payment_type"      => $payment_type,
                    "notify_url"        => $notify_url,
                    "return_url"        => $return_url,
                    "out_trade_no"      => $out_trade_no,
                    "subject"           => $subject,
                    "total_fee"         => $total_fee,
                    "show_url"          => $show_url,
                    "body"              => $body,
                    "it_b_pay"          => $it_b_pay,
                    "extern_token"      => $extern_token,
                    "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );

        //建立请求
        $alipaySubmit                   = new AlipaySubmit($alipay_config);
        $html_text                      = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  支付后返回页面
    |
    |-------------------------------------------------------------------------------
    */ 
    public function return_url(){

        $alipay_config          = $this->get_alipay_wap_config();
        $alipayNotify           = new AlipayNotify($alipay_config);
        $verify_result          = $alipayNotify->verifyReturn();

        if($verify_result) {//验证成功
    

            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号
            $trade_no = $_GET['trade_no'];
            //交易状态
            $trade_status = $_GET['trade_status'];

            $info         = '';

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
        
            }
           else {
                    $info   = "trade_status=".$_GET['trade_status'];
            }
        
            
            $model              = Order::find($out_trade_no);
            $model->pay_tag     = 1;
            $model->save();
        
            $info               .=  '<i class="fa fa-check"></i>验证成功';
            $view               = view('mobile.info');
            $view->info         = $info;
            $view->breadcrumb   = $this->base->get_breadcrumb(trans('front.pay_result'));
            $view->back_url     = url('/');
            $view->title        = trans('front.title');
            $view->description  = trans('front.description');
            $view->keywords     = trans('front.keywords');

            return $view;
   
        }
        else {
    
             $view               = view('mobile.info');
             $view->info         = '<i class="fa fa-times"></i>验证失败';
             $view->breadcrumb   = $this->base->get_breadcrumb(trans('front.pay_result'));
             $view->back_url     = url('/');
             $view->title        = trans('front.title');
             $view->description  = trans('front.description');
             $view->keywords     = trans('front.keywords');

             return $view;
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  支付宝同步页面
    |
    |-------------------------------------------------------------------------------
    */
    public function notify_url(){

        //计算得出通知验证结果
        $alipay_config                  = $this->get_alipay_wap_config();
        $alipayNotify                   = new AlipayNotify($alipay_config);
        $verify_result                  = $alipayNotify->verifyNotify();

        if($verify_result) {

                $out_trade_no = $_POST['out_trade_no'];

                //支付宝交易号
                $trade_no = $_POST['trade_no'];
                //交易状态
                $trade_status = $_POST['trade_status'];

            if($_POST['trade_status'] == 'TRADE_FINISHED') {
       
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
        
            }
            
            echo "success";     //请不要修改或删除
    
        }
        else {
            //验证失败
            echo "fail";

        }
    }
}