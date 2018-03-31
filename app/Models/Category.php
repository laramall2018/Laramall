<?php

namespace App\Models;

use Baum\Node as Node;
use LaraStore\Repository\Category\BaseRepository;
use LaraStore\Repository\Category\StaticRepository;

/*
|-------------------------------------------------------------------------------
|
| 分类模型 继承于baum 无限套嵌集合
|
|-------------------------------------------------------------------------------
*/
class Category extends Node{

    use BaseRepository,StaticRepository;
    protected $table = 'category';
    // 'parent_id' column name
    protected $parentColumn = 'parent_id';

    // 'lft' column name
    protected $leftColumn = 'left';

    // 'rgt' column name
    protected $rightColumn = 'right';

    // 'depth' column name
    protected $depthColumn = 'depth';

    //批量赋值黑名单
  	protected $guarded = array('id', 'parent_id', 'left', 'right', 'depth','created_at','updated_at','cat_img');

    //批量赋值白名单
    protected $fillable = [

    				'cat_name',
    				'measure_unit',
    				'cat_desc',
    				'keywords',
    				'cat_template',
    				'is_show',
    				'is_nav',
    				'grade',
    				'diy_url',
    				'sort_order',
    ];

    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的方式 获取商品分类下的广告信息
    |
    |-------------------------------------------------------------------------------
    */
    public function cat_ad(){

        return $this->hasMany(CatAd::class,'cat_id','id');
    }

    

}
