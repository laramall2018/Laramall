<?php namespace App\Http\Controllers\Admin;


use App\Models\Theme;
use Artisan;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\ImageLib;
use Phpstore\Template\CommonHelper;
use Request;
use Validator;


/*
|----------------------------------------------------------------------------------------
|                                                                                        
| 路由类型         路由                        对应处理函数             路由名称              
|----------------------------------------------------------------------------------------
| route get      admin/template              function index()       admin.template.index   
| route post     admin/template              function store()       admin.template.store
|----------------------------------------------------------------------------------------
*/
class TemplateController extends BaseController{



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
        $this->page                 = 'template';
        $this->tag                  = 'admin.template.index';
        
        //定义相关的链接
        $this->list_url             = 'admin/template';
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

        $view                           = $this->view('template.crud');
        $view->page                     = $this->page;
        $view->tag                      = $this->tag;
        $current_url                    = HTML::link($this->list_url,trans('admin.template_config'));
        $view->path_url                 = $this->get_path_url($current_url);
        $view->action_name              = trans('admin.template_config');
        $view->row                      = $this->help->get_config_data();
        $view->pc_theme_list            = Theme::getList('pc');
        $view->mobile_theme_list        = Theme::getList('mobile');
    
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

             if(in_array($item,['tp_thumb'])){

                 $this->upload_img($item);
             }
             else{

                 $this->upload_config($item,Request::input($item));
             }
         }

         return redirect($this->list_url);
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

        $row                = DB::table('template_config')->where('code',$item)->first();

        if(empty($row)){

            DB::table('template_config')->insert(['code'=>$item,'value'=>$value,'add_time'=>time()]);
        }
        else{

            DB::table('template_config')
                ->where('id',$row->id)
                ->update(['value'=>$value,'add_time'=>time()]);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取系统主题列表
    |
    |-------------------------------------------------------------------------------
    */
    public function getThemeJson(){

        Artisan::call('cache:clear');
        $row            = Theme::getJSON('pc');
        return $this->toJSON(['tag'=>'success','info'=>'ok','themes'=>$row]);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加主题
    |
    |-------------------------------------------------------------------------------
    */
    public function addTheme(){

        $rules              = [
                                'name'=>'required|unique:themes,name',
                                'type'=>'required'
                              ];

        $validator          = Validator::make(request()->all(),$rules);
        $row                = Theme::getJSON('pc');
        if($validator->fails()){

            return $this->toJSON(['tag'=>'error','info'=>'输入不完整或者重复','themes'=>$row]);
        }

        Theme::create([
                'name'          =>request()->name,
                'type'          =>request()->type,
                'is_checked'    => 0,
        ]);

        //清除缓存
        Artisan::call('cache:clear');
        return $this->getThemeJson();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除主题
    |
    |-------------------------------------------------------------------------------
    */
    public function deleteTheme(){

        $id         = request()->id;
        $model      = Theme::find($id);
        $row        = Theme::getJSON('pc');
        if(empty($model)){

            return $this->toJSON(['tag'=>'error','info'=>'删除异常','themes'=>$row]);
        }

        if($model->is_checked == 1){

            return $this->toJSON(['tag'=>'error','info'=>'当前正在使用的模板，禁止删除','themes'=>$row]);
        }

        $model->delete();
        Artisan::call('cache:clear');
        return $this->getThemeJson();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置为当前模板
    |
    |-------------------------------------------------------------------------------
    */
    public function setDefault(){

        $id         = request()->id;
        $model      = Theme::find($id);
        $model->checked();
        return $this->getThemeJson();
    }





}