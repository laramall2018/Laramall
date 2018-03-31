<?php namespace Phpstore\ArticleCat;

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
use App\Models\Article;
use App\Models\ArticleCat;

/*
|-------------------------------------------------------------------------------
|
|   商品控制器里面的grid相应操作函数
|
|-------------------------------------------------------------------------------
|
|   tableDataInit  	    --------------- 初始化tableData实例 并赋值给grid实例
|   setTableDataCol		  --------------- 设置tabledata实例需要显示的数据库字段
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
        $this->list_url             = 'admin/article_cat';
        $this->batch_url            = 'admin/article_cat/batch';
        $this->ajax_url             = 'admin/article_cat/grid';
	    $this->del_url 				= 'admin/article_cat/del/';
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
        $tableData->put('table','article_cat');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        //$tableData->addField('brand_id','');

        //设置搜索关键字
        $tableData->keywords('title','');

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
        $tableData->addCol('parent_id','parent','上一级分类','');
        $tableData->addCol('is_help','is_help_str','帮助中心','');
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

           $data[$key]['parent']             	    = Common::get_article_cat_name($value['parent_id']);
           $data[$key]['is_help_str']               = $this->get_help_str($value['is_help']);
            //操作链接
            $data[$key]['edit_url']                 = Common::get_resource_edit_url('admin/article_cat',$value['id']);
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
        $tableData->put('table','article_cat');
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
                        'field'         => 'cat_name',
                        'name'          => '分类名称',
                        'value'         => '',
                        'id'            => 'cat_name',
                    ],

                    [
                        'type'          => 'button',
                        'name'          => '搜索',
                        'id'            => 'search-btn',
						'back_url'		=> url('admin/article_cat'),
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
                        'field'         => 'cat_name',
                        'name'          => '分类名称',
                        'value'         => '',
                        'id'            => 'cat_name',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'parent_id',
                        'name'          => '父亲结点',
                        'option_list'   => $this->get_option_list(),
                        'selected_name' => '顶级分类',
                        'selected_value'=> 0,
                        'id'            => 'parent_id',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => 1,
                        'id'            => 'is_show',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_help',
                        'name'          => '是否是帮助中心',
                        'radio_row'     => $this->get_help_radio(),
                        'checked'       => 0,
                        'id'            => 'is_help',
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
                        'field'         => 'cat_pic',
                        'name'          => '分类图标',
                        'value'         => '',
                        'file_info'     => '',
                        'upload_img'    =>'',
                        'id'            => 'cat_pic',
                    ],



                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url)
                    ],
        ];

    }



		/*
    |-------------------------------------------------------------------------------
    |
    |  获取编辑表单的配置文件
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
                        'name'          => '父亲结点',
                        'option_list'   => $this->get_option_list(),
                        'selected_name' => $this->get_cat_name($model->parent_id),
                        'selected_value'=> $model->parent_id,
                        'id'            => 'parent_id',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => $this->get_radio(),
                        'checked'       => $model->is_show,
                        'id'            => 'is_show',
                    ],
                    [
                        'type'          => 'radio',
                        'field'         => 'is_help',
                        'name'          => '是否是帮助中心',
                        'radio_row'     => $this->get_help_radio(),
                        'checked'       => $model->is_help,
                        'id'            => 'is_help',
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
                        'field'         => 'cat_pic',
                        'name'          => '分类图标',
                        'value'         => '',
                        'file_info'     => '如果不更新可以不用上传',
                        'upload_img'    => $model->icon(),
                        'id'            => 'cat_pic',
                    ],

                    [
                        'type'          => 'hidden',
                        'field'         => 'id',
                        'name'          => '分类名称',
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
                        'value'         => '确认修改',
                        'id'            => 'cat-submit',
                        'back_url'      => url($this->list_url)
                    ],


        ];
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取系统下拉选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_option_list(){

        $article_cat_list           = ArticleCat::all();

        $str                        = '<option value="0">顶级分类</option>';

        foreach($article_cat_list as $item){

            $str .= '<option value="'.$item->id.'">'.$item->cat_name.'</option>';
        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回系统的下拉菜单选项
    |
    |-------------------------------------------------------------------------------
    */
    public function get_radio(){

        return [

                ['name'=>'不显示','value'=>0],
                ['name'=>'显示','value'=>1],

        ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 帮助标签的选择
    |
    |-------------------------------------------------------------------------------
    */
    public function get_help_radio(){

        return [

                ['name'=>'不是','value'=>0],
                ['name'=>'是','value'=>1],

        ];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  获取分类名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_cat_name($cat_id){

        $cat        = ArticleCat::find($cat_id);

        if($cat){

            return $cat->cat_name;
        }

        return '';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取帮助中心
    |
    |-------------------------------------------------------------------------------
    */
    public function get_help_str($is_help){

            $row        = ['不是','是'];
            $is_help    = intval($is_help);

            if(in_array($is_help,[0,1])){

                return $row[$is_help];
            }

            return $row[0];
    }


}
