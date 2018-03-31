<?php namespace App\Http\Controllers\Admin;

use App\Admin;
use File;
use HTML;
use Input;
use Phpstore\Administrator\CommonHelper;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Request;
use Validator;

class AdminController extends BaseController{



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
    public $help;

    function __construct(){

    	parent::__construct();
        $this->page                 = 'privi';
        $this->tag                  = 'admin.administrator.index';

        //初始化
        $this->list_url             = 'admin/administrator';
        $this->add_url              = 'admin/administrator/create';
        $this->update_url           = 'admin/administrator/update';
        $this->edit_url             = 'admin/administrator/edit/';
        $this->del_url              = 'admin/administrator/del/';
        $this->ajax_url             = 'admin/administrator/grid';
        $this->batch_url            = 'admin/administrator/batch';


        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url('admin/administrator'));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

        //初始化帮助对象
        $this->help                 = new CommonHelper();




    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示系统所有管理员列表
    |  路由         admin/administrator
    |  路由名称      admin.administrator.index
    |  路由类型      get
    |
    |-------------------------------------------------------------------------------
    */

    public function index(){


        $view                       = $this->view('crud.grid');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,Lang::get('admin_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('admin_list');

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,Lang::get('add_admin'));

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
        $grid->put('action_name',Lang::get('admin_list'));
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
    |  添加管理员
    |  路由 : admin/administra/create
    |  路径 : admin.administrator.index
    |  类型 : get
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){



        $view                       = $this->view('crud_add');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->path_url             = $this->get_path_url(HTML::link('admin/administrator/create',Lang::get('add_admin')));
        $view->action_name          = Lang::get('add_admin');




        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->FormData());

        $this->crud->put('url',url('admin/administrator'));

        $view->form                 = $this->crud->render();

        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  编辑管理员
    |  路由链接         admin/administrator/{id}/edit
    |  路由名称         admin.administrator.edit
    |  路由类型         get
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){


        $model                      = Admin::find($id);

        if(empty($model)){

            $this->sysinfo->put('info','非法操作');
            return $this->sysinfo->info();
        }

        $view                       = $this->View('crud_add');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = 'admin/administrator/'.$id.'/edit';
        $view->path_url             = $this->get_path_url(HTML::link($current_url,Lang::get('edit_admin')));
        $view->action_name          = Lang::get('edit_admin');

        //设置参数 通过crud组件生成输入界面表单
        $this->crud->put('row',$this->help->EditData($model));
        $this->crud->put('url',url('admin/administrator/'.$id));
        $view->form                 = $this->crud->render();


        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加管理员
    |  路由链接         admin/administrator/
    |  路由名称         admin.administrator.store
    |  路由类型         post
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $rules          = [

                            'username' =>'required|unique:users,username',
                            'email'    =>'required|email|unique:users,email',
                            'password' =>'required|confirmed|min:6',
                            'password_confirmation'=>'required'

                          ];

        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        //插入数据
        if($model = Admin::create(request()->all())){

             $model->password();
             $model->add_time       = time();
             $model->img();
             $model->update_admin_role();

             return redirect('admin/administrator');
        }
        else{

            return $this->sysinfo->fails();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  更新管理员
    |  路由链接         admin/administrator/{id}
    |  路由名称         admin.administrator.update
    |  路由类型         put
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){


        $id             = Request::input('id');
        $model          = Admin::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();

        }

        $rules          = [

                            'username' =>'required|unique:admins,username,'.$id,
                            'email'    =>'required|email|unique:admins,email,'.$id


                          ];

        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        

       if($model->update(request()->all())){

            $model->img();
            $model->password();
            $model->update_admin_role();

            return redirect($this->list_url);
        }
        else{


            return $this->sysinfo->error();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取系统所有管理员
    |
    |-------------------------------------------------------------------------------
    */
    public function get_admin_list(){

        $admin_list                     = Admins::where('is_admin',1)->get();

        foreach($admin_list as $key=>$value){

            $value['role_name']         = $this->get_role_name($value->role_id);
        }

        return $admin_list;
    }






    /*
    |-------------------------------------------------------------------------------
    |
    |  删除管理员
    |  路由链接         admin/administrator/del/{id}
    |  路由名称         admin.administrator.delete
    |  路由类型         get
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        $model          = Admin::find($id);

        if(empty($model)){

            //数据为空
            return $this->sysinfo->forbidden();
        }

        //删除图片
        $model->delete_img();
        //删除管理员角色表
       if(count($model->admin_role()->get())){

            $model->admin_role()->delete();
       }
       //删除自己
       $model->delete();

        return redirect($this->list_url);
    }

    /*
    |-----------------------------------------------------------------------
    |
    | 批量删除操作
    |
    |-----------------------------------------------------------------------
    */
    public function batch(){

        $ids        = Request::input('ids');

        if(empty($ids)){

            return $this->sysinfo->forbidden();
        }

        foreach($ids as $id){

            $model      = Admin::find($id);
            $model->delete_img();
            if(count($model->admin_role()->get())){

                $model->admin_role()->delete();
            }

            $model->delete();
        }

        return redirect($this->list_url);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   执行ajax grid操作
    |   输出json格式的商品列表数据 phpstore.grid.js组件根据json格式 重新生成table 并刷新列表
    |   对应路由  admin/administrator/grid
    |   路由名称  admin.administrator.grid
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

}
