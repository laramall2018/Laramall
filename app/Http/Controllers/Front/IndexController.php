<?php
/**
 * Created by PhpStorm.
 * User: swh
 * Date: 15/12/29
 * Time: 上午9:52
 */

namespace App\Http\Controllers\Front;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Phpstore\Base\Common;
use Request;
use Config,DB;
use App\Models\Cat;
use App\Models\Category;
use App\Models\Goods;
use QrCode;
use Artisan;
use Route;
use Storage;
use File;
use App\Models\Slider;
use App\Models\Image;
use LaraStore\Crud\Common\{
    Form\CreateForm,
    Form\EditForm
};

class IndexController extends BaseController
{


    public $common;
    public $view;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
        $this->common          = new Common();
           
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 首页显示控制器
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){
        
        $this->view                       = $this->view('index');
        $this->view->new_goods            = Goods::recommend('new');
        $this->view->hot_goods            = Goods::recommend('hot');
        $this->view->best_goods           = Goods::recommend('best');
        $this->view->promote_goods        = Goods::recommend('promote');
        $this->view->slider               = Slider::getList();
        $this->viewImageInit();
        return $this->view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取首页商品个数配置
    |
    |-------------------------------------------------------------------------------
    */
    public function get_tp_goods_number($code){

        $num    = 8;
        if($res = $this->common->get_template_config($code)){

            return $res;
        }


        return $num;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 生成二维码
    |
    |-------------------------------------------------------------------------------
    */
    public function qrcode(){
       $url        = 'http://192.168.1.6/phpstore-b2c/public';

       $qrcode     = QrCode::format('png')
                     ->size(300)
                     ->color(0,204,204)
                     ->backgroundColor(255,255,255)
                     ->merge(url('front/images/qrcode-logo.png'), .5, true)
                     ->generate($url);
       $data       = base64_encode($qrcode);

        return  '<img src="data:image/png;base64,'.$data.'">';

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 图片批量赋值
    |
    |-------------------------------------------------------------------------------
    */
    public function viewImageInit(){

        foreach(\App\Models\Image::get() as $item){
            $img_tag                          = $item->img_tag;
            $this->view->$img_tag             = Image::getValue($img_tag);
        }

        return $this->view;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 测试 测试
    |
    |-------------------------------------------------------------------------------
    */
    public function test(){

        $form       = new EditForm(Goods::first());
        return $form->put('url',url('admin/goods'))->make();

    }

}