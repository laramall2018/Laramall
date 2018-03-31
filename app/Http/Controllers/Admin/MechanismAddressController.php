<?php namespace App\Http\Controllers\Admin;

use App\Models\MechanismAddress;
use App\Models\Region;
use App\User;
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

class MechanismAddressController extends BaseController{



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
        $this->page                 = 'f-port';
        $this->tag                  = 'admin.me_address.index';

        //初始化
        $this->list_url             = 'admin/me_address';
        $this->add_url              = 'admin/me_address/create';
        $this->update_url           = 'admin/me_address/update';
        $this->edit_url             = 'admin/me_address/edit/';
        $this->del_url              = 'admin/me_address/del/';
        $this->ajax_url             = 'admin/me_address/grid';
        $this->batch_url            = 'admin/me_address/batch';


        $this->crud                 = new Crud();
        $this->form_to_model        = new FormToModel();

        $this->sysinfo              = new Sysinfo();
        $this->sysinfo->put('url',url($this->list_url));
        $this->sysinfo->put('page',$this->page);
        $this->sysinfo->put('tag',$this->tag);

        //初始化帮助对象
        $this->help                 = new CommonHelper();




    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  显示系统所有管理员列表
    |  路由         admin/me_address
    |  路由名称      admin.me_address.index
    |  路由类型      get
    |
    |-------------------------------------------------------------------------------
    */

    public function index(){


        $view                       = $this->view('me_address');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link($this->list_url,'机构地址列表');
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = '机构地址列表';

        //生成添加按钮
        $view->add_btn              = Common::get_add_btn($this->add_url,'添加机构地址');

        
        $view->address_list         = $this->get_mechanism_address_list();


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
    |  路由 : admin/me_address/create
    |  路径 : admin.me_address.create
    |  类型 : get
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){



        $view                       = $this->view('add_me_address');
        $view->page                 = $this->page;
        $view->tag                  = $this->tag;
        $current_url                = HTML::link('admin/me_address/create','添加机构地址');
        $view->path_url             = $this->get_path_url($current_url);
        $view->action_name          = Lang::get('add_me_address');
        $view->province_list        = $this->get_region_option_list(1);
        $view->ajax_url             = url('admin/me_address/ajax');



        return $view;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax联查 查询省会城市地区信息
    |  路由 : admin/me_address/ajax
    |  路径 : admin.me_address.ajax
    |  类型 : post
    |
    |-------------------------------------------------------------------------------
    */
    public function pcd_ajax(){

         $region_id         = Request::input('region_id');
         $region_type       = Request::input('region_type');

         $region_list       = Region::where('parent_id',$region_id)
                                    ->where('region_type',$region_type)
                                    ->get();
         $row               = [];

         foreach($region_list as $item){

             $row[]         = [

                                'id'=>$item->id,
                                'region_name'=>$item->region_name,
                                'parent_id'  =>$item->parent_id,
                                'region_type'=>$item->region_type,

            ];
         }

         echo json_encode(['data'=>$row]);
         exit;

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


        $model                      = User::find($id);

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
    |  路由链接         admin/me_address/
    |  路由名称         admin.me_address.store
    |  路由类型         post
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $rules          = [

                            'address'    =>'required',
                            'city'       =>'required',
                            'province'   =>'required',
                            'district'   =>'required'

                          ];

        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        $model                      = new  MechanismAddress();
        $model->country             = 1;
        $model->province            = Request::input('province');
        $model->city                = Request::input('city');
        $model->district            = Request::input('district');
        $model->address             = Request::input('address');



        if($model->save()){

             return redirect(url($this->list_url));
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
        $model          = User::find($id);

        if(empty($model)){

            return $this->sysinfo->forbidden();

        }

        $rules          = [

                            'username' =>'required|unique:users,username,'.$id,
                            'email'    =>'required|email|unique:users,email,'.$id


                          ];

        $validator      = Validator::make(Request::all(),$rules);

        if($validator->fails()){

            $this->sysinfo->put('validator',$validator);
            return $this->sysinfo->error();
        }

        //插入数据
        $this->form_to_model->put('model',$model);
        $this->form_to_model->put('row',$this->help->EditData($model));

        if($this->form_to_model->insert()){

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

        $admin_list                     = User::where('is_admin',1)->get();

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

        $model          = User::find($id);

        if(empty($model)){

            //数据为空
            return $this->sysinfo->forbidden();
        }

        $user_icon      = $model->user_icon;

        if($model->delete()){


            $this->help->delete($user_icon);
            return redirect($this->list_url);
        }
        else{

            //操作失败
            return $this->sysinfo->fails();
        }
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

            $model      = User::find($id);
            $user_icon  = $model->user_icon;
            if($model){

                $this->help->delete($user_icon);
                $model->delete();
            }
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

    /*
    |-------------------------------------------------------------------------------
    |
    |   获取所有机构地址列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_mechanism_address_list(){


            $address_list       = MechanismAddress::paginate(20);

            foreach($address_list as $value){

                 $value['country_str']          = $this->get_region_name($value->country);
                 $value['province_str']         = $this->get_region_name($value->province);
                 $value['city_str']             = $this->get_region_name($value->city);
                 $value['district_str']         = $this->get_region_name($value->district);
            }

            return $address_list;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   通过国家 省会 城市 地区的编号 获取中文名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_region_name($id){

            $region             = Region::find($id);

            if(empty($region)){

                return '';
            }

            return $region->region_name;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   通过region_type来获取地址列表信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_region_option_list($region_type){

         $region_list   = Region::where('region_type',$region_type)->get();
         $str           = '<option value="0">请选择</option>';

         foreach($region_list as $item){

            $str .='<option value="'.$item->id.'">'.$item->region_name.'</option>';
         }


         return $str;
    }


}
