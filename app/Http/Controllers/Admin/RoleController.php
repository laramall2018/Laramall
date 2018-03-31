<?php namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\RolePrivi;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Phpstore\Role\CommonHelper;
use Request;
use Route;
use Validator;

/*
|-------------------------------------------------------------------------------
|
|  路由url                   路由命名                       对应函数          类型
|-------------------------------------------------------------------------------
|  admin/role               admin.role.index              index()          get
|  admin/role/create        admin.role.create             create()         get
|  admin/role               admin.role.store              store()          post
|  admin/role/{id}/edit     admin.role.edit               edit()           get
|  admin/role/{id}          admin.role.update             update()         put
|-------------------------------------------------------------------------------
|  admin/role/del/{id}      admin.role.delete             delete()         get
|-------------------------------------------------------------------------------
*/
class RoleController extends BaseController{



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
    public $list_url;
    public $add_url;
    public $edit_url;
    public $update_url;
    public $del_url;


    function __construct(){

    	parent::__construct();
        $this->page                 = 'privi';
        $this->tag                  = 'admin.role.index';

        //初始化
        $this->list_url             = 'admin/role';
        $this->add_url              = 'admin/role/create';
        $this->update_url           = 'admin/role/update';
        $this->edit_url             = 'admin/role/edit/';
        $this->del_url              = 'admin/role/del/';
        $this->ajax_url             = 'admin/role/grid';
        $this->batch_url            = 'admin/role/batch';

        $this->crud                 = new Crud();
        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url('admin/role'));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

        //初始化帮助对象
        $this->help                 = new CommonHelper();

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  显示系统所有角色信息
    |  路由：admin/role
    |  路由名称：admin.role.index
    |  路由类型: get
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
        $current_url                = HTML::link($this->list_url,Lang::get('role_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('role_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,Lang::get('add_role'));

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
        $grid->put('action_name',Lang::get('role_list'));
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
    |  添加角色
    |  路由链接 : admin/role/create
    |  路由类型 : get
    |  路由名称 : admin.role.create
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){

        $view                      = $this->View('crud_add');
        $view->page                = $this->page;
        $view->tag                 = $this->tag;
        $view->action_name         = '添加角色';
        $view->path_url            = $this->get_path_url(HTML::link($this->add_url,'添加角色'));

        $crud                      = new Crud;
        $crud->put('row',$this->FormData());
        $crud->put('url',url($this->list_url));

        $view->form                = $crud->form();

        return $view; 
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  编辑角色
    |  路由链接 : admin/role/{id}/edit
    |  路由类型 : get
    |  路由名称 : admin.role.edit
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($role_id){

        $role                      = Role::find($role_id);

        if(empty($role)){

            return $this->sysinfo->forbidden();
        }

        $view                       = $this->View('crud_add');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->action_name          = Lang::get('edit_role');
        $view->path_url             = $this->get_path_url(HTML::link('admin/role/'.$role_id.'/edit',Lang::get('edit_role')));

        $crud                       = new Crud();
        $crud->put('row',$this->EditData($role));
        $crud->put('url',url('admin/role/'.$role_id));

        $view->form                 = $crud->form();

        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  存储表单信息到数据表
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $rules          = ['role_name'=>'required|unique:role,role_name'];

        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        $model              = new Role();

        $model->role_name   = Request::input('role_name');
        $model->sort_order  = Request::input('sort_order');

        if($model->save()){

            $this->insert_role_privi($model->id,Request::input('ids'));

            return redirect('admin/role');
        }
        else{

            return $this->sysinfo->fails();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  更新角色  update
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

         $role_id                = Request::input('role_id');
         $role                   = Role::find($role_id);

         if(empty($role)){

            return $this->sysinfo->forbidden();
         }

         $role->role_name        = Request::input('role_name');
         $role->sort_order       = Request::input('sort_order');

         if($role->save()){

            $this->insert_role_privi($role_id,Request::input('ids'));

            return redirect('admin/role');
         }
         else{

            return $this->sysinfo->fails();
         }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除角色
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($role_id){

        $role                   = Role::find($role_id);

        if(empty($role)){

            return $this->sysinfo->forbidden();
        }

        $role->delete();

        if($row = RolePrivi::where('role_id',$role_id)->get()){

             RolePrivi::where('role_id',$role_id)->delete();
        }

        return redirect('admin/role');
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  批量删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $ids            = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->forbidden();
        }

        foreach($ids as $id){

            $model      = Role::find($id);

            if($model){

                $model->delete();
            }

            if($row = RolePrivi::where('role_id',$id)->get()){

                RolePrivi::where('role_id',$id)->delete();
            }
        }


        return redirect($this->list_url);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/role/grid
    |   路由名称  admin.role.grid
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
    |  把数据插入到角色权限表中
    |
    |-------------------------------------------------------------------------------
    */
    public function insert_role_privi($role_id , $ids){

        //清除所有角色权限记录
        if($row = RolePrivi::where('role_id',$role_id)->get()){

             RolePrivi::where('role_id',$role_id)->delete();
        }

        if(empty($ids)){

            return redirect('privi/role');
        }

        foreach($ids as $id){

            $model                      = new RolePrivi();
            $model->role_id             = $role_id;
            $model->privi_id            = $id;

            $model->save();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回角色配置数组文件
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'role_name',
                        'name'          => '角色名称',
                        'value'         => '',
                        'id'            => 'role_name',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => '',
                        'id'            => 'sort_order',
                    ],

                    [
                        'type'          => 'privi_list',
                        'name'          => '所有权限列表',
                        'value'         => [],
                        'id'            => 'privi_list',
                    ],


                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 返回角色配置数组文件 编辑角色
    |
    |-------------------------------------------------------------------------------
    */
    public function EditData($model){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'role_name',
                        'name'          => '角色名称',
                        'value'         => $model->role_name,
                        'id'            => 'role_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => $model->sort_order,
                        'id'            => 'sort_order',
                    ],


                    [
                        'type'          => 'privi_list',
                        'name'          => '所有权限列表',
                        'value'         =>  $this->get_role_privi($model->id),
                        'id'            => 'privi_list',
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'role_id',
                        'value'         =>$model->id,
                        'id'            =>'role_id',
                    ],
                    [
                        'type'          => 'hidden',
                        'field'         => '_method',
                        'name'          => '表单递交方法',
                        'value'         => 'PUT',
                        'id'            => 'method',
                    ],


                    [
                        'type'          => 'submit',
                        'value'         => '确认编辑',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取系统角色权限
    |
    |-------------------------------------------------------------------------------
    */
    public function get_role_privi($role_id){

        $row                            = RolePrivi::where('role_id',$role_id)->get();
        $arr                            = [];

        if(empty($row)){

            return $arr;
        }

        foreach($row as $key=>$item){

            $arr[$key]                  = $item->privi_id;
        }

        return $arr;
    }
}
