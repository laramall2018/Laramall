<?php namespace App\Http\Controllers\Admin;

use App\Models\Account;
use DB;
use File;
use HTML;
use Input;
use Phpstore\AdminCommon\CommonHelper as CommonHelper;
use Phpstore\Base\Sysinfo;
use Phpstore\Crud\Crud;
use Phpstore\Crud\FormToModel;
use Phpstore\Grid\Common;
use Phpstore\Grid\Grid;
use Request;

/*
|----------------------------------------------------------------------------------------
|               
| 路由类型        路由                        对应处理函数             路由名称
|----------------------------------------------------------------------------------------
| route get      admin/{model}               function index()       admin.{model}.index
| route get      admin/{model}/create        function create()      admin.{model}.create
| route post     admin/{model}               function store()       admin.{model}.store
| route get      admin/{model}/{id}/edit     function edit()        admin.{model}.edit
| route put      admin/{model}/{id}          function update()      admin.{model}.update
|---------------------------------------------------------------------------------------
| route get      admin/{model}/delete/{id}   function delete()      admin.{model}.destroy
| route post     admin/{model}/batch         function batch()       admin.{model}.batch
| route post     admin/{model}/grid          function grid()        admin.{model}.grid
|---------------------------------------------------------------------------------------
*/
class AccountController extends BaseController{


    public $ctl;
    public $page;
    public $tag;
    public $view;
    public $layout;
    public $form;
    public $crud;
    public $row;
    public $form_to_model;
    public $list_name;
    public $add_name;
    public $edit_name;
    public $store_rules;//存储验证规则
    public $update_rules;//更新表单验证规则
    public $model;
    public $help;
    public $table;
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){

    	parent::__construct();
        
        //设置参数
        $this->page                    = 'user';
        $this->tag                     = 'admin.account.index';

        //定义商品的常用操作链接
        $this->list_url                = 'admin/account';
        $this->edit_url                = 'admin/account/edit';
        $this->add_url                 = 'admin/account/create';
        $this->update_url              = 'admin/account/update';
        $this->del_url                 = 'admin/account/delete/';
        $this->batch_url               = 'admin/account/batch';
        $this->preview_url             = '';
        $this->ajax_url                = 'admin/account/grid';

        //名称
        $this->list_name               = trans('admin.account_list');
        $this->add_name                = trans('admin.add_account');
        $this->edit_name               = trans('admin.edit_account');

        //设置数据表
        $this->table                   = 'users_account';

        //新添加数据验证规则
        $this->store_rules             = [

                                            'username'   =>'required',
                                            'amount'     =>'required',
                                            'type'       =>'required',
                                            'payment'    =>'required',
                                            'pay_tag'    =>'required',

        ];
        //更新数据验证规则
        $this->update_rules             = [

                                            'username'   =>'required',
                                            'amount'     =>'required',
                                            'type'       =>'required',
                                            'payment'    =>'required',
                                            'pay_tag'    =>'required',

        ];

        //初始化帮助函数
        $this->HelpInit();

        //初始化工厂控制器
        $this->CtlInit();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成数据模型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_model($id){

        $id             = intval($id);

        if($id == 0){

            return  new Account();
        }

        return Account::find($id);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return ['username','amount','payment',];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 设置需要显示的数据库字段
    |
    |-------------------------------------------------------------------------------
    */
    public function set_data_col(){

        return [

        [ 'col_name'=>'id',         'alias_name'=>'id',             'col_value'=>'编号',      'width'=>'100px'],
        [ 'col_name'=>'username',   'alias_name'=>'username',       'col_value'=>'用户名称',   'width'=>'',],
        [ 'col_name'=>'amount',     'alias_name'=>'amount',         'col_value'=>'金额',      'width'=>'',],
        [ 'col_name'=>'admin',      'alias_name'=>'admin',          'col_value'=>'管理员名称', 'width'=>'',],
        [ 'col_name'=>'add_time',   'alias_name'=>'add_time_str',   'col_value'=>'操作时间',   'width'=>'',],
        [ 'col_name'=>'type',       'alias_name'=>'type_status',    'col_value'=>'类型',      'width'=>'',],
        [ 'col_name'=>'user_note',  'alias_name'=>'user_note',      'col_value'=>'用户备注',   'width'=>'',],
        [ 'col_name'=>'admin_note', 'alias_name'=>'admin_note',     'col_value'=>'管理员备注', 'width'=>'',],
        [ 'col_name'=>'payment',    'alias_name'=>'payment',        'col_value'=>'支付方式',   'width'=>'',],
        [ 'col_name'=>'pay_tag',    'alias_name'=>'pay_tag_str',    'col_value'=>'支付状态',   'width'=>'',],

        ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  把获取的数据 再进一步格式化
    |
    |-------------------------------------------------------------------------------
    */
    public function getData($data){

        if(empty($data)){

            return '';
        }

        foreach($data as $key=>$value){

            //alias赋值
            $data[$key]['add_time_str']    = date('Y-m-d',$value['add_time']);
            $data[$key]['pay_tag_str']     = $this->get_pay_tag_status($value['pay_tag']);
            $data[$key]['type_status']     = $this->get_type_status($value['type']);
           

            //操作链接
            $data[$key]['edit_url']        = Common::get_resource_edit_url($this->list_url,$value['id']);
            $data[$key]['del_url']         = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']     = '';
        }

        return $data;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 生成grid页面 搜索表单的配置数组
    |
    |-------------------------------------------------------------------------------
    */
    public function searchData(){

        return [

                    [
                        'type'          => 'select',
                        'field'         => 'per_page',
                        'name'          => '分页大小',
                        'option_list'   => Common::get_per_page_option_list(),
                        'selected_name' => '5个/页',
                        'selected_value'=> 5,
                        'id'            => 'per_page',
                    ],


                    [
                        'type'          => 'text',
                        'field'         => 'username',
                        'name'          => '用户名称',
                        'value'         => '',
                        'id'            => 'username',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'amount',
                        'name'          => '金额',
                        'value'         => '',
                        'id'            => 'amount',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'payment',
                        'name'          => '支付方式',
                        'value'         => '',
                        'id'            => 'payment',
                    ],

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  把执行ajax的搜索参数 用json格式化后 传递给grid页面
    |
    |-------------------------------------------------------------------------------
    */
    public function searchInfo(){

        $row    = [

                    'keywords'=>[
                                    ['field'=>'username','value'=>''],
                                    ['field'=>'amount','value'=>''],
                                    ['field'=>'payment','value'=>''],
                    ],

                    'fieldRow'=>[


                    ],

                    'whereIn'=>[],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                     //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'username',
                        'name'          => '会员名称',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'username',
                    ],
                    
                    [
                        'type'          => 'text',
                        'field'         => 'amount',
                        'name'          => '金额',
                        'value'         => '',
                        'id'            => 'amount',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'admin',
                        'name'          => '管理员名称',
                        'option_list'   => $this->get_admin_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> '' ,
                        'id'            => 'admin',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'type',
                        'name'          => '类型',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 0,
                        'id'            => 'type',
                    ],


                    
                    [
                        'type'          => 'insert',
                        'field'         => 'add_time',
                        'name'          => '注册时间',
                        'value'         => time(),
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'ip',
                        'value'         => Request::getClientIp(),
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'user_note',
                        'name'          => '用户备注',
                        'value'         => '',
                        'id'            => 'user_note',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'admin_note',
                        'name'          => '管理员备注',
                        'value'         => '',
                        'id'            => 'admin_note',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'payment',
                        'name'          =>'支付方式',
                        'value'         =>'',
                        'id'            =>'payment',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'pay_tag',
                        'name'          => '支付状态',
                        'radio_row'     => $this->get_pay_radio(),
                        'checked'       => 0,
                        'id'            => 'pay_tag',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => 0,
                        'id'            => 'sort_order',
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
    | 编辑商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function EditData($model){

        return [

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'username',
                        'name'          => '会员名称',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' => $model->username,
                        'selected_value'=> $model->username ,
                        'id'            => 'username',
                    ],
                    
                    [
                        'type'          => 'text',
                        'field'         => 'amount',
                        'name'          => '金额',
                        'value'         => $model->amount,
                        'id'            => 'amount',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'admin',
                        'name'          => '管理员名称',
                        'option_list'   => $this->get_admin_select_option_list(),
                        'selected_name' => $model->admin,
                        'selected_value'=> $model->amdin ,
                        'id'            => 'admin',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'type',
                        'name'          => '类型',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->type,
                        'id'            => 'type',
                    ],


                    
                    

                    [
                        'type'          => 'textarea',
                        'field'         => 'user_note',
                        'name'          => '用户备注',
                        'value'         => $model->user_note,
                        'id'            => 'user_note',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'admin_note',
                        'name'          => '管理员备注',
                        'value'         => $model->admin_note,
                        'id'            => 'admin_note',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'payment',
                        'name'          =>'支付方式',
                        'value'         =>$model->payment,
                        'id'            =>'payment',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'pay_tag',
                        'name'          => '支付状态',
                        'radio_row'     => $this->get_pay_radio(),
                        'checked'       => $model->pay_tag,
                        'id'            => 'pay_tag',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => $model->sort_order,
                        'id'            => 'sort_order',
                    ],
                    [
                        'type'          =>'hidden',
                        'field'         =>'id',
                        'value'         =>$model->id,
                        'id'            =>'id'
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
                        'back_url'      => url($this->list_url),
                    ],
        ];

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取字符状态
    |
    |-------------------------------------------------------------------------------
    */
    public function get_pay_tag_status($pay_tag){

         $row               = ['未支付','已支付'];
         $pay_tag           = intval($pay_tag);

         if(in_array($pay_tag ,[0,1])){

            return $row[$pay_tag];
         }

         return $row[0];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取充值类型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_type_status($type){

        $row        = ['充值','提现'];
        $type       = intval($type);

        if(in_array($type ,[0,1])){

            return $row[$type];
        }

        return $row[0];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  返回radio表单的list
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_radio(){

            return [


                        ['name'=>'充值','value'=>0],
                        ['name'=>'提现','value'=>1],

            ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  返回radio表单的list
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_pay_radio(){

            return [


                        ['name'=>'未支付','value'=>0],
                        ['name'=>'已支付','value'=>1],

            ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取下拉选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_select_option_list(){

        $row            = DB::table('users')->get();
        $str            = '<option value="">请选择</option>';

        foreach($row as $item){

            $str        .= '<option value="'.$item->username.'">'.$item->username.'</option>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取下拉选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_admin_select_option_list(){

        $row            = DB::table('admins')->get();
        $str            = '<option value="">请选择</option>';

        foreach($row as $item){

            $str        .= '<option value="'.$item->username.'">'.$item->username.'</option>';
        }

        return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 从这里开始 下面的函数 不需要做任何修改
    |
    |-------------------------------------------------------------------------------
    */



    /*
    |-------------------------------------------------------------------------------
    |
    | 初始化工厂控制器
    |
    |-------------------------------------------------------------------------------
    */
    public function CtlInit(){

        //生成工厂控制器
        $this->ctl                          = new AdminCommonController();
        //设置参数
        $this->ctl->page                    = $this->page;
        $this->ctl->tag                     = $this->tag;
        $this->ctl->crud                    = new Crud();
        $this->ctl->form_to_model           = new FormToModel();

        //定义商品的常用操作链接
        $this->ctl->list_url                = $this->list_url;
        $this->ctl->edit_url                = $this->edit_url;
        $this->ctl->add_url                 = $this->add_url;
        $this->ctl->update_url              = $this->update_url;
        $this->ctl->del_url                 = $this->del_url;
        $this->ctl->batch_url               = $this->batch_url;
        $this->ctl->preview_url             = $this->preview_url;
        $this->ctl->ajax_url                = $this->ajax_url;

        //名称
        $this->ctl->list_name               = $this->list_name;
        $this->ctl->add_name                = $this->add_name;
        $this->ctl->edit_name               = $this->edit_name;
        
        //初始化数据表
        $this->ctl->table                   = $this->table;
        //添加验证规则
        $this->ctl->store_rules             = $this->store_rules;
        $this->ctl->update_rules            = $this->update_rules;

        //初始化帮助对象
        $this->ctl->help                    = $this->help;

        //其他设置
        $this->ctl->sysinfo                 = new Sysinfo();
        $this->ctl->sysinfo->put('url',url($this->list_url));
        $this->ctl->sysinfo->put('page',$this->page);
        $this->ctl->sysinfo->put('tag',$this->tag);

    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 初始化帮助函数
    |
    |-------------------------------------------------------------------------------
    */
    public function HelpInit(){

        $this->help                          = new CommonHelper();
        

        //设置操作的数据表
        $this->help->table                   = $this->table;
        //设置搜索关键词
        $this->help->keywords                = $this->keywords();
        //设置TableData需要显示的数据库的字段
        $this->help->field_row               = $this->set_data_col();
        //设置生成搜索表单的参数（json格式数据 给js)
        $this->help->searchInfo              = $this->searchInfo();
        //设置生成搜索表单的参数
        $this->help->searchData              = $this->searchData();

        //生成help对象的属性tableData;
        $this->help->tableData               = $this->help->tableDataInit();
        //设置help对象的属性对象tableData的值
        $this->help->data                    = $this->getData($this->help->tableData->toArray());
        //用格式化的data值重新复制给对象tableData
        $this->help->tableData->put('data',$this->help->data);

        //设置添加表单的参数
        $this->help->FormData                = $this->FormData();

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  显示所有列表 index
    |
    |-------------------------------------------------------------------------------
    */
    public function index(){

        return $this->ctl->index();
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
        $tableData->put('data',$this->getData($tableData->toArray()));

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

       return $this->ctl->create();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行添加商品的操作 post
    |   路由名称：admin.category.store
    |   对应路由  admin/category
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $model              = $this->get_model(0);
        return $this->ctl->store($model);

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

        $model                           = $this->get_model($id);
        $this->ctl->help->EditData       = $this->EditData($model);
        return $this->ctl->edit($model);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行更新商品操作 put 这里需要伪装路由为 put
    |   路由名称：admin.category.update
    |   对应路由  admin/category/{id}
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

        $model                      = $this->get_model(Request::input('id'));
        $this->ctl->help->EditData  = $this->EditData($model);    

        return $this->ctl->update($model);

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行删除商品操作 delete
    |   对应路由  admin/goods/{id}
    |   路由名称  admin.goods.destroy
    |
    |-------------------------------------------------------------------------------
    */
    public function delete($id){

        return $this->ctl->delete($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   执行批量操作 post
    |   对应路由  admin/category/batch
    |   路由名称为 admin.category.batch
    |
    |-------------------------------------------------------------------------------
    */
    public function batch(){


        return $this->ctl->batch();

    }


}