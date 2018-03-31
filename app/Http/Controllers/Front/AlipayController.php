<?php
/*
|-------------------------------------------------------------------------------
|
|  支付宝支付插件
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
use Phpstore\Alipay\AlipaySubmit;
use Phpstore\Alipay\AlipayNotify;
use Phpstore\Alipay\Common as AlipayCommon;
use Omnipay;


class AlipayController extends BaseController
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
    |  获取alipay的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function get_alipay_config(){


        $row            = Payment::where('pay_code','alipay')->first();
        $alipay_config  = [];

        if(!empty($row)){


                $alipay_config['partner']       = $row->pid;

                //收款支付宝账号，一般情况下收款账号就是签约账号
                $alipay_config['seller_email']  = $row->account;

                //安全检验码，以数字和字母组成的32位字符
                $alipay_config['key']           = $row->pkey;


                //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


                //签名方式 不需修改
                $alipay_config['sign_type']    = strtoupper('MD5');

                //字符编码格式 目前支持 gbk 或 utf-8
                $alipay_config['input_charset']= strtolower('utf-8');

                //ca证书路径地址，用于curl中ssl校验
                //请保证cacert.pem文件在当前文件夹目录中
                $alipay_config['cacert']    = public_path().'/alipay/cacert.pem';

                //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
                $alipay_config['transport']    = 'http'; 
        }

        return $alipay_config;
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    |  处理post请求
    |
    |-------------------------------------------------------------------------------
    */ 
    public function alipayapi(){

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = url("notify_url.php");
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = url("return_url.php");
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
        $out_trade_no = Request::input('WIDout_trade_no');
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = Request::input('WIDsubject');
        //必填

        //付款金额
        $total_fee = Request::input('WIDtotal_fee');
        //必填

        //订单描述

        $body = Request::input('WIDbody');
        //商品展示地址
        $show_url = Request::input('WIDshow_url');
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = Request::getClientIp();
        //非局域网的外网IP地址，如：221.0.0.1

        //支付宝配置
        $alipay_config   = $this->get_alipay_config();


        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter      = array(
            "service"               => "create_direct_pay_by_user",
            "partner"               => trim($alipay_config['partner']),
            "seller_email"          => trim($alipay_config['seller_email']),
            "payment_type"          => $payment_type,
            "notify_url"            => $notify_url,
            "return_url"            => $return_url,
            "out_trade_no"          => $out_trade_no,
            "subject"               => $subject,
            "total_fee"             => $total_fee,
            "body"                  => $body,
            "show_url"              => $show_url,
            "anti_phishing_key"     => $anti_phishing_key,
            "exter_invoke_ip"       => $exter_invoke_ip,
            "_input_charset"        => trim(strtolower($alipay_config['input_charset']))
        );

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  处理支付返回结果函数 get请求
    |
    |-------------------------------------------------------------------------------
    */
    public function return_url(){


         //计算得出通知验证结果
         $alipay_config            = $this->get_alipay_config();
         $alipayNotify             = new AlipayNotify($alipay_config);
         $verify_result            = $alipayNotify->verifyReturn();

        if($verify_result) {

          

            //商户订单号
            $out_trade_no       = $_GET['out_trade_no'];
            //支付宝交易号
            $trade_no           = $_GET['trade_no'];

            //交易状态
            $trade_status       = $_GET['trade_status'];

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $info           = '';
            }
            else {
                    $info       =  "trade_status=".$_GET['trade_status'];
            }
            
            $model              = Order::where('order_sn',$out_trade_no)->first();
            $model->pay_status  = 1;
            $model->save();

            //如果有子订单 也修改子订单的支付状态
            $model->childPaySuccess();
        
            $info               .=  '<i class="fa fa-check"></i>验证成功';
            $view               = $this->view('info');
            $view->info         = $info;
            $view->breadcrumb   = $this->base->get_breadcrumb(trans('front.pay_result'));
            $view->back_url     = url('/');

            return $view;

            
        }
        else{
                //验证失败
                //如要调试，请看alipay_notify.php页面的verifyReturn函数
                $info               =  '<i class="fa fa-times"></i> 验证失败';
                $view               = $this->view('info');
                $view->info         = $info;
                $view->breadcrumb   = $this->base->get_breadcrumb(trans('front.pay_result'));
                $view->back_url     = url('/');
                return $view;
        }


            
    } 


    /*
    |-------------------------------------------------------------------------------
    |
    |  服务器同步
    |
    |-------------------------------------------------------------------------------
    */
    public function notify_url(){

        //计算得出通知验证结果
        $alipay_config              = $this->get_alipay_config();

        $alipayNotify               = new AlipayNotify($alipay_config);

        $verify_result              = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
    
        //商户订单号
        $out_trade_no               = $_POST['out_trade_no'];
        //支付宝交易号
        $trade_no                   = $_POST['trade_no'];

        //交易状态
        $trade_status               = $_POST['trade_status'];


        if($_POST['trade_status'] == 'TRADE_FINISHED') {
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
            //如果有做过处理，不执行商户的业务程序
                
            //注意：
            //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
        elseif ($_POST['trade_status'] == 'TRADE_SUCCESS') {
        //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
            //如果有做过处理，不执行商户的业务程序
                
        //注意：
        //付款完成后，支付宝系统发送该交易状态通知

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }

        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
        echo "success";     //请不要修改或删除
    
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | php判断浏览器是移动版本
    |
    |-------------------------------------------------------------------------------
    */
    public function is_mobile(){

        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";

        if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap')){

            return true;

        }

        return false;
    }



}
