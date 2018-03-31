<?php namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use File;
use HTML;
use Input;
use Phpstore\Attribute\CommonHelper;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Redirect;
use Request;
use Validator;


/*
|----------------------------------------------------------------------------------------
|
| 路由类型         路由                        对应处理函数             路由名称
|
| route get      admin/attribute              function index()       admin.attribute.index
| route get      admin/attribute/create       function create()      admin.attribute.create
| route post     admin/attribute              function store()       admin.attribute.store
| route get      admin/attribute/{id}/edit    function edit()        admin.attribute.edit
| route put      admin/attribute/{id}         function update()      admin.attribute.update
|---------------------------------------------------------------------------------------
| route get      admin/attribute/del/{id}     function destroy()     admin.attribute.destroy
| route post     admin/attribute/batch        function batch()       admin.attribute.batch
| route post     admin/attribute/grid         function grid()        admin.attribute.grid
|---------------------------------------------------------------------------------------
*/
class AttributeController extends BaseController{



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
        $this->tag                  = 'admin.attribute.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        //定义商品的常用操作链接
        $this->list_url             = 'admin/attribute';
        $this->edit_url             = 'admin/attribute/edit';
        $this->add_url              = 'admin/attribute/create';
        $this->update_url           = 'admin/attribute/update';
        $this->del_url              = 'admin/attribute/del/';
        $this->batch_url            = 'admin/attribute/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/attribute/grid';


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
    |  显示所有商品列表信息
    |  路由：admin/attribute
    |  路由名称：admin.attribute.index
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

        $view                       = $this->view('crud.grid');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,Lang::get('attr_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('attr_list');


        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,Lang::get('add_attr'));

        //生成搜索表单
        $this->crud->put('row',$this->help->searchData());
        $this->crud->put('url',url($this->list_url));
        $view->search               = $this->crud->render();

        //生成ps.ui.grid(ajax_url,_token,json)
        //指定ajax_url, json格式的搜索参数
        $view->ajax_url             = url($this->ajax_url);
        $view->searchInfo           = $this->help->searchInfo();

        //设置grid
        $tableData                  = $this->help->tableDataInit();
        $grid                       = new Grid($tableData);


        //指定portlet的颜色和配置文件
        //生成带配置文件的protletbox 响应式table
        //$grid->portlet()
        $grid->put('color','blue');
        $grid->put('action_name',Lang::get('attr_list'));
        $view->grid                 = $grid;

        //设置批量删除操作的batch_url
        $view->batch_url            = $this->batch_url;
        //批量删除按钮
        $view->batch_btn            = Common::batch_del_btn();

        //返回视图模板
        return $view;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/goods/grid
    |   路由名称  admin.goods.grid
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){

        $info           = Request::input('info');
        $info           = json_decode($info);
        $tableData      = $this->help->getTableData($info);
        $grid           = new Grid($tableData);

        echo $grid->render();

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作
    |   调用crud通用模板 crud/crud.blade.php
    |   对应路由  admin/goods/create
    |   路由名称  admin.goods.create
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

        $view               = $this->view('crud_add');
        $view->page         = $this->page;
        $view->tag          = 'admin.attribute.index';
        $current_url        = HTML::link($this->add_url,Lang::get('add_attr'));
        $view->path_url     = $this->get_path_url($current_url);

        $view->action_name  = Lang::get('add_attr');

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->FormData());
        $this->crud->put('url',url($this->list_url));
        $view->form         = $this->crud->render();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 post
    |   路由名称：admin.attribute.store
    |   对应路由  admin/attribute
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

         $rules         = [

                                'attr_name'=>'required',
                                'type_id'  =>'required|min:1'


                          ];

         $validator     = Validator::make(Request::all(),$rules);

         if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
         }

         $model             = new Attribute();
         $this->form_to_model->put('model',$model);
         $this->form_to_model->put('row',$this->help->FormData());

         if($this->form_to_model->insert()){

              return redirect($this->list_url);
         }
         else{

            return $this->sysinfo->fails();
         }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 get
    |   对应路由  admin/{id}/edit
    |   路由名称：admin.goods.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){

        $model                     = Attribute::find($id);

         if(empty($model)){

            return $this->sysinfo->forbidden();
         }

        $view                       = $this->view('crud_add');
        $view->action_name          = Lang::get('edit_attr');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url.'/'.$id,Lang::get('edit_attr'));
        $view->path_url             = $this->get_path_url($current_url);

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->EditData($model));
        $this->crud->put('url',url($this->list_url.'/'.$id));
        $view->form                 = $this->crud->form();

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行更新商品操作 put 这里需要伪装路由为 put
    |   路由名称：admin.attribute.update
    |   对应路由  admin/attribute/{id}
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        $id             = Request::input('id');

        $model          = Attribute::find($id);

        if(empty($model)){

           return $this->sysinfo->forbidden();
        }

        $rules          = [
                                'attr_name'=>'required',

                          ];

        $validator      = Validator::make(Input::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData($model));



        if($this->form_to_model->insert()){

           return redirect($this->list_url);
        }
        else{

           return $this->sysinfo->fails();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行删除商品操作 delete
    |   对应路由  admin/attribute/{id}
    |   路由名称  admin.attribute.destroy
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model          = Attribute::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }



        if($model->delete()){

            return redirect($this->list_url);
        }

        return $this->sysinfo->fails();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 post
    |   对应路由  admin/attribute/batch
    |   路由名称为 admin.attribute.batch
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $del_type           = Request::input('del_type');
        $ids                = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->batchEmpty();
        }

        foreach($ids  as $id){

           $model       = Attribute::find($id);
           if($model){

             $model->delete();
           }
        }

        return redirect($this->list_url);
    }

}
