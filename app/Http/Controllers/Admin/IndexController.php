<?php namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use HTML;
use Phpstore\Base\Base;
use Request;

class IndexController extends BaseController{



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

    function __construct(){

    	parent::__construct();



    }


    /*
    |-------------------------------------------------------------------------------
    |
    | index 显示
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $base                       = new Base();

    	$view 						= $this->view('index');
    	$view->page  				= 'index';
    	$view->tag 					= 'admin.system.index';
        $view->action_name          = '系统信息';
        $view->path_url             = $this->get_path_url(HTML::link('admin/index','后台首页'));
        $view->system_info          = $base->get_system_info();
        $view->links                = $this->create_common_link_list();

    	return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | redis安装说明
    |
    |-------------------------------------------------------------------------------
    */
    public function redis(){

        $view               = $this->view('redis');
        $view->page         = 'dev';
        $view->tag          = 'redis';
        $view->path_url     = $this->get_path_url(HTML::link('/redis','redis配置安装'));


        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | carousel滚动组件
    |
    |-------------------------------------------------------------------------------
    */
    public function carousel(){

        $view               = $this->view('carousel');
        $view->page         = 'dev';
        $view->tag          = 'carousel';
        $view->path_url     = $this->get_path_url(HTML::link('/carousel','滚动组件'));

        return $view;


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  mwui表单显示样式
    |
    |-------------------------------------------------------------------------------
    */
    public function mwui(){

        $view               = $this->view('mwui');
        $view->page         = 'dev';
        $view->tag          = 'mwui';
        $view->path_url     = $this->get_path_url(HTML::link('/mwui','前端表单样式'));

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  未授权或者未登录页面提示信息
    |
    |-------------------------------------------------------------------------------
    */
    public function sysinfo(){

        //如果未授权访问该页面 则直接退出登录
        $view               = $this->view('sysinfo');

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  省会城市地区地址三级ajax联查
    |
    |-------------------------------------------------------------------------------
    */
    public function pcd(){

        $info           = Request::input('info');
        $info           = json_decode($info);

        $region_id      = intval($info->region_id);
        $region_type    = intval($info->region_type);
        $tag            = $info->tag;

        $res            = DB::table('region')
                             ->where('parent_id',$region_id)
                             ->where('region_type',$region_type)
                             ->get();

        return $this->toJSON(['tag'=>$tag,'data'=>$res]);
        exit;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成网站常用的操作链接
    |
    |-------------------------------------------------------------------------------
    */
    public function create_common_link_list(){

        $button_list  = [

            ['url'=>url('admin/goods'),'name'=>trans('admin.goods_list'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/goods/create'),'name'=>trans('admin.add_goods'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/category/create'),'name'=>trans('admin.add_category'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/brand/create'),'name'=>trans('admin.add_brand'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/attribute/create'),'name'=>trans('admin.add_attribute'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/field/create'),'name'=>trans('admin.add_field'),'cls'=>'btn btn-success outline'],

            ['url'=>url('admin/excel'),'name'=>trans('admin.excel'),'cls'=>'btn btn-primary outline'],
            ['url'=>url('admin/goods/image'),'name'=>trans('admin.image_batch'),'cls'=>'btn btn-success outline'],

            ['url'=>url('admin/order'),'name'=>trans('admin.order_list'),'cls'=>'btn btn-info outline'],
            ['url'=>url('admin/user'),'name'=>trans('admin.user_list'),'cls'=>'btn btn-warning outline'],

            ['url'=>url('admin/article'),'name'=>trans('admin.article_list'),'cls'=>'btn btn-danger outline'],
            ['url'=>url('admin/template'),'name'=>trans('admin.template'),'cls'=>'btn btn-primary outline'],

            ['url'=>url('admin/config'),'name'=>trans('admin.config'),'cls'=>'btn btn-primary outline'],
            ['url'=>url('admin/slider'),'name'=>trans('admin.slider'),'cls'=>'btn btn-info outline'],

            ['url'=>url('admin/catad'),'name'=>trans('admin.cat_ad'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/nav'),'name'=>trans('admin.nav'),'cls'=>'btn btn-warning outline'],
            ['url'=>url('admin/color'),'name'=>trans('admin.color'),'cls'=>'btn btn-danger outline'],

            ['url'=>url('admin/payment'),'name'=>trans('admin.payment'),'cls'=>'btn btn-danger outline'],
            ['url'=>url('admin/shipping'),'name'=>trans('admin.shipping'),'cls'=>'btn btn-danger outline'],

            ['url'=>url('admin/link'),'name'=>trans('admin.link'),'cls'=>'btn btn-success outline'],

            ['url'=>url('admin/image'),'name'=>trans('admin.image'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/cycle'),'name'=>trans('admin.cycle'),'cls'=>'btn btn-success outline'],

            ['url'=>url('admin/user_rank'),'name'=>trans('admin.user_rank'),'cls'=>'btn btn-success outline'],

            ['url'=>url('admin/role'),'name'=>trans('admin.role'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/administrator'),'name'=>trans('admin.administrator'),'cls'=>'btn btn-success outline'],
            ['url'=>url('admin/log'),'name'=>trans('admin.log'),'cls'=>'btn btn-success outline'],

        ];


        $str          = '';

        foreach($button_list as $item){

            $str        .= '<div class="btn-div">'
                        .'<a href="'.$item['url'].'" class="'.$item['cls'].'">'
                        .'<span class="glyphicon glyphicon-cog"></span>'
                        .$item['name']
                        .'</a>'
                        .'</div>';
                      
        }
           

        return $str;
    }



}
