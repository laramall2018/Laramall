<?php

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\Models\Card;
use App\User;
use DB;
use File;
use HTML;
use Input;
use Phpstore\Grid\Common;
use Request;
use Validator;

class CardController extends SuperController
{
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
    public $DataModel;//新创建一个数据模型

    /*
    |-------------------------------------------------------------------------------
    |                .__                    __                        
    |        ______ |  |__ ______  _______/  |_  ___________   ____  
    |        \____ \|  |  \\____ \/  ___/\   __\/  _ \_  __ \_/ __ \ 
    |        |  |_> >   Y  \  |_> >___ \  |  | (  <_> )  | \/\  ___/ 
    |        |   __/|___|  /   __/____  > |__|  \____/|__|    \___  >
    |        |__|        \/|__|       \/                          \/ 
    |
    |-------------------------------------------------------------------------------
    |   相关的属性         相关说明
    |-------------------------------------------------------------------------------
    |   model            模型名称
    |   page             当前页的一级权限名称
    |   table            当前需要操作的数据表
    |   DataModel        生成一个全新空的数据模型 用于添加新纪录的时候赋值
    |   store_rules      添加新纪录时候的验证规则
    |   update_rules     更新记录时候的验证规则
    |-------------------------------------------------------------------------------
    |   相关函数          相关说明
    |-------------------------------------------------------------------------------   
    |   get_model($id)   获取当前模型
    |   keywords()       设置ajax搜索表单中需要参与搜索的数据库字段 一维数组的形式
    |   set_data_col     设置后台数据表格需要显示的数据库字段
    |   getData($data)   对tableData返回的数据进行格式化
    |   searchData()     设置生成搜索表单的参数
    |   searchInfo()     设置ajax排序js文件所需要的json格式参数
    |   FormData()       设置生成添加新记录的表单参数
    |   EditData($model) 设置生成编辑记录表单的参数
    |-------------------------------------------------------------------------------
    */
    function __construct(){

        parent::__construct();


        //设置参数
        $this->model                   = 'card'; 
        $this->page                    = 'promotion';
        //设置连接和名称
        $this->urlInit();
        //设置数据表
        $this->table                   = 'card';
        //设置数据模型
        $this->DataModel               = new Card();
        //新添加数据验证规则
        $this->store_rules             = [

                                            'card_sn'           =>'required|unique:card,card_sn',
                                            'price'             =>'required',

        ];
        //更新数据验证规则
        $this->update_rules             = [

                                           'card_sn'           =>'required',
                                           'price'             =>'required',

        ];

        //初始化帮助函数 不需要修改
        $this->HelpInit();
        //初始化工厂控制器 不需要修改
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

        return Card::find($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 设置搜索关键词
    |
    |-------------------------------------------------------------------------------
    */
    public function keywords(){

        return ['card_sn','price'];
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
                    [   'col_name'        =>'id', //数据表中对应的字段
                        'alias_name'      =>'id', //别名 用于格式化数据
                        'col_value'       =>'编号',//数据表中字段对应的中文名称
                        'width'           =>'100px',//在表格中的宽度
                    ],
                    [ 
                        'col_name'        =>'card_sn',
                        'alias_name'      =>'card_sn',
                        'col_value'       =>'序列号',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'tag',
                        'alias_name'      =>'tag_str',
                        'col_value'       =>'状态',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'price',   
                        'alias_name'      =>'price',          
                        'col_value'       =>'金额',  
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'admin_id',
                        'alias_name'      =>'admin',
                        'col_value'       =>'管理员',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'user_id',
                        'alias_name'      =>'username',
                        'col_value'       =>'用户名称',
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'add_time',
                        'alias_name'      =>'add_time_str',  
                        'col_value'       =>'添加时间',       
                        'width'           =>'',
                    ],
                    [ 
                        'col_name'        =>'end_time',
                        'alias_name'      =>'end_time_str',  
                        'col_value'       =>'结束时间',       
                        'width'           =>'',
                    ],

                    [ 
                        'col_name'        =>'sort_order',
                        'alias_name'      =>'sort_order',  
                        'col_value'       =>'排序',       
                        'width'           =>'',
                    ],
                    
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

            $model                         = Card::find($value['id']);
            $data[$key]['add_time_str']    = $model->add_date();
            $data[$key]['end_time_str']    = $model->end_date();
            $data[$key]['tag_str']         = $this->get_tag_status($value['tag']);
            $data[$key]['admin']           = ($model->admin)? $model->admin->username:'';
            $data[$key]['username']        = ($model->user)? $model->user->username:'';


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
                        'field'         => 'card_sn',
                        'name'          => '序列号',
                        'value'         => '',
                        'id'            => 'card_sn',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'price',
                        'name'          => '金额',
                        'value'         => '',
                        'id'            => 'price',
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
                                    ['field'=>'card_sn','value'=>''],
                                    ['field'=>'price','value'=>''],
                                    
                                   
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

                    [
                        'type'          =>'text',
                        'field'         =>'card_sn',
                        'name'          =>'序列号',
                        'value'         => str_random(10),
                        'id'            =>'card_sn',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'sort_order',
                        'name'          =>'排序',
                        'value'         =>0,
                        'id'            =>'sort_order',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'price',
                        'name'          =>'金额',
                        'value'         =>'',
                        'id'            =>'price',
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'tag',
                        'name'          => '状态',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 0,
                        'id'            => 'tag',
                    ],


                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'admin_id',
                        'name'          => '管理员',
                        'option_list'   => Admin::optionList(),
                        'selected_name' =>'请选择管理员',
                        'selected_value'=> 0,
                        'id'            => 'admin_id',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'user_id',
                        'name'          => '会员名称',
                        'option_list'   => User::optionList(),
                        'selected_name' =>'请选择会员',
                        'selected_value'=> 0,
                        'id'            => 'user_id',
                    ],

                    //表单中隐似插入的数据 不需要用户输入

                    
                    [
                        'type'          =>'text',
                        'field'         =>'add_time',
                        'name'          =>'开始时间',
                        'value'         =>'',
                        'id'            =>'add_time',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'end_time',
                        'name'          =>'结束时间',
                        'value'         =>'',
                        'id'            =>'end_time',
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

                    [
                        'type'          =>'text',
                        'field'         =>'card_sn',
                        'name'          =>'序列号',
                        'value'         =>$model->card_sn,
                        'id'            =>'card_sn',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'sort_order',
                        'name'          =>'排序',
                        'value'         =>$model->sort_order,
                        'id'            =>'sort_order',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'price',
                        'name'          =>'金额',
                        'value'         =>$model->price,
                        'id'            =>'price',
                    ],
                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'tag',
                        'name'          => '状态',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->tag,
                        'id'            => 'tag',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'admin_id',
                        'name'          => '管理员',
                        'option_list'   => Admin::optionList(),
                        'selected_name' => ($model->admin)? $model->admin->username:'',
                        'selected_value'=> $model->admin_id,
                        'id'            => 'admin_id',
                    ],

                    //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'user_id',
                        'name'          => '会员名称',
                        'option_list'   => User::optionList(),
                        'selected_name' => ($model->user)? $model->user->username:'',
                        'selected_value'=> $model->user_id,
                        'id'            => 'user_id',
                    ],

                    [
                        'type'          =>'text',
                        'field'         =>'add_time',
                        'name'          =>'开始时间',
                        'value'         =>date('Y-m-d',$model->add_time),
                        'id'            =>'add_time',
                    ],
                    [
                        'type'          =>'text',
                        'field'         =>'end_time',
                        'name'          =>'结束时间',
                        'value'         =>date('Y-m-d',$model->end_time),
                        'id'            =>'end_time',
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
    |  创建模型
    |
    |-------------------------------------------------------------------------------
    */
    public function store(){

        $validator     = Validator::make(Request::all(),$this->store_rules);
         if($validator->fails()){

            $this->ctl->sysinfo->put('validator',$validator);
            return $this->ctl->sysinfo->error();
         }

         $model                 = Card::create(request()->all());
         $model->timeFormat();
         return redirect($this->list_url);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  编辑模型
    |
    |-------------------------------------------------------------------------------
    */
    public function update(){

        $id                 = request()->id;
        $model              = Card::find($id);
        if(empty($model)){

           return $this->ctl->sysinfo->forbidden();
        }
        //验证表单
        $validator      = Validator::make(request()->all(),$this->update_rules);
        if($validator->fails()){
            $this->ctl->sysinfo->put('validator',$validator);
            return $this->ctl->sysinfo->error();
        }
        //更新数据
        $model->update(request()->all());
        $model->timeFormat();
        return redirect($this->list_url);
    }











    /*=======================  以下为辅佐函数 ======================================*/

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_user_select_option_list(){

         $row               = DB::table('users')->get();
         $str               = '<option value="">请选择</option>';

         foreach($row as $item){

            $str            .= '<option value="'.$item->username.'">'.$item->username.'</option>';
         }

         return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_admin_select_option_list(){

         $row               = DB::table('admins')->get();
         $str               = '<option value="">请选择</option>';

         foreach($row as $item){

            $str            .= '<option value="'.$item->username.'">'.$item->username.'</option>';
         }

         return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取用户名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_username($user_id){

        $model      = DB::table('users')->where('id',$user_id)->first();

        if($model){

            return $model->username;
        }


        return '';
    }
   
   /*
    |-------------------------------------------------------------------------------
    |
    | 获管理员
    |
    |-------------------------------------------------------------------------------
    */
    public function get_admin_username($user_id){

        $model      = DB::table('admins')->where('id',$user_id)->first();

        if($model){

            return $model->username;
        }


        return '';
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


                        ['name'=>'未激活','value'=>0],
                        ['name'=>'已激活','value'=>1],
                        ['name'=>'已使用','value'=>2],
                      
            ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取状态
    |
    |-------------------------------------------------------------------------------
    */
    public function get_tag_status($tag){

        $tag        = intval($tag);
        $row        = ['未激活','激活','已使用'];

        if(in_array($tag,[0,1,2])){

            return $row[$tag];
        }


        return $row[0];
    }


}
