<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\Category;
use LaraStore\Entity\CategoryEntity;
use App\Models\Image;
use App\Models\Cart;
use App\Models\GoodsAttr;
use Auth;
use Phpstore\Front\Grid;
use Phpstore\Grid\Page;

class CategoryController extends ApiController
{
    
    public $tag;
    public $info;
    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

        $this->tag          = 'success';
        $this->info         = 'success';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 获取首页热卖商品 促销商品  新品 精品商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function getJson($id){

        return  $this->toJSON($id);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | 返回所有的记录
    |
    |-------------------------------------------------------------------------------
    */
    public function toJSON($id){

        
        $tag                            = $this->tag;
        $info                           = $this->info;
        $entity                         = new CategoryEntity();
        $goods_list                     = $entity->goodsJson($id);
        $page                           = $entity->page($id);
        $current_page                   = $page['current_page'];
        $total                          = $page['total'];
        $per_page                       = $page['per_page'];
        $last_page                      = $page['last_page'];
        $number                         = $page['number'];
        $price                          = $entity->price($id);
        $brand                          = $entity->brand($id);
        $attr                           = $entity->attr($id);
        $cat_id                         = $id;
        $brand_id                       = 0;
        $brand_name                     = '';
        $goods_attr_ids                 = [];
        $goods_attrs                    = [];
        $max                            = 0;
        $min                            = 0;
        $sort_name                      = 'id';
        $sort_value                     = 'asc';

        $arr                            =[ 
                                            
                                            'tag',//执行结果
                                            'info',//弹出信息
                                            'goods_list',
                                            'page',
                                            'price',
                                            'brand',
                                            'attr',
                                            'number',
                                            'goods_attr_ids',//被选中的商品属性值编号数组
                                            'goods_attrs',
                                            'max',//价格区间最大值
                                            'min',//价格区间最小值
                                            'cat_id',//分类编号
                                            'brand_id',//品牌编号
                                            'brand_name',//品牌名称
                                            'sort_name',
                                            'sort_value',
                                            'current_page',
                                            'last_page',
                                            'per_page',
                                            'total',
                                         ];

        return $this->respond(['data'=>compact($arr)]);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    | 处理grid
    |
    |-------------------------------------------------------------------------------
    */
    public function grid(){
        //把json格式转换为对象
        $param              = request()->param;
        $param              = json_decode($param);
        //获取具体的参数
        $cat_id             = intval($param->cat_id);
        $brand_id           = intval($param->brand_id);
        $min                = $param->min;
        $max                = $param->max;
        $goods_attr_ids     = $param->goods_attr_ids;
        $sort_name          = $param->sort_name;
        $sort_value         = $param->sort_value;
        //初始化grid组件
        $grid               = new Grid();
        //设置参数
        $grid->init(compact('cat_id','brand_id','min','max','goods_attr_ids','sort_name','sort_value'));
        
        //设置分页
        $per_page           = intval(Category::list_page_size());
        $current_page       = $param->current_page;
        $total              = intval($grid->total());
        $last_page          = ceil($total/$per_page);
        //如果当前分页大于最后一页
        if($current_page > $last_page){

            $current_page   = 1;
        }
        //初始化分页组件
        $pageModel          = new Page();
        $pageModel->init(compact('current_page','per_page','total','last_page'));
        //给grid组件设置分页信息
        $grid->put('page',$pageModel);

        //返回json格式数据
        $tag                = $this->tag;
        $info               = $this->info;
        $goods_list         = $grid->getGoodsList();         
        $goods_attrs        = GoodsAttr::getList($goods_attr_ids);
        $number             = $pageModel->number();
        $page               = $grid->page();
        $cacheKey           = $grid->getCacheKey();
        //返回json
        $arr                = [
                                    'tag',
                                    'info',
                                    'goods_list',
                                    'goods_attrs',
                                    'page',
                                    'number',
                                    'current_page',
                                    'per_page',
                                    'last_page',
                                    'total',
                                    'cacheKey',
        ];
        return $this->respond(['data'=>compact($arr)]);

    }
}
