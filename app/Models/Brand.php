<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\BrandRepository;
use LaraStore\Cache\CacheCommon;

class Brand extends Model{

	use BrandRepository,CacheCommon;
	protected $table = 'brand';

    /*
    |-------------------------------------------------------------------------------
    |
    | 一个品牌下面有多个商品  一对多的关系
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	//第一个编号为关联模型对应的编号 第二个为本模型对应的编号
    	return $this->hasMany(Goods::class,'brand_id','id');
    }

}