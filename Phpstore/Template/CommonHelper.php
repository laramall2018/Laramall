<?php namespace Phpstore\Template;

use Phpstore\Grid\TableData;
use Phpstore\Grid\Grid;
use Phpstore\Grid\Page;
use Phpstore\Grid\Common;
use Phpstore\Base\Goodslib;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Activity;
use App\Models\ActivityGoods;
use Request;
use Phpstore\Crud\ImageLib;
use HTML;
use DB;
use Cache;

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
        $this->list_url             = 'admin/template';



    }


    /*
     * 获取配置文件的信息
     *
     */
    public function get_config_data(){


        $data       = [];

        foreach($this->field() as $item){

            $res                    = DB::table('template_config')->where('code',$item)->first();

            if($res){

                $data[$item]        = $res->value;
            }
            else{

                $data[$item]        = '';
            }
        }

        return $data;
    }

    /*
     * 返回缓存数据中的系统配置文件
     */
    public function get_config_data_from_cache(){

        if(Cache::has('template_config_data')){

            return Cache::get('template_config_data');
        }
        else{

            $data   = $this->get_config_data();
            Cache::put('template_config_data',$data,3600);
            return Cache::get('template_config_data');
        }
    }

    /*
     * 返回系统所有的配置文件字段信息
     *
     */
    public function field(){

        return [
                    
                    'tp_name',
                    'tp_thumb',
                    'new_goods_number',
                    'hot_goods_number',
                    'best_goods_number',
                    'promote_goods_number',
                    'cat_goods_number',
                    'footer_desc',
                    
        ];
    }

}