<?php

use Phpstore\Crud\Crud; 			//使用crud类
use Phpstore\Crud\TemplateForm;		//使用生成表单的助手类


	/*
    |-------------------------------------------------------------------------------
    |
    | 添加数据的时候 生成模板页面需要的输入表单文件
    |
    |-------------------------------------------------------------------------------
    */
    public function create(){


    	$row 					= $this->get_form_data()    //获取填充表单的配置数组信息
    	$crud 					=  new Crud();				//创建一个crud的实例
    	$crud->put('row',$row); 							//设置生成表单文件的数组信息
    	$crud->put('url',url('admin/model'));				//form表单的action链接
    	$form 				 	= $crud->render(); 			//生成了带bootstrap样式的表单了

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 按照规则来写生成表单的配置文件信息
    |
    |-------------------------------------------------------------------------------
    */
    public function get_form_data(){

    	return [

    				//单行输入文本
                    [
                        'type'          => 'text',
                        'field'         => 'username',
                        'name'          => '管理员名称',
                        'value'         => '',
                        'id'            => 'username',
                    ],

                    

                    //密码输入文本
                    [
                        'type'          => 'password',
                        'field'         => 'password',
                        'name'          => '密码',
                        'value'         => '',
                        'id'            => 'password',
                    ],

                    //确认密码表单
                    [
                        'type'          => 'password_confirmation',
                        'field'         => 'password_confirmation',
                        'name'          => '确认密码',
                        'value'         => '',
                        'id'            => 'password_confirmation',
                    ],

                    //上传图片表单

                    [
                        'type'          =>'file',
                        'field'         =>'user_icon',
                        'name'          =>'用户头像',
                        'upload_img'    =>'',
                        'file_info'     =>'',
                        'id'            =>'user_icon'
                    ],

                    //单选按钮表单
                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否激活',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 1,
                        'id'            => 'is_show',
                    ],

                    //表单中隐似插入的数据 不需要用户输入

                    [
                        'type'          => 'insert',
                        'field'         => 'add_time',
                        'value'         => time(),
                    ],

                    //表单中插入访客的ip
                    [
                        'type'          => 'insert',
                        'field'         => 'login_ip',
                        'value'         =>  Request::getClientIp(),
                     ],

                     //下拉选择表单
                     [
                        'type'          => 'select',
                        'field'         => 'role_id',
                        'name'          => '角色',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' =>'请选择角色',
                        'selected_value'=> 0 ,
                        'id'            => 'tag',
                    ],

                    //编辑的时候 隐藏传递编号id
                    [
                        'type'          => 'hidden',
                        'field'         => 'id',
                        'name'          => '商品编号',
                        'value'         => $model->id,
                        'id'            => 'id',
                    ],

                    //设置post请求为put请求
                    [
                        'type'          => 'hidden',
                        'field'         => '_method',
                        'name'          => '表单递交方法',
                        'value'         => 'PUT',
                        'id'            => 'method',
                    ],

                    //百度富文本编辑框
                    [
                        'type'          => 'ueditor_big',//大编辑框
                        'type' 			=> 'ueditor' 	 //小编辑框
                        'field'         => 'goods_desc',
                        'name'          => '详情描述',
                        'value'         => '',
                        'id'            => 'editor',
                    ],

                    //多行输入表单
                     [
                        'type'          => 'textarea',
                        'field'         => 'keywords',
                        'name'          => '关键词',
                        'value'         => '',
                        'id'            => 'keywords',
                    ],

                    //多选按钮
                    [
                        'type'          => 'checkbox',
                        'field'         => 'site[]',
                        'field2'        => 'site',
                        'name'          => '所属分站',
                        'checkbox_row'  => Common::get_site_checkbox_list(),
                        'checked_row'   => Common::get_site_checked(),
                        'id'            => 'site',
                    ],


                     
                    //确认按钮 同时添加一个 返回按钮
                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url('admin/administrator'),
                    ],
        ];
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 单选按钮的值
    |
    |-------------------------------------------------------------------------------
    */
    public function get_radio(){

    	return [

    					['name'=>Lang::get('radio_name_100'),'value'=>100],
    					['name'=>Lang::get('radio_name_0'),'value'=>0],
    					['name'=>Lang::get('radio_name_1'),'value'=>1],

    		];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取品牌列表
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_brand_option_list(){

    	$brand_list 			= Brand::all();

    	if(empty($brand_list)){

    	 	return '';
    	}

    	$str  					= '';

    	foreach($brand_list as $item){

    		$str .= '<option value="'.$item->id.'">'.$item->brand_name.'</option>';
    	}

    	return $str;
    }


    	/*
        |-------------------------------------------------------------------------------
        |
        | 获取多选按钮的数组值
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_checkbox_list(){


            $site              = CitySite::all();
            $row               = [];

            if(empty($site)){

                return $row;
            }

            foreach($site as $key=>$value){

                $row[$key]['name']      = $value->site_name;
                $row[$key]['value']     = $value->site_code;
            }

            return $row;
        }


         /*
        |-------------------------------------------------------------------------------
        |
        | 返回多选表单被选中的值
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_checked(){

            return ['beijing'];
        }


        /*
        |-------------------------------------------------------------------------------
        |
        | 返回被选中的分站列表
        |
        |-------------------------------------------------------------------------------
        */
        public static function get_site_checked_edit($site_list){

            return explode('|',$site_list);
        }




