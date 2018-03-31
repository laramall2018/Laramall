<?php namespace App\Http\Controllers\Admin;

use App\Models\Goods;
use DB;
use File;
use HTML;
use Image;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Cycle\CommonHelper;
use Phpstore\Grid\Common;
use Request;
use Session;
use Validator;


/*
|----------------------------------------------------------------------------------------
|
| 路由类型         路由                        对应处理函数             路由名称
|
| route get      admin/cycle                 function index()       admin.goods.index
| route get      admin/goods/create          function create()      admin.goods.create
| route post     admin/goods                 function store()       admin.goods.store
| route get      admin/goods/{id}/edit       function edit()        admin.goods.edit
| route put      admin/goods/{id}            function update()      admin.goods.update
|---------------------------------------------------------------------------------------
| route get      admin/goods/del/{id}        function destroy()     admin.goods.destroy
| route post     admin/goods/batch           function batch()       admin.goods.batch
| route post     admin/goods/grid            function grid()        admin.goods.grid
|---------------------------------------------------------------------------------------
*/
class CycleController extends BaseController{



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
        $this->page                 = 'goods';
        $this->tag                  = 'admin.cycle.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/cycle';
        $this->edit_url             = 'admin/cycle/edit';
        $this->add_url              = 'admin/cycle/create';
        $this->update_url           = 'admin/cycle/update';
        $this->del_url              = 'admin/cycle/del/';
        $this->batch_url            = 'admin/cycle/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/cycle/grid';
        



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
    |  路由：admin/goods
    |  路由名称：admin.goods.index
    |
    |-------------------------------------------------------------------------------
    |
    |  列表页使用通用模板  crud/gird.blade.php
    |  grid模板页面需要的dom元素包括
    |  1.page 和 tag 标签 用于指定左侧菜单的当前一级菜单和当前二级菜单
    |  2.path_url  显示面包屑导航菜单
    |  3.action_name  显示当前操作名称
    |  4.add_btn    显示添加新商品的按钮
    |  5.系统搜索表单  用crud的form类生成
    |  6.grid页面的ajax函数为  ps.ui.grid(ajax_url,_token,json)
    |    这里指定ajax_url 同时生成json格式的搜索条件参数
    |  7 生成列表页的所有记录显示table  同时包含一个portlet box  可以自定义颜色
    |  8 把初始化好的grid对象实例赋值给模板
    |  9 模板 通过 $grid->portlet() 获取带style的响应式表格
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){



        $view                       = $this->view('crud.cycle');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,Lang::get('goods_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('goods_list');

        $view->grid                 = Goods::where('is_delete',1)->paginate(20);
        
        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
        //批量删除按钮
        $view->batch_btn            = Common::batch_all_btn_string('批量还原','批量删除');

        //返回视图模板
        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  从数据库中删除商品
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model                  = Goods::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        //删除商品和商品相册图片
        $model->ImageDelete();
        //删除商品相册数据库记录
        $model->gallery()->delete();

        if($model->delete()){

            return redirect($this->list_url);
        }
        
        return $this->sysinfo->fails();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  从回收站中还原商品到商品列表中
    |
    |-------------------------------------------------------------------------------
    */
    public function softdel($id){

        $model                  = Goods::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        $model->is_delete       = 0;

        if($model->save()){

            return redirect($this->list_url);
        }

        return $this->sysinfo->fails();


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 post
    |   对应路由  admin/cycle/batch
    |   路由名称为 admin.cycle.batch
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $del_type           = Request::input('del_type');
        $ids                = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->batchEmpty();
        }

        if(in_array($del_type,['softdel','delete'])){

            $func           = $del_type.'Action';

            $this->$func($ids); 

        }

        return redirect($this->list_url);   
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  批量删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function deleteAction($ids){

        foreach($ids as $id){

             $model             = Goods::find($id);

             if($model){

                //删除商品图片
                $model->ImageDelete();
                //删除商品相册记录
                $model->gallery()->delete();
                //删除模型本身
                $model->delete();
             }
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  批量回还原操作
    |
    |-------------------------------------------------------------------------------
    */
    public function softdelAction($ids){

        foreach($ids as $id){

            $model                      = Goods::find($id);

            if($model){

                $model->is_delete       = 0;
                $model->save();
            }
        }
    }
    
}
