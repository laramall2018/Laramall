<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\GoodsRelationRepository;

class GoodsRelation extends Model
{
    use GoodsRelationRepository;
    protected $table = 'goods_relation';

    //设置自动填充数据字段
    protected $fillable   = ['goods_id','relation_goods_id'];


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 属于关系
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	return $this->belongsTo(Goods::class,'goods_id','id');
    }

}
