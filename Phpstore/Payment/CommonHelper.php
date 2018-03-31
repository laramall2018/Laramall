<?php namespace Phpstore\Payment;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Nav;
use App\Models\Payment;

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
        $this->list_url             = 'admin/payment';
        $this->edit_url             = 'admin/payment/edit/';
        $this->add_url              = 'admin/payment/add';
        $this->update_url           = 'admin/payment/update';
        $this->del_url              = 'admin/payment/delete/';
        $this->batch_url            = 'admin/payment/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/payment/grid';


		
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
        $tableData->put('table','payment');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        

        //设置搜索关键字
        $tableData->keywords('pay_name','');

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
        $tableData->addCol('pay_name','pay_name','支付名称','');
        $tableData->addCol('pay_code','pay_code','支付代码','');
        $tableData->addCol('pay_fee','pay_fee','支付手续费','');
        $tableData->addCol('pay_desc','pay_desc','支付描述','');
        $tableData->addCol('tag','tag_str','支付接口状态','');
        $tableData->addCol('pid','pid','支付身份编号','');
        $tableData->addCol('pkey','pkey','支付秘钥','');
        $tableData->addCol('account','account','收款账号','');
        $tableData->addCol('sort_order','sort_order','支付排序','');

        

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

            //alias赋值
          
          
            
            $data[$key]['tag_str']                  = Common::get_tag_status($value['tag']);
            
            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url($this->list_url,$value['id']);
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
        $tableData->put('table','payment');
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
                        'field'         => 'pay_name',
                        'name'          => '支付名称',
                        'value'         => '',
                        'id'            => 'pay_name',
                    ],

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
                        'back_url'      =>url($this->list_url),
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
                                    ['field'=>'pay_name','value'=>'']
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
                        'type'          => 'text',
                        'field'         => 'pay_name',
                        'name'          => '支付名称',
                        'value'         => '',
                        'id'            => 'pay_name',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'pay_code',
                        'name'          => '支付代码',
                        'value'         => '',
                        'id'            => 'pay_code',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'pay_desc',
                        'name'          => '支付描述',
                        'value'         => '',
                        'id'            => 'pay_desc',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'tag',
                        'name'          => '是否激活',
                        'option_list'   => Common::get_common_option_list(),
                        'selected_name' => '请选择',
                        'selected_value'=> 0,
                        'id'            => 'tag',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'pid',
                        'name'          => '身份编号',
                        'value'         => '',
                        'id'            => 'pid',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'pkey',
                        'name'          => '支付秘钥',
                        'value'         => '',
                        'id'            => 'pkey',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'account',
                        'name'          => '收款账号',
                        'value'         => '',
                        'id'            => 'account',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '支付排序',
                        'value'         => '',
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

                    [
                        'type'          => 'text',
                        'field'         => 'pay_name',
                        'name'          => '支付名称',
                        'value'         => $model->pay_name,
                        'id'            => 'pay_name',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'pay_code',
                        'name'          => '支付代码',
                        'value'         => $model->pay_code,
                        'id'            => 'pay_code',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'pay_desc',
                        'name'          => '支付描述',
                        'value'         => $model->pay_desc,
                        'id'            => 'pay_desc',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'tag',
                        'name'          => '是否激活',
                        'option_list'   => Common::get_common_option_list(),
                        'selected_name' => Common::get_tag_value($model->tag),
                        'selected_value'=> $model->tag,
                        'id'            => 'tag',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'pid',
                        'name'          => '身份编号',
                        'value'         => $model->pid,
                        'id'            => 'pid',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'pkey',
                        'name'          => '支付秘钥',
                        'value'         => $model->pkey,
                        'id'            => 'pkey',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'account',
                        'name'          => '收款账号',
                        'value'         => $model->account,
                        'id'            => 'account',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '支付排序',
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
    | 删除商品的图片
    |
    |-------------------------------------------------------------------------------
    */
    public function delete_image($id){

        $model              = Image::find($id);

        if(empty($model)){

            return ;
        }

        
        $img_src          = $model->img_src;

        if($img_src){

            @unlink(public_path().'/'.$img_src);
        }
    }



    


    /*
    |-------------------------------------------------------------------------------
    |
    | 批量删除操作
    |
    |-------------------------------------------------------------------------------
    */
    public function deleteAction($ids){

        foreach($ids as $id){

            $model                  = Payment::find($id);
            $model->delete();
        }
    }



}