<?php namespace App\Http\Controllers\Admin;

use File;
use HTML;
use Image;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Goods\CommonHelper;
use Request;
use Validator;


/*
|----------------------------------------------------------------------------------------
|                                                                                        
| 路由类型         路由                        对应处理函数             路由名称              
|
| route get      admin/uploadify             function index()       admin.uploadify.index   
|
|---------------------------------------------------------------------------------------
*/
class UploadifyController extends BaseController{



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
    public $form;
    public $crud;
    public $row;
    public $form_to_model;

    function __construct(){

    	parent::__construct();
        $this->page                 = 'common';
        $this->tag                  = 'admin.uploadify.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/goods';
        $this->edit_url             = 'admin/goods/edit';
        $this->add_url              = 'admin/goods/create';
        $this->update_url           = 'admin/goods/update';
        $this->del_url              = 'admin/goods/del/';
        $this->batch_url            = 'admin/goods/batch';
        $this->preview_url          = 'goods/preview/';
        $this->ajax_url             = 'admin/goods/grid';
        $this->swf_url              = 'static/uploadify/uploadify.swf';
        $this->uploadify_url        = 'static/uploadify/uploadify2.php';
        $this->uploadify_del_url    = 'admin/uploadify/del';
        $this->timestamp            = time();



        //初始化帮助对象
        $this->help                 = new CommonHelper();

        //其他设置
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',HTML::link($this->list_url,Lang::get('back_goods_list')));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

    	
    	

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示图片批量上传处理界面
    |  路由：admin/uploadify
    |  路由名称：admin.uploadify.index
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        $view                       = $this->view('uploadify');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,Lang::get('uploadify'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('uploadify');

        $view->swf_url              = url($this->swf_url);
        $view->uploadify_url        = url($this->uploadify_url);
        $view->uploadify_del_url    = url($this->uploadify_del_url);

       

        //返回视图模板
        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示图片批量上传处理界面
    |  路由：admin/uploadify/upload
    |  路由名称：admin.uploadify.upload
    |
    |-------------------------------------------------------------------------------
    */
    public function upload(){

        //设置放置图片的目录 目录为根据月份动态创建
        $dir = date('Ym');
        $targetFolder = '/images/'.$dir; // Relative to the root
        $targetPath = public_path() . $targetFolder;
        
        //如果目录不存在 则动态创建 并设置权限为777
        if(!is_dir($targetPath)){

            @mkdir($targetPath, 0777);
        }

        //如果目录不存在 则动态创建 并设置权限为777
        if(!is_dir($targetPath.'/goods_thumb')){

            @mkdir($targetPath.'/goods_thumb', 0777);
        }

        //如果目录不存在 则动态创建 并设置权限为777
        if(!is_dir($targetPath.'/goods_img')){

            @mkdir($targetPath.'/goods_img', 0777);
        }

        //如果目录不存在 则动态创建 并设置权限为777
        if(!is_dir($targetPath.'/source_img')){

            @mkdir($targetPath.'/source_img', 0777);
        }

        @chmod($targetPath.'/goods_thumb',0777);
        @chmod($targetPath.'/goods_img',0777);
        @chmod($targetPath.'/source_img',0777);
        

        $verifyToken = md5('unique_salt' . Input::get('timestamp'));

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {


            $tempFile = $_FILES['Filedata']['tmp_name'];
            
            
            $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
    
            if (in_array($fileParts['extension'],$fileTypes)) {
                
                $file = Input::file('Filedata');

                //重新命名文件名称
                $img_name = date('Ymd').'_'.uniqid();
                //$ext   = $fileParts['extension'];

                $base_name = $img_name;
                
                $ext   = $file->getClientOriginalExtension();
                $img_name  = $img_name .'.'.$ext;

                $file->move($targetPath.'/source_img', $img_name);

                //获取服务器上图片的完成路径
                $upload_image = $targetPath .'/source_img/'.$img_name;

                //生成缩略图

                $thumb_img = 'goods_thumb_'.$base_name;
                $thumb_img = $thumb_img.'.'.$ext;

                $goods_img = 'goods_img_'.$base_name;
                $goods_img = $goods_img.'.'.$ext;

                //生成缩略图
         
                $img = Image::make($upload_image)->resize(200, 200);
                $img->save($targetPath.'/goods_thumb/'.$thumb_img, 90);

                //生成详情页图片
                $img = Image::make($upload_image)->resize(400,400);
                $img->save($targetPath.'/goods_img/'.$goods_img , 90);
               
                
                $row = [];

                $row['goods_img']   = 'images/'.$dir.'/goods_img/'.$goods_img;
                $row['goods_thumb'] = 'images/'.$dir.'/goods_thumb/'.$thumb_img;
                $row['upload_img']  = 'images/'.$dir.'/source_img/'.$img_name;

                echo  json_encode($row);

                
            }
            else {

                echo '图片格式不对';
            }
        }
    }

}