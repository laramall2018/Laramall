<?php namespace Phpstore\Role;

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
        $this->list_url             = 'admin/role';
        $this->edit_url             = 'admin/role/edit/';
        $this->add_url              = 'admin/role/create';
        $this->update_url           = 'admin/role/update';
        $this->del_url              = 'admin/role/del/';
        $this->batch_url            = 'admin/role/batch';
        $this->ajax_url             = 'admin/role/grid';
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
        $tableData->put('table','role');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        //$tableData->addField('brand_id','');

        //设置搜索关键字
        $tableData->keywords('role_name','');

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
        $tableData->addCol('role_name','role_name','角色名称','200px');
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



            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/role',$value['id']);
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
        $tableData->put('table','role');
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
                        'field'         => 'role_name',
                        'name'          => '角色名称',
                        'value'         => '',
                        'id'            => 'role_name',
                    ],

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
												'back_url'			=> url('admin/role'),
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
                                    ['field'=>'role_name','value'=>'']
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
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function FormData(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'goods_name',
                        'name'          => '商品名称',
                        'value'         => '',
                        'id'            => 'goods_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_sn',
                        'name'          => '商品货号',
                        'value'         => '',
                        'id'            => 'goods_sn',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_number',
                        'name'          => '商品库存',
                        'value'         => '',
                        'id'            => 'goods_number',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   => Goodslib::cat_list(0, 0, true, 0,true),
                        'selected_name' => '请选择分类',
                        'selected_value'=> 0,
                        'id'            => 'cat_id',
                    ],


                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Common::get_brand_option_list(),
                        'selected_name' => '请选择商品品牌',
                        'selected_value'=> 0,
                        'id'            => 'brand_id',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'shop_price',
                        'name'          => '商品售价',
                        'value'         => '',
                        'id'            => 'shop_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'market_price',
                        'name'          => '市场价格',
                        'value'         => '',
                        'id'            => 'market_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'refe_price',
                        'name'          => '参考价格',
                        'value'         => '',
                        'id'            => 'refe_price',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'give_integral',
                        'name'          => '消费积分',
                        'value'         => '',
                        'id'            => 'give_integral',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => '',
                        'id'            => 'diy_url',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_thumb',
                        'name'          => '商品缩略图',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'goods_thumb',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_img',
                        'name'          => '商品大图',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'goods_img',
                    ],

                    [
                        'type'          => 'ueditor',
                        'field'         => 'goods_desc',
                        'name'          => '详情描述',
                        'value'         => '',
                        'id'            => 'editor',
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
                        'field'         => 'goods_name',
                        'name'          => '商品名称',
                        'value'         => $model->goods_name,
                        'id'            => 'goods_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_sn',
                        'name'          => '商品货号',
                        'value'         => $model->goods_sn,
                        'id'            => 'goods_sn',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_number',
                        'name'          => '商品库存',
                        'value'         => $model->goods_number,
                        'id'            => 'goods_number',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '新闻分类',
                        'option_list'   => Goodslib::cat_list(0, 0, true, 0,true),
                        'selected_name' => Common::get_cat_name($model->cat_id),
                        'selected_value'=> $model->cat_id,
                        'id'            => 'cat_id',
                    ],


                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Common::get_brand_option_list(),
                        'selected_name' => Common::get_brand_name($model->brand_id),
                        'selected_value'=> $model->brand_id,
                        'id'            => 'brand_id',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'shop_price',
                        'name'          => '商品售价',
                        'value'         => $model->shop_price,
                        'id'            => 'shop_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'market_price',
                        'name'          => '市场价格',
                        'value'         => $model->market_price,
                        'id'            => 'market_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'refe_price',
                        'name'          => '参考价格',
                        'value'         => $model->refe_price,
                        'id'            => 'refe_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'give_integral',
                        'name'          => '消费积分',
                        'value'         => $model->give_integral,
                        'id'            => 'give_integral',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => $model->diy_url,
                        'id'            => 'diy_url',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_thumb',
                        'name'          => '商品缩略图',
                        'value'         => $model->goods_thumb,
                        'file_info'     => '',
                        'upload_img'    => $model->goods_thumb,
                        'id'            => 'goods_thumb',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_img',
                        'name'          => '商品大图',
                        'value'         => $model->goods_img,
                        'file_info'     => '',
                        'upload_img'    => $model->goods_img,
                        'id'            => 'goods_img',
                    ],

                    [
                        'type'          => 'ueditor',
                        'field'         => 'goods_desc',
                        'name'          => '详情描述',
                        'value'         => $model->goods_desc,
                        'id'            => 'editor',
                    ],

                    [
                        'type'          => 'hidden',
                        'field'         => 'id',
                        'name'          => '商品编号',
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
                        'value'         => '确认添加',
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
    public function delete_goods_image($id){

        $model              = Goods::find($id);

        if(empty($model)){

            return ;
        }

        $goods_thumb        = $model->goods_thumb;
        $goods_img          = $model->goods_img;

        if($goods_thumb){

            @unlink(public_path().'/'.$goods_thumb);
        }

        if($goods_img){

            @unlink(public_path().'/'.$goods_img);
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 批量回收站操作
    |
    |-------------------------------------------------------------------------------
    */
    public function softdelAction($ids){

        foreach($ids as $id){

            $model                  = Goods::find($id);
            $model->is_delete       = 1;
            $model->save();
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

            $model                  = Goods::find($id);
            $this->delete_goods_image($id);
            $model->delete();
        }
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回第一次设置 TableData需要的参数
    |
    |-------------------------------------------------------------------------------
    */
    public function getInfo(){

        $row                        = [];
        $row['sort_name']           = 'id';
        $row['sort_value']          = 'desc';
        $row['keywords']            = ['goods_name'=>''];
        $row['fieldRow']            = ['is_best'=>'','is_new'=>'','is_hot'=>'','is_on_sale'=>'','brand_id'=>0];
        $row['page']                = 1;
        $row['per_page']            = 20;

        $whereIn                    = ['in_field'=>'cat_id','in_value'=>[]];
        $row['whereIn']             = (object)$whereIn;


        //echo json_encode($row,JSON_UNESCAPED_UNICODE);

        return (object)$row;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回选项卡的title
    |
    |-------------------------------------------------------------------------------
    */
    public function get_tab_title(){

        return [
                    '基本信息',
                    '商品相册',
                    '详情描述',
                    '其他信息',
                    '商品属性',
                    '关联商品',
                    '关联新闻'
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回选项卡的内容部分
    |
    |-------------------------------------------------------------------------------
    */
    public function get_tab_content($row){

        if(empty($row)){

            return '';
        }

        $str            = '';

        foreach($row as $key=>$value){

            if($key == 0 ){

                $cls    = 'ps-tab-content-item cur';
            }
            else{

                $cls    = 'ps-tab-content-item';
            }

            $str .= '<div class="'.$cls.'">'.$value.'</div>';
        }

        return $str;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 确认按钮
    |
    |-------------------------------------------------------------------------------
    */
    public function form_tab_submit(){

        return [

                   [
                        'type'          => 'submit2',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url),
                    ],
        ];
    }
    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function form_tab_1(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'goods_name',
                        'name'          => '商品名称',
                        'value'         => '',
                        'id'            => 'goods_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_sn',
                        'name'          => '商品货号',
                        'value'         => '',
                        'id'            => 'goods_sn',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_number',
                        'name'          => '商品库存',
                        'value'         => '',
                        'id'            => 'goods_number',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   => Goodslib::cat_list(0, 0, true, 0,true),
                        'selected_name' => '请选择分类',
                        'selected_value'=> 0,
                        'id'            => 'cat_id',
                    ],


                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Common::get_brand_option_list(),
                        'selected_name' => '请选择商品品牌',
                        'selected_value'=> 0,
                        'id'            => 'brand_id',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'shop_price',
                        'name'          => '商品售价',
                        'value'         => '',
                        'id'            => 'shop_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'market_price',
                        'name'          => '市场价格',
                        'value'         => '',
                        'id'            => 'market_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'refe_price',
                        'name'          => '参考价格',
                        'value'         => '',
                        'id'            => 'refe_price',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'give_integral',
                        'name'          => '消费积分',
                        'value'         => '',
                        'id'            => 'give_integral',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => '',
                        'id'            => 'diy_url',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_thumb',
                        'name'          => '商品缩略图',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'goods_thumb',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_img',
                        'name'          => '商品大图',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'goods_img',
                    ],


        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 第三个选项卡配置文件
    |
    |-------------------------------------------------------------------------------
    */
    public function form_tab_3(){

        return [

                    [
                        'type'          => 'ueditor_big',
                        'field'         => 'goods_desc',
                        'name'          => '详情描述',
                        'value'         => '',
                        'id'            => 'editor',
                    ],
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 第四个选项卡配置文件
    |
    |-------------------------------------------------------------------------------
    */
    public function form_tab_4(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'goods_weight',
                        'name'          => '商品重量',
                        'value'         => '',
                        'id'            => 'goods_weight',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'warn_number',
                        'name'          => '报警库存',
                        'value'         => '',
                        'id'            => 'warn_number',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_new',
                        'name'          => '是新品',
                        'radio_row'     => Common::get_radio_add_list(),
                        'checked'       => 0,
                        'id'            => 'is_new',
                    ],
                    [
                        'type'          => 'radio',
                        'field'         => 'is_best',
                        'name'          => '是精品',
                        'radio_row'     => Common::get_radio_add_list(),
                        'checked'       => 0,
                        'id'            => 'is_best',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_hot',
                        'name'          => '是热卖',
                        'radio_row'     => Common::get_radio_add_list(),
                        'checked'       => 0,
                        'id'            => 'is_hot',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'keywords',
                        'name'          => '关键词',
                        'value'         => '',
                        'id'            => 'keywords',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_brief',
                        'name'          => '商品简单描述',
                        'value'         => '',
                        'id'            => 'goods_brief',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'seller_note',
                        'name'          => '商家备注',
                        'value'         => '',
                        'id'            => 'seller_note',
                    ],

                    [
                        'type'          => 'checkbox',
                        'field'         => 'site[]',
                        'field2'        => 'site',
                        'name'          => '所属分站',
                        'checkbox_row'  => Common::get_site_checkbox_list(),
                        'checked_row'   => Common::get_site_checked(),
                        'id'            => 'site',
                    ],
        ];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 第五个选项卡配置文件
    |
    |-------------------------------------------------------------------------------
    */
    public function form_tab_5(){

        return [

                    [
                        'type'          => 'goods_attr',
                        'field'         => 'attr_id',
                        'name'          => '商品属性',
                        'option_list'   => Common::get_goods_attr_list(),
                        'selected_name' => '请选择属性',
                        'selected_value'=> 0,
                        'id'            => 'attr_id',
												'value' 				=>'',
                    ],
        ];
    }

		/*
    |-------------------------------------------------------------------------------
    |
    | 获取属性json格式
    |
    |-------------------------------------------------------------------------------
    */
		public function get_attr_list(){

				$attr_list 			=  Attribute::all();
				$row 						= [];

				if(empty($attr_list)){

					  return  json_encode($row,JSON_UNESCAPED_UNICODE);

				}

				foreach($attr_list as $item){

					$row[] 			= [ 'attr_name'=>$item->attr_name,'attr_id'=>$item->id ];
				}

			  return  json_encode($row,JSON_UNESCAPED_UNICODE);

		}


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取商品表单的所有字段
    |
    |-------------------------------------------------------------------------------
    */
    public function get_all_form_data(){

        $row            = [];
        $row1           = $this->form_tab_1();
        $row3           = $this->form_tab_3();
        $row4           = $this->form_tab_4();
        $row5           = $this->form_tab_5();

        foreach([$row1,$row3,$row4,$row5] as $item){

            foreach($item as $value){

                if($value['type'] == 'checkbox'){

                    $row[]      = [

                                    'type'      =>$value['type'],
                                    'field'     =>$value['field'],
                                    'field2'    =>$value['field2'],

                    ];
                }
                else{

                    $row[]       = ['type'=>$value['type'],'field'=>$value['field']];
                }
            }
        }

        //添加商品相册上传功能
        $row[]                  = ['type'=>'goods_gallery','field'=>'goods_gallery'];

        return $row;
    }



    /*=========================== 编辑商品========================================= */

    /*
    |-------------------------------------------------------------------------------
    |
    | 添加商品 生成form表单的配置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function edit_form_tab_1($model){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'goods_name',
                        'name'          => '商品名称',
                        'value'         => $model->goods_name,
                        'id'            => 'goods_name',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_sn',
                        'name'          => '商品货号',
                        'value'         => $model->goods_sn,
                        'id'            => 'goods_sn',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_number',
                        'name'          => '商品库存',
                        'value'         => $model->goods_number,
                        'id'            => 'goods_number',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   => Goodslib::cat_list(0, 0, true, 0,true),
                        'selected_name' => '请选择分类',
                        'selected_value'=> $model->cat_id,
                        'id'            => 'cat_id',
                    ],


                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Common::get_brand_option_list(),
                        'selected_name' => '请选择商品品牌',
                        'selected_value'=> $model->brand_id,
                        'id'            => 'brand_id',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'shop_price',
                        'name'          => '商品售价',
                        'value'         => $model->shop_price,
                        'id'            => 'shop_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'market_price',
                        'name'          => '市场价格',
                        'value'         => $model->market_price,
                        'id'            => 'market_price',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'refe_price',
                        'name'          => '参考价格',
                        'value'         => $model->refe_price,
                        'id'            => 'refe_price',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'give_integral',
                        'name'          => '消费积分',
                        'value'         => $model->give_integral,
                        'id'            => 'give_integral',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => $model->diy_url,
                        'id'            => 'diy_url',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_thumb',
                        'name'          => '商品缩略图',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    => $model->goods_thumb,
                        'id'            => 'goods_thumb',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'goods_img',
                        'name'          => '商品大图',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>$model->goods_img,
                        'id'            => 'goods_img',
                    ],


        ];

    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 第三个选项卡配置文件 编辑
    |
    |-------------------------------------------------------------------------------
    */
    public function edit_form_tab_3($model){

        return [

                    [
                        'type'          => 'ueditor_big',
                        'field'         => 'goods_desc',
                        'name'          => '详情描述',
                        'value'         => $model->goods_desc,
                        'id'            => 'editor',
                    ],
        ];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 第四个选项卡配置文件
    |
    |-------------------------------------------------------------------------------
    */
    public function edit_form_tab_4($model){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'goods_weight',
                        'name'          => '商品重量',
                        'value'         => $model->goods_weight,
                        'id'            => 'goods_weight',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'warn_number',
                        'name'          => '报警库存',
                        'value'         => $model->warn_number,
                        'id'            => 'warn_number',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_new',
                        'name'          => '是新品',
                        'radio_row'     => Common::get_radio_add_list(),
                        'checked'       => $model->is_new,
                        'id'            => 'is_new',
                    ],
                    [
                        'type'          => 'radio',
                        'field'         => 'is_best',
                        'name'          => '是精品',
                        'radio_row'     => Common::get_radio_add_list(),
                        'checked'       => $model->is_best,
                        'id'            => 'is_best',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_hot',
                        'name'          => '是热卖',
                        'radio_row'     => Common::get_radio_add_list(),
                        'checked'       => $model->is_hot,
                        'id'            => 'is_hot',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'keywords',
                        'name'          => '关键词',
                        'value'         => $model->keywords,
                        'id'            => 'keywords',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'goods_brief',
                        'name'          => '商品简单描述',
                        'value'         => $model->goods_brief,
                        'id'            => 'goods_brief',
                    ],

                    [
                        'type'          => 'textarea',
                        'field'         => 'seller_note',
                        'name'          => '商家备注',
                        'value'         => $model->seller_note,
                        'id'            => 'seller_note',
                    ],

                    [
                        'type'          => 'checkbox',
                        'field'         => 'site[]',
                        'field2'        => 'site',
                        'name'          => '所属分站',
                        'checkbox_row'  => Common::get_site_checkbox_list(),
                        'checked_row'   => Common::get_site_checked_edit($model->site),
                        'id'            => 'site',
                    ],
                    [
                        'type'          => 'hidden',
                        'field'         => '_method',
                        'name'          => '表单递交方法',
                        'value'         => 'PUT',
                        'id'            => 'method',
                    ],
                    [
                        'type'          => 'hidden',
                        'field'         => 'id',
                        'name'          => '商品编号',
                        'value'         => $model->id,
                        'id'            => 'id',
                    ],
        ];
    }


		/*
    |-------------------------------------------------------------------------------
    |
    | 第五个选项卡配置文件
    |
    |-------------------------------------------------------------------------------
    */
    public function edit_form_tab_5($model){

        return [

                    [
                        'type'          => 'goods_attr',
                        'field'         => 'attr_id',
                        'name'          => '商品属性',
                        'option_list'   => Common::get_goods_attr_list(),
                        'selected_name' => '请选择属性',
                        'selected_value'=> 0,
                        'id'            => 'attr_id',
												'value' 				=> GoodsAttr::where('goods_id',$model->id)->get(),
                    ],
        ];
    }





}
