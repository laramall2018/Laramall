<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\TagRepository;

class Tag extends Model{

	use TagRepository;
	protected $table 			= 'tag';
	protected $fillable 		= ['tag_name','goods_id','username','sort_order'];
    protected $appends          = ['goodsName','goodsUrl'];

	

    /*
    |-------------------------------------------------------------------------------
    |
    | 标签和商品 为一对多关联  一个商品 可以有多个标签  但是一个标签只能属于一个商品
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	return $this->belongsTo(Goods::class,'goods_id','id');
    }

}