<?php namespace App\Http\Controllers\Admin;

use App\Models\Privi;
use Cache;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Base\Lang;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Request;
use Route;
use Validator;


/*
|-------------------------------------------------------------------------------
|
|  路由url                   路由命名                       对应函数          类型
|-------------------------------------------------------------------------------
|  admin/privi              admin.privi.index             index()          get
|  admin/privi/create       admin.privi.create            create()         get
|  admin/privi              admin.privi.store             store()          post
|  admin/privi/{id}/edit    admin.privi.edit              edit()           get
|  admin/privi/{id}         admin.privi.update            update()         put
|-------------------------------------------------------------------------------
|  admin/privi/del/{id}     admin.privi.delete            delete()         get
|-------------------------------------------------------------------------------
*/

class PriviController extends BaseController{



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

    function __construct(){

        parent::__construct();
        $this->page                 = 'privi';
        $this->tag                  = 'admin.privi.index';
        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url('admin/privi'));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);
        $this->list_url             = 'admin/privi';




    }




    /*
    |-------------------------------------------------------------------------------
    |
    |  显示系统所有的权限列表
    |  路由名称 : admin.privi.index
    |  路由链接 : admin/privi
    |  路由类型 : get
    |
    |-------------------------------------------------------------------------------
    */

    public function index(){


        $view                       = $this->view('privi_list');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link('admin/privi',Lang::get('privi_list'));
        $view->path_url             = $this->get_path_url($current_url);
        $view->privi_list           = $this->get_privi_list();
        $view->action_name          = Lang::get('privi_list');

        return $view;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  添加权限表单
    |  路由名称   admin.privi.create
    |  路由连接   admin/privi/create
    |  路由类型   get
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){


        $this->crud->put('row',$this->FormData());
        $this->crud->put('url',url('admin/privi'));

        $view                       = $this->view('crud_add');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->action_name          = '添加权限';
        $view->form                 = $this->crud->render();
        $view->path_url             = $this->get_path_url(HTML::link('admin/privi/create','添加权限'));
        //表单验证js文件
        $view->form_validate_url    = $this->create_script(url('files/privi_validate.js'));

        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  编辑权限
    |
    |-------------------------------------------------------------------------------
    */
    public function edit($id){


        $model                     = Privi::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }


        $this->crud->put('row',$this->EditData($model));
        $this->crud->put('url',url('admin/privi/'.$model->id));

        $view                       = $this->View('crud_add');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->action_name          = '编辑权限';
        $view->form                 = $this->crud->form();
        $view->path_url             = $this->get_path_url(HTML::link('admin/privi/'.$id.'/edit','编辑权限'));


        return $view;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  数据插入到数据表中
    |  路由名称 ：admin.privi.store
    |  路由路径 ：admin/privi/store
    |  路由类型 : post
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $rules                     = [

                                        'privi_name'=>'required|unique:privi,privi_name',
                                        'privi_code'=>'required|unique:privi,privi_code',
                                        'privi_route'=>'unique:privi,privi_route'

                                     ];

        $validator                  = Validator::make(Request::all(),$rules);

        if($validator->fails()){

             $this->sysinfo->put('validator',$validator);
             $this->sysinfo->put('back_url',url('admin/privi'));
             return $this->sysinfo->error();
        }

        $model                      = new Privi();
        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->FormData());

        if($this->form_to_model->insert()){

            return redirect('admin/privi');
        }
        else{

            return $this->sysinfo->fails();
        }

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  更新权限 update
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

        $id                     = Request::input('id');
        $model                  = Privi::find($id);
        if(empty($model)){

            return $this->sysinfo->forbidden();
        }

        $rules                  = [

                                    'privi_name'=>'required|unique:privi,privi_name,'.$id,
                                    'privi_code'=>'required|unique:privi,privi_code,'.$id,
                                    'privi_route'=>'unique:privi,privi_route,'.$id

                                  ];

        $validator              = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            $this->sysinfo->put('back_url',url('admin/privi'));
            return $this->sysinfo->error();
        }

        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->EditData($model));

        if($this->form_to_model->insert()){

            return redirect('admin/privi');
        }
        else{

            return $this->sysinfo->fails();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  删除权限
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){


        $model              = Privi::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();
        }


        if($model->parent_id == 0){

            $row        = Privi::where('parent_id',$id)->first();

            if($row){

                $this->sysinfo->put('info','此权限有子权限 禁止删除');
                return $this->sysinfo->info();
            }
        }


        if($model->delete()){

            return redirect('admin/privi');
        }else{

            return $this->sysinfo->fails();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  批量添加授权
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){

        $this->crud->put('row',$this->BatchFormData());
        $this->crud->put('url',url('admin/privi/batch'));

        $view                       = $this->view('crud_add');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $view->action_name          = '批量添加权限';
        $view->form                 = $this->crud->render();
        $view->path_url             = $this->get_path_url(HTML::link('admin/privi/create-batch','批量添加权限'));
        //表单验证js文件
        $view->form_validate_url    = '';

        return $view;


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理批量权限存储
    |
    |-------------------------------------------------------------------------------
    */
    public function batch_store(){


            $privi_name                     = Request::input('privi_name');
            $privi_code                     = Request::input('privi_code');
            $codes                          = Request::input('codes');
            $parent_id                      = Request::input('parent_id');

            $code_name_row                  = [

                    'index'                 =>'查看',
                    'create'                =>'创建',
                    'store'                 =>'存储',
                    'edit'                  =>'编辑',
                    'update'                =>'更新',
                    'delete'                =>'删除',
                    'batch'                 =>'批量',
                    'grid'                  =>'排序',
            ];

            if(empty($codes)){

                return redirect($this->list_url);
            }

            foreach($codes as $item){

                    $privi                  = new Privi();
                    
                    if(array_key_exists($item,$code_name_row)){

                        $privi->privi_name   = $privi_name.$code_name_row[$item];
                        $privi->privi_code   = 'admin.'.$privi_code.'.'.$item;
                        $privi->parent_id    = $parent_id;
                        $privi->save();
                    }
            }

            return redirect($this->list_url);

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 返回系统表单字段的配置文件数组
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'privi_name',
                        'name'          => '权限名称',
                        'value'         => '',
                        'id'            => 'privi_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'privi_code',
                        'name'          => '权限代码',
                        'value'         => '',
                        'id'            => 'privi_code',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'privi_route',
                        'name'          => '权限路由',
                        'value'         => '',
                        'id'            => 'privi_route',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'parent_id',
                        'name'          => '父权限',
                        'option_list'   =>  $this->get_select_option_list(),
                        'selected_name' =>'顶级权限',
                        'selected_value'=>0,
                        'id'            => 'parent_id',
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url('admin/privi'),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回系统表单字段的配置文件数组
    |
    |-------------------------------------------------------------------------------
    */
    public function BatchFormData(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'privi_name',
                        'name'          => '权限名称',
                        'value'         => '',
                        'id'            => 'privi_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'privi_code',
                        'name'          => '权限代码',
                        'value'         => '',
                        'id'            => 'privi_code',
                    ],

                     [
                        'type'          => 'checkbox',
                        'field'         => 'codes[]',
                        'field2'        => 'codes',
                        'name'          => '权限代码',
                        'checkbox_row'  => $this->get_checkbox_list(),
                        'checked_row'   => $this->get_checkboxed_row(),
                        'id'            => 'code',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'parent_id',
                        'name'          => '父权限',
                        'option_list'   =>  $this->get_select_option_list(),
                        'selected_name' =>'顶级权限',
                        'selected_value'=>0,
                        'id'            => 'parent_id',
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url('admin/privi'),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 编辑配置文件
    |
    |-------------------------------------------------------------------------------
    */
    public function EditData($model){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'privi_name',
                        'name'          => '权限名称',
                        'value'         => $model->privi_name,
                        'id'            => 'privi_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'privi_code',
                        'name'          => '权限代码',
                        'value'         => $model->privi_code,
                        'id'            => 'privi_code',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'privi_route',
                        'name'          => '权限路由',
                        'value'         => $model->privi_route,
                        'id'            => 'privi_route',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'parent_id',
                        'name'          => '父权限',
                        'option_list'   =>  $this->get_select_option_list(),
                        'selected_name' => $this->get_privi_name($model->parent_id),
                        'selected_value'=>$model->parent_id,
                        'id'            => 'tag',
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'id',
                        'value'         =>$model->id,
                        'id'            =>'id',
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
                        'value'         => '确认更新',
                        'id'            => 'cat-submit',
                        'back_url'      => url('admin/privi'),
                    ],
        ];

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取系统权限
    |
    |-------------------------------------------------------------------------------
    */
    public function get_privi_list(){

        if(Cache::has('privi_list')){

            return Cache::get('privi_list');
        }
        else{

            $privi_list                = Privi::where('parent_id',0)->paginate(20);
            foreach($privi_list as $item){

                $item['child']         = Privi::where('parent_id',$item->id)->get();
            }

            Cache::put('privi_list',$privi_list,3600);
            return Cache::get('privi_list');

        }
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取权限选择下拉表单
    |
    |-------------------------------------------------------------------------------
    */
    public function get_select_option_list(){

        $privi_list             = Privi::where('parent_id',0)->get();
        $str                    = '';
        foreach($privi_list as $item){

            $str .= '<option value="'.$item->id.'">'.$item->privi_name.'</option>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取系统权限名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_privi_name($id){

        if($privi =  Privi::find($id)){

            return $privi->privi_name;
        }

        return '顶级权限';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取checkbox的选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_checkbox_list(){

        $row        = [

                        ['name'=>'查看','value'=>'index'],
                        ['name'=>'创建','value'=>'create'],
                        ['name'=>'存储','value'=>'store'],
                        ['name'=>'编辑','value'=>'edit'],
                        ['name'=>'更新','value'=>'update'],
                        ['name'=>'删除','value'=>'delete'],
                        ['name'=>'批量','value'=>'batch'],
                        ['name'=>'排序','value'=>'grid'],

        ];

        return $row;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回所有被选中的多选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_checkboxed_row(){

        return ['index','create','store','edit','update','delete','batch','grid'];
    }
}
