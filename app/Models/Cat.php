<?php

namespace App\Models;

use Baum\Node  as Node;

class Cat extends Node 
{

  protected $table = 'cats';

  // 父亲结点
  protected $parentColumn = 'parent_id';

  // 'lft' column 
  protected $leftColumn = 'lft';

  // 'rgt' column name
  protected $rightColumn = 'rgt';

  // 'depth' column name
  protected $depthColumn = 'depth';

  // guard attributes from mass-assignment
  protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');



    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 获取商品信息
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

        return  Goods::where('cat_id',$this->id)->get();
      
    }

}
