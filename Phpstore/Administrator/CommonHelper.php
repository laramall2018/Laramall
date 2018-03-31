<?php namespace Phpstore\Administrator;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Attribute;
use App\Models\GoodsAttr;
use App\Models\Role;
use Request;
use App\Admin;

/*
|-------------------------------------------------------------------------------
|
|   商品控制器里面的grid相应操作函数
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		--------------- 设置tabledata实例需要显示的数据库字段
|   getData 		    --------------- 根据指定的字段 获取表格所需要显示的所有数据
|   getTableData($info) --------------- 根据返回的json格式数据 初始化新的tableData实例
|   searchData          --------------- grid模板页面 需要的搜索表单配置数组
|   searchInfo 			--------------- grid模板页面 ajax操作函数 需要的json格式参数
|                                       ps.ui.grid(ajax_url,_token ,json)
|   FormData            --------------- 生成添加商品时候的表单数据信息
|   EditData            --------------- 编辑商品时候生成表单的数组信息
|   delete_goods_image  --------------- 删除商品图片
|   softdelAction       --------------- 批量回收站操作
|   deleteAction        --------------- 批量删除操作
|
|-------------------------------------------------------------------------------
*/
class CommonHelper{

	protected $data;



	/*
	|----------------------------------------------------------------------------
	|
	|  构造函数
	|
	|----------------------------------------------------------------------------
	*/
	function __construct(){

		//定义商品的常用操作链接
        $this->list_url             = 'admin/administrator';
        $this->add_url              = 'admin/administrator/create';
        $this->update_url           = 'admin/administrator/update';
        $this->edit_url             = 'admin/administrator/edit/';
        $this->del_url              = 'admin/administrator/del/';
        $this->ajax_url             = 'admin/administrator/grid';
        $this->batch_url            = 'admin/administrator/batch';
	}


	/*
    |-------------------------------------------------------------------------------
    |
    |  初始化tableData 输出初始的商品列表dom元素
    |  设置 数据表   					table ---- goods
    |  设置排序方式  					orderBy('id','desc')
    |  设置等于搜索
    |
    |  brand_id  					品牌
    |  is_new    					新品
    |  is_best   					精品
    |  is_hot    					热卖
    |  is_on_sale 					上架
    |
    |  设置关键字搜索  				商品名称 goods_name
    |  where('goods_name','like',''.$goods_name.'')
    |
    |  设置whereIn操作
    |  whereIn('cat_id',[1,2,3,4,5])
    |  系统会根据以上条件拼接sql查询 把最终结果返回给grid类来处理
    |
    |-------------------------------------------------------------------------------
    */
    public function tableDataInit(){


        $tableData                  = new TableData();

        //设置参数
        $tableData->put('table','admins');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        //$tableData->addField('is_admin',1);

        //设置搜索关键字
        $tableData->keywords('username','');
        $tableData->keywords('email','');
        $tableData->keywords('phone','');

        //设置whereIn搜索
        //$tableData->whereIn('cat_id',[]);


        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //给page设置参数
         $current_page           = 1;
         $per_page               = 20;
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);


        return $tableData;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   设置数据表中需要显示的所有数据字段 并根据需求格式化数据内容
    |
    |-------------------------------------------------------------------------------
    */
    public function setTableDataCol(TableData $tableData){

        //设置数据表格每列显示的字段名称
        $tableData->addCol('id','id','编号','100px');
        $tableData->addCol('username','username','管理员名称','200px');
        $tableData->addCol('role_id','role_name','管理员角色','');
        $tableData->addCol('email','email','电子邮件','');
        $tableData->addCol('phone','phone','手机号码','');
        $tableData->addCol('sort_order','sort_order','排序','');

        return $tableData;

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

            $model                                  = Admin::find($value['id']);             
            $data[$key]['role_name']                = $model->role_name_string();
            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/administrator',$value['id']);
            $data[$key]['del_url']                  = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']              = '';
        }

        return $data;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据返回的json格式的数据  格式化相关数据
    |
    |-------------------------------------------------------------------------------
    */
    public function getTableData($info){


        $tableData                  = new TableData();

        $sort_name                  = $info->sort_name;
        $sort_value                 = $info->sort_value;
        $current_page               = $info->page;
        $per_page                   = $info->per_page;

        $fieldRow                   = $info->fieldRow;
        $keywords                   = $info->keywords;
        $whereIn                    = $info->whereIn;


        //设置参数
        $tableData->put('table','admins');
        $tableData->put('sort_name',$sort_name);
        $tableData->put('sort_value',$sort_value);

        //设置关键词
        if($keywords){

            foreach($keywords as $key=>$value){

                $tableData->keywords($key , $value);
            }
        }

        //设置fieldRow 等于搜索
        if($fieldRow){

            foreach($fieldRow as $key=>$value){

                $tableData->addField($key , $value);
            }
        }

        //设置whereIn搜索
				/*
        if($whereIn){

             $in_field              = $whereIn->in_field;
             $in_value              = $whereIn->in_value;

             //这里为商品分类  获取该分类下所有子类
             $row                   = Common::get_child_row($in_value);

             $tableData->whereIn($in_field,$row);
        }
				*/

        //设置数据表格每列显示的字段名称
        $tableData              = $this->setTableDataCol($tableData);

         //设置分页参数信息
         $total                  = intval($tableData->total());
         $last_page              = ceil($total / $per_page);
         $tableData->page('current_page',$current_page);
         $tableData->page('per_page',$per_page);
         $tableData->page('total',$total);
         $tableData->page('last_page',$last_page);

         //获取个性化后的数据
         $data                   = $this->getData($tableData->toArray());
         $tableData->put('data',$data);

         return $tableData;
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
                        'name'          => '管理员名称',
                        'value'         => '',
                        'id'            => 'username',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'email',
                        'name'          => '电子邮件',
                        'value'         => '',
                        'id'            => 'email',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'phone',
                        'name'          => '手机号码',
                        'value'         => '',
                        'id'            => 'phone',
                    ],
                    
                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url'			=> url('admin/administrator'),
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
                                    ['field'=>'email','value'=>''],
                                    ['field'=>'phone','value'=>'']
                    ],

                    'fieldRow'=>[
                                  

                    ],

                    'whereIn'=>[ ],
        ];


        return  json_encode($row,JSON_UNESCAPED_UNICODE);
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
                        'field'         => 'username',
                        'name'          => '管理员名称',
                        'value'         => '',
                        'id'            => 'username',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'email',
                        'name'          => '电子邮件',
                        'value'         => '',
                        'id'            => 'email',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'phone',
                        'name'          => '管理员手机',
                        'value'         => '',
                        'id'            => 'phone',
                    ],

                    [
                        'type'          => 'password',
                        'field'         => 'password',
                        'name'          => '密码',
                        'value'         => '',
                        'id'            => 'password',
                    ],

                    [
                        'type'          => 'password_confirmation',
                        'field'         => 'password_confirmation',
                        'name'          => '确认密码',
                        'value'         => '',
                        'id'            => 'password_confirmation',
                    ],

                    [
                        'type'          =>'file',
                        'field'          =>'user_icon',
                        'name'          =>'用户头像',
                        'upload_img'    =>'',
                        'file_info'     =>'',
                        'id'            =>'user_icon'
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否激活',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 1,
                        'id'            => 'is_show',
                    ],

                    [
                        'type'          => 'insert',
                        'field'         => 'add_time',
                        'value'         => time(),
                    ],

                     [
                        'type'          => 'insert',
                        'field'         => 'login_ip',
                        'value'         =>  Request::getClientIp(),
                     ],


                    //多选角色
                    [
                        'type'          => 'checkbox',
                        'field'         => 'role_ids[]',
                        'field2'        => 'role_id',
                        'name'          => '角色选择',
                        'checkbox_row'  => $this->get_role_checkbox_list(),
                        'checked_row'   => [],
                        'id'            => 'role_id',
                    ],


                     [
                        'type'          => 'insert',
                        'field'         => 'is_admin',
                        'value'         =>  1,
                     ],

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
    | 返回系统表单字段的配置文件数组
    |
    |-------------------------------------------------------------------------------
    */

    public function EditData($model){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'username',
                        'name'          => '管理员名称',
                        'value'         => $model->username,
                        'id'            => 'username',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'email',
                        'name'          => '电子邮件',
                        'value'         => $model->email,
                        'id'            => 'email',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'phone',
                        'name'          => '管理员手机',
                        'value'         => $model->phone,
                        'id'            => 'phone',
                    ],

                    [
                        'type'          =>'file',
                        'field'         =>'user_icon',
                        'name'          =>'用户头像',
                        'upload_img'    =>$model->user_icon,
                        'file_info'     =>'',
                        'id'            =>'user_icon'
                    ],

                    [
                        'type'          => 'password',
                        'field'         => 'password',
                        'name'          => '密码',
                        'value'         => '',
                        'id'            => 'password',
                    ],

                    //多选角色
                    [
                        'type'          => 'checkbox',
                        'field'         => 'role_ids[]',
                        'field2'        => 'role_id',
                        'name'          => '角色选择',
                        'checkbox_row'  => $this->get_role_checkbox_list(),
                        'checked_row'   => $this->role_checkbox_checked_list($model),
                        'id'            => 'role_id',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否激活',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->is_show,
                        'id'            => 'is_show',
                    ],



                     [
                        'type'          => 'insert',
                        'field'         => 'login_ip',
                        'value'         =>  Request::getClientIp(),
                     ],

                    [
                        'type'          => 'hidden',
                        'field'         => 'id',
                        'value'         =>  $model->id,
                        'id'            => 'id'
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
                        'back_url'      => url('admin/administrator'),
                    ],
        ];

    }


    /*
    |-----------------------------------------------------------------------
    |
    | 返回系统的下拉菜单选项
    |
    |-----------------------------------------------------------------------
    */
    public function get_select_option_list(){

         $role          = Role::take(300)->get();
         $str           = '';

         foreach($role as $item){

             $str .='<option value="'.$item->id.'">'.$item->role_name.'</option>';
         }

         return $str;
    }

    /*
    |-----------------------------------------------------------------------
    |
    | 返回系统的下拉菜单选项
    |
    |-----------------------------------------------------------------------
    */

    public function get_radio(){

        return [

                ['name'=>'不显示','value'=>0],
                ['name'=>'显示','value'=>1],

        ];
    }




    /*
    |-----------------------------------------------------------------------
    |
    | 获取角色的名字
    |
    |-----------------------------------------------------------------------
    */
    public function get_role_name($role_id){


        if($role_id == 0){

            return '';
        }

        $role           = Role::find($role_id);

        if(empty($role)){

            return '请选择角色';
        }

        return $role->role_name;
    }


    /*
    |-----------------------------------------------------------------------
    |
    | 删除用户头像文件
    |
    |-----------------------------------------------------------------------
    */
    public function delete($img){


        if($img){

            @unlink(public_path().'/'.$img);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取多选按钮的数组值
    |
    |-------------------------------------------------------------------------------
    */
    public function get_role_checkbox_list(){


        $role_list              = Role::all();
        $row                    = [];

        if(empty($role_list)){

             return $row;
        }

        foreach($role_list as $key=>$role){

            $row[$key]['name']      = $role->role_name;
            $row[$key]['value']     = $role->id;
        }

            return $row;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取选中的多选项
    |
    |-------------------------------------------------------------------------------
    */
    public function role_checkbox_checked_list($model){

        $row                = [];

        foreach($model->role()->get() as $role){

            $row[]          = $role->id;     
        }

        return $row;
    }
    



}
