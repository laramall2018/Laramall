<?php namespace Phpstore\User;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\UserRank;
use App\User;
use DB;


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
    $this->list_url             = 'admin/user';
    $this->edit_url             = 'admin/user/edit';
    $this->add_url              = 'admin/user/create';
    $this->update_url           = 'admin/user/update';
    $this->del_url              = 'admin/user/del/';
    $this->batch_url            = 'admin/user/batch';
    $this->ajax_url             = 'admin/user/grid';


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
        $tableData->put('table','users');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        //$tableData->addField('is_admin',0);

        //设置搜索关键字
        $tableData->keywords('username','');

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
        $tableData->addCol('user_icon','user_icon_str','会员头像','200px');
        $tableData->addCol('username','username','会员名称','200px');
        $tableData->addCol('email','email','电子邮件','');
        $tableData->addCol('phone','phone','手机','200px');
        $tableData->addcol('pay_points','pay_points','消费积分','');
        $tableData->addcol('rank_points','rank_points','等级积分','');
		$tableData->addCol('rank_id','rank_name','会员等级','');
        $tableData->addCol('add_time','add_time_at','注册时间','');

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

            $model                                  = User::find($value['id']);
            //alias赋值
            $data[$key]['user_icon_str']            = Common::image($model->icon());
			$data[$key]['rank_name'] 				= ($model->rank)? $model->rank->rank_name : '';
            $data[$key]['add_time_at']              = $model->add_time();
            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/user',$value['id']);
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
        $tableData->put('table','users');
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
                        'name'          => '会员名称',
                        'value'         => '',
                        'id'            => 'username',
                    ],

                    
                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url'	    => url('admin/user'),
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
                                    ['field'=>'username','value'=>'']
                    ],

                    'fieldRow'=>[],

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
                        'type'          => 'text',
                        'field'         => 'username',
                        'name'          => '会员名称',
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
                        'type'          => 'text',
                        'field'         => 'nickname',
                        'name'          => '昵称',
                        'value'         => '',
                        'id'            => 'nickname',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'sex',
                        'name'          => '性别',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> 0 ,
                        'id'            => 'sex',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sfz',
                        'name'          => '身份证号',
                        'value'         => '',
                        'id'            => 'sfz',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'birthday',
                        'name'          => '生日',
                        'value'         => '',
                        'id'            => 'birthday',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'pay_points',
                        'name'          => '消费积分',
                        'value'         => 0,
                        'id'            => 'pay_points',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'rank_points',
                        'name'          => '等级积分',
                        'value'         => 0,
                        'id'            => 'rank_points',
                    ],

                    [
                        'type'          => 'password',
                        'field'         => 'password',
                        'name'          => '密码',
                        'value'         => '',
                        'id'            => 'password',
                    ],

                    [
                        'type'          => 'hidden',
                        'field'         => 'is_admin',
                        'name'          => '普通会员',
                        'value'         => 0,
                        'id'            => 'is_admin',
                    ],


                    [
                        'type'          => 'file',
                        'field'         => 'user_icon',
                        'name'          => '会员头像',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'user_icon',
                    ],


                    [
                        'type'          => 'select',
                        'field'         => 'rank_id',
                        'name'          => '会员等级',
                        'option_list'   => $this->get_rank_select_option_list(),
                        'selected_name' =>'请选择',
                        'selected_value'=> 0 ,
                        'id'            => 'rank_id',
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url('admin/user'),
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
                        'type'          => 'text',
                        'field'         => 'username',
                        'name'          => '会员名称',
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
                        'name'          => '手机号码',
                        'value'         => $model->phone,
                        'id'            => 'phone',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'nickname',
                        'name'          => '昵称',
                        'value'         => $model->nickname,
                        'id'            => 'nickname',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'sex',
                        'name'          => '性别',
                        'option_list'   => $this->get_select_option_list(),
                        'selected_name' => $this->get_sex_name($model->sex),
                        'selected_value'=> $model->sex ,
                        'id'            => 'sex',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sfz',
                        'name'          => '身份证号',
                        'value'         => $model->sfz,
                        'id'            => 'sfz',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'birthday',
                        'name'          => '生日',
                        'value'         => $model->birthday,
                        'id'            => 'birthday',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'pay_points',
                        'name'          => '消费积分',
                        'value'         => $model->pay_points,
                        'id'            => 'pay_points',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'rank_points',
                        'name'          => '等级积分',
                        'value'         => $model->rank_points,
                        'id'            => 'rank_points',
                    ], 

                    [
                        'type'          => 'password',
                        'field'         => 'password',
                        'name'          => '密码',
                        'value'         => '',
                        'id'            => 'password',
                    ],

                    [
                        'type'          => 'hidden',
                        'field'         => 'is_admin',
                        'name'          => '普通会员',
                        'value'         => 0,
                        'id'            => 'is_admin',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'user_icon',
                        'name'          => '会员头像',
                        'value'         => $model->icon(),
                        'file_info'     => '',
                        'upload_img'    => $model->icon(),
                        'id'            => 'user_icon',
                    ],


                    [
                        'type'          => 'select',
                        'field'         => 'rank_id',
                        'name'          => '会员等级',
                        'option_list'   => $this->get_rank_select_option_list(),
                        'selected_name' => Common::get_rank_name($model->rank_id),
                        'selected_value'=> $model->rank_id ,
                        'id'            => 'rank_id',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'ip',
                        'name'          => '注册ip地址',
                        'value'         => $model->ip,
                        'id'            => 'ip',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'login_ip',
                        'name'          => '上次登录ip地址',
                        'value'         => $model->login_ip,
                        'id'            => 'login_ip',
                    ],


                  [
                      'type'          => 'hidden',
                      'field'         => 'id',
                      'name'          => '编号',
                      'value'         => $model->id,
                      'id'            => 'id',
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
    | 删除商品的图片
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_user_image($id){

        $model              = User::find($id);

        if(empty($model)){

            return ;
        }


        $user_icon          = $model->user_icon;

        if($user_icon){

            @unlink(public_path().'/'.$user_icon);
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 性别选择下拉
    |
    |-------------------------------------------------------------------------------
    */
    public function get_select_option_list(){

          return  '<option value="1">男</option>'
                 .'<option value="2">女</option>';
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 获取会员等级下拉列表
    |
    |-------------------------------------------------------------------------------
    */
    public function get_rank_select_option_list(){

         $res       = DB::table('user_rank')->get();
         $str       = '';

         if($res){

             foreach($res as $item){

                $str .='<option value="'.$item->id.'">'.$item->rank_name.'</option>';

             }
         }

         return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取性别名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_sex_name($sex){


       $sex_arr     = ['保密','男','女'];

       if(in_array($sex,[0,1,2])){

          return $sex_arr[$sex];
       }


       return $sex_arr[0];


    }

}
