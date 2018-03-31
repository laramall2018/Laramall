<?php namespace Phpstore\Nav;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Nav;

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
        $this->list_url             = 'admin/nav';
        $this->edit_url             = 'admin/nav/edit/';
        $this->add_url              = 'admin/nav/create';
        $this->update_url           = 'admin/nav/update';
        $this->del_url              = 'admin/nav/delete/';
        $this->batch_url            = 'admin/nav/batch';
        $this->preview_url          = '';
        $this->ajax_url             = 'admin/nav/grid';


		
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
        $tableData->put('table','nav');
        $tableData->put('sort_name','id');
        $tableData->put('sort_value','desc');

        //设置等于搜索数组
        

        //设置搜索关键字
        $tableData->keywords('nav_name','');

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
        $tableData->addCol('nav_name','nav_name','导航栏名称','');
        $tableData->addCol('nav_type','nav_type_name','导航类型','');
        $tableData->addCol('nav_url','nav_url','导航栏链接','');
        $tableData->addCol('link','link','站外链接','');
        $tableData->addCol('sort_order','sort_order','排序','');
        $tableData->addCol('opennew','opennew_str','新窗口打开','');
        $tableData->addCol('is_show','is_show_str','是否显示','');
        $tableData->addCol('nav_pic','nav_pic_str','导航栏图片','');
        $tableData->addCol('position','position','导航栏位置','');

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
            $model                                  = Nav::find($value['id']);
            $data[$key]['opennew_str']              = Common::get_tag_status($value['opennew']);
            $data[$key]['is_show_str']              = Common::get_tag_status($value['is_show']);
            $data[$key]['nav_pic_str']              = Common::image($model->icon());
            $data[$key]['nav_type_name']            = $this->get_nav_type_name($value['nav_type']);

            
            
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
        $tableData->put('table','nav');
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
                        'field'         => 'nav_name',
                        'name'          => '导航栏名称',
                        'value'         => '',
                        'id'            => 'nav_name',
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
                                    ['field'=>'nav_name','value'=>'']
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
                        'field'         => 'nav_name',
                        'name'          => '导航栏名称',
                        'value'         => '',
                        'id'            => 'nav_name',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   => Category::cat_select(),
                        'selected_name' => '请选择商品分类',
                        'selected_value'=> '',
                        'id'            => 'cat_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Common::get_brand_option_list(),
                        'selected_name' => '请选择商品品牌',
                        'selected_value'=> '',
                        'id'            => 'brand_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'article_id',
                        'name'          => '新闻列表',
                        'option_list'   => Common::get_article_option_list(), 
                        'selected_name' => '请选择新闻列表',
                        'selected_value'=> '',
                        'id'            => 'article_id',
                        'crud_tag'      => 'off',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'nav_url',
                        'name'          => '导航栏链接',
                        'value'         => '',
                        'id'            => 'nav_url',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'link',
                        'name'          => '站外链接',
                        'value'         => '',
                        'id'            => 'link',
                    ],
                    

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => '',
                        'id'            => 'sort_order',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'opennew',
                        'name'          => '新窗口',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => 1,
                        'id'            => 'opennew',
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
                        'type'          => 'select',
                        'field'         => 'position',
                        'name'          => '导航栏位置',
                        'option_list'   => Common::get_nav_position_list(),
                        'selected_name' => '请选择导航栏位置',
                        'selected_value'=> 0,
                        'id'            => 'position',
                    ],
                    
                    [
                        'type'          => 'file',
                        'field'         => 'nav_pic',
                        'name'          => '导航图片',
                        'file_info'     => '',
                        'id'            => 'nav_pic',
                        'upload_img'    => ''
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'base_url',
                        'value'         =>url(''),
                        'id'            =>'base_url',
                        'crud_tag'      => 'off',
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
                        'field'         => 'nav_name',
                        'name'          => '导航栏名称',
                        'value'         => $model->nav_name,
                        'id'            => 'nav_name',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   => Goodslib::cat_list(0,0,true,0,true),
                        'selected_name' => '请选择商品分类',
                        'selected_value'=> '',
                        'id'            => 'cat_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Common::get_brand_option_list(),
                        'selected_name' => '请选择商品品牌',
                        'selected_value'=> '',
                        'id'            => 'brand_id',
                        'crud_tag'      => 'off', //添加crud_tag 则表示该表单只是显示 不插入数据库
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'article_id',
                        'name'          => '新闻列表',
                        'option_list'   => Common::get_article_option_list(), 
                        'selected_name' => '请选择新闻列表',
                        'selected_value'=> '',
                        'id'            => 'article_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'nav_url',
                        'name'          => '导航栏链接',
                        'value'         => $model->nav_url,
                        'id'            => 'nav_url',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'link',
                        'name'          => '站外链接',
                        'value'         => $model->link,
                        'id'            => 'link',
                    ],

                    [
                        'type'          => 'select',
                        'field'         => 'nav_type',
                        'name'          => '导航栏类型',
                        'option_list'   => $this->get_nav_type_list_option(),
                        'selected_name' => $this->get_nav_type_name($model->nav_type),
                        'selected_value'=> $model->nav_type,
                        'id'            => 'nav_type',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => $model->sort_order,
                        'id'            => 'sort_order',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'opennew',
                        'name'          => '新窗口',
                        'radio_row'     => Common::get_radio_show_list(),
                        'checked'       => $model->opennew,
                        'id'            => 'opennew',
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
                        'type'          => 'select',
                        'field'         => 'position',
                        'name'          => '导航栏位置',
                        'option_list'   => Common::get_nav_position_list(),
                        'selected_name' => Common::get_nav_position_name($model->position),
                        'selected_value'=> $model->position,
                        'id'            => 'position',
                    ],
                    
                    [
                        'type'          => 'file',
                        'field'         => 'nav_pic',
                        'name'          => '导航图片',
                        'file_info'     => '',
                        'id'            => 'nav_pic',
                        'upload_img'    => $model->icon(),
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'base_url',
                        'value'         =>url('/'),
                        'id'            =>'base_url'
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
    public function delete_nav_pic($id){

        $model              = Nav::find($id);

        if(empty($model)){

            return ;
        }

        
        $nav_pic          = $model->nav_pic;

        if($nav_pic){

            @unlink(public_path().'/'.$nav_pic);
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

            $model                  = Nav::find($id);
            $this->delete_nav_pic($id);
            $model->delete();
        }
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取导航栏的类型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_nav_type_name($nav_type){

         $type_name     = [

                                'article'=>'新闻',
                                'category'=>'商品分类',
                                'home'    =>'通用类型',
                                'user'    =>'用户中心',
         ];

         if(empty($nav_type)){

            return '通用类型';
         }

         if(!in_array($nav_type,['article','category','home','user'])){

            return '通用类型';
         }

         return $type_name[$nav_type];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取导航栏的类型 select 下拉项
    |
    |-------------------------------------------------------------------------------
    */

    public function get_nav_type_list_option(){


        $type_name     = [

                                'article'=>'新闻',
                                'category'=>'商品分类',
                                'home'    =>'通用类型',
                                'user'    =>'用户中心',
         ];

         $str          = '';

         foreach($type_name as $key=>$value){

            $str      .= '<option value="'.$key.'">'.$value.'</option>';
         }

         return $str;
    }



}