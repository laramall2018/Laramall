<?php namespace App\Http\Controllers\Admin;


use DB;
use File;
use HTML;
use Input;
use Phpstore\Base\Sysinfo;
use Phpstore\Config\CommonHelper;
use Phpstore\Crud\ImageLib;
use Request;
use Validator;


/*
|----------------------------------------------------------------------------------------
|                                                                                        
| 路由类型         路由                        对应处理函数             路由名称              
|----------------------------------------------------------------------------------------
| route get      admin/config                function index()       admin.config.index   
| route post     admin/config                function store()       admin.config.store
|----------------------------------------------------------------------------------------
*/
class ConfigController extends BaseController{



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
    public $list_url;
    

    function __construct(){

        parent::__construct();
        $this->page                 = 'config';
        $this->tag                  = 'admin.config.index';
        
        //定义相关的链接
        $this->list_url             = 'admin/config';
        //初始化帮助对象
        $this->help                 = new CommonHelper();

        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有商品列表信息
    |  路由：admin/config
    |  路由名称：admin.config.index
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                           = $this->view('config.crud');
        $view->page                     = $this->page;
        $view->tag                      = $this->tag;
        $current_url                    = HTML::link($this->list_url,trans('common.add_config'));
        $view->path_url                 = $this->get_path_url($current_url);
        $view->action_name              = trans('common.add_config');
        $view->row                      = $this->help->get_config_data();
        $view->article_cat_id           = $this->help->get_article_cat_id();
       
        
        return $view;
    }

 
    /**
     *  存储系统配置信息到数据库
     *  路由:admin/config
     *  类型:post
     *  路由名称:admin.config.store
     *
     */
     public function store(){

         $field                         = $this->help->field();
         foreach($field as $item){

             if(in_array($item,['shop_logo','watermark','goods_default_img','wap_logo'])){

                 $this->upload_img($item);
             }
             else{

                 $this->upload_config($item,Request::input($item));
             }
         }

         return redirect('admin/config');
     }

    /**
     * 上传图片
     *
     */
    public function upload_img($item){

        if(Request::hasFile($item)) {

            $img = new ImageLib();
            $img->set_value('dir', 'config');
            $img->set_value('file_name', $item);
            $upload_img = $img->upload_image();
            $this->upload_config($item, $upload_img);
        }

    }


    /**
     *
     * 上传配置文件
     *
     */
    public function upload_config($item,$value){

        $row                = DB::table('sys_config')->where('code',$item)->first();

        if(empty($row)){

            DB::table('sys_config')->insert(['code'=>$item,'value'=>$value]);
        }
        else{

            DB::table('sys_config')
                ->where('id',$row->id)
                ->update(['value'=>$value]);
        }
    }


}