<?php namespace Phpstore\Category;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;

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
        $this->list_url             = 'admin/category';
        $this->edit_url             = 'admin/category/edit/';
        $this->add_url              = 'admin/category/add';
        $this->update_url           = 'admin/category/update';
        $this->del_url              = 'admin/category/del/';
        $this->batch_url            = 'admin/category/batch';
        $this->preview_url          = 'category/';
        $this->ajax_url             = 'admin/category/grid';



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
        $tableData->put('table','category');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组


        //设置搜索关键字
        $tableData->keywords('cat_name','');

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
        $tableData->addCol('cat_name','cat_name','分类名称','200px');
        $tableData->addCol('cat_img','cat_img_str','分类图标','');
        $tableData->addCol('id','goods_num','商品数量','');
        $tableData->addCol('parent_id','parent_name','上级分类','');
        $tableData->addCol('left','left','左侧索引','');
        $tableData->addCol('right','right','右侧索引','');
        $tableData->addCol('depth','depth','深度','');
        $tableData->addCol('is_show','is_show_str','是否显示','');
        $tableData->addCol('grade','grade','价格分级','');
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

            //alias赋值
            $data[$key]['cat_img_str']              = Common::image($value['cat_img']);
            $data[$key]['is_show_str']              = Common::get_tag_status($value['is_show']);
            $data[$key]['parent_name']              = Common::get_cat_name($value['parent_id']);
            $data[$key]['goods_num']                = Common::get_goods_num($value['id']);

            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/category',$value['id']);
            $data[$key]['del_url']                  = Common::get_del_url($this->del_url,$value['id']);
            $data[$key]['preview_url']              = Common::get_preview_url($this->preview_url,$value['id'],'category');

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
        $tableData->put('table','category');
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
                        'field'         => 'cat_name',
                        'name'          => '分类名称',
                        'value'         => '',
                        'id'            => 'cat_name',
                    ],

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url'			=> url($this->list_url),
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
                                    ['field'=>'cat_name','value'=>'']
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
                        'field'         => 'cat_name',
                        'name'          => '分类名称',
                        'value'         => '',
                        'id'            => 'cat_name',
                    ],



                    [
                        'type'          => 'select',
                        'field'         => 'parent_id',
                        'name'          => '上级分类',
                        'option_list'   =>  Category::cat_select(),
                        'selected_name' => '请选择分类',
                        'selected_value'=> 0,
                        'id'            => 'parent_id',
                    ],


                    [
                        'type'          => 'text',
                        'field'         => 'measure_unit',
                        'name'          => '数量单位',
                        'value'         => '',
                        'id'            => 'measure_unit',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => '',
                        'id'            => 'sort_order',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'cat_template',
                        'name'          => '分类模板',
                        'value'         => '',
                        'id'            => 'cat_template',
                    ],
                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => 1,
                        'id'            => 'is_show',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_nav',
                        'name'          => '是否显示在导航栏',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => 1,
                        'id'            => 'is_nav',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'grade',
                        'name'          => '价格区间',
                        'value'         => '',
                        'id'            => 'grade',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'keywords',
                        'name'          => '关键词',
                        'value'         => '',
                        'id'            => 'keywords',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => '',
                        'id'            => 'diy_url',
                    ],

                     [
                        'type'          => 'textarea',
                        'field'         => 'cat_desc',
                        'name'          => '分类描述',
                        'value'         => '',
                        'id'            => 'cat_desc',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'cat_img',
                        'name'          => '分类图标',
                        'file_info'     => '',
                        'id'            => 'cat_img',
                        'upload_img'    => ''
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
                        'field'         => 'cat_name',
                        'name'          => '分类名称',
                        'value'         => $model->cat_name,
                        'id'            => 'cat_name',
                    ],



                    [
                        'type'          => 'select',
                        'field'         => 'parent_id',
                        'name'          => '上级分类',
                        'option_list'   => Category::cat_select(),
                        'selected_name' => $model->father(),
                        'selected_value'=> $model->parent_id,
                        'id'            => 'parent_id',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'measure_unit',
                        'name'          => '数量单位',
                        'value'         => $model->measure_unit,
                        'id'            => 'measure_unit',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => $model->sort_order,
                        'id'            => 'sort_order',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'cat_template',
                        'name'          => '分类模板',
                        'value'         => $model->cat_tp,
                        'id'            => 'cat_template',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => $model->is_show,
                        'id'            => 'is_show',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_nav',
                        'name'          => '是否显示在导航栏',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => $model->is_nav,
                        'id'            => 'is_nav',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'grade',
                        'name'          => '价格区间',
                        'value'         => $model->grade,
                        'id'            => 'grade',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'keywords',
                        'name'          => '关键词',
                        'value'         => $model->keywords,
                        'id'            => 'keywords',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'diy_url',
                        'name'          => '自定义链接',
                        'value'         => $model->diy_url,
                        'id'            => 'diy_url',
                    ],

                     [
                        'type'          => 'textarea',
                        'field'         => 'cat_desc',
                        'name'          => '分类描述',
                        'value'         => $model->cat_desc,
                        'id'            => 'cat_desc',
                    ],

                    [
                        'type'          => 'file',
                        'field'         => 'cat_img',
                        'name'          => '分类图标',
                        'file_info'     => '',
                        'id'            => 'cat_img',
                        'upload_img'    => $model->cat_img
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
    public function delete_cat_image($id){

        $model              = Category::find($id);

        if(empty($model)){

            return ;
        }


        $cat_img          = $model->cat_img;

        if($cat_img){

            @unlink(public_path().'/'.$cat_img);
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

            $model                  = Category::find($id);
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

            $model                  = Category::find($id);
            $this->delete_cat_image($id);
            $model->delete();
        }
    }



}
