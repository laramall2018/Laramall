<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\MessageRepository;
use App\User;
class Message extends Model
{   
    use MessageRepository;
    protected $table 		= 'message';
    protected $fillable 	= [
    							'type',
    							'id_value',
    							'email',
    							'username',
    							'content',
    							'rank',
                                'add_time',
                                'front_ip',
                                'status',
    ];
    protected $appends      = ['hasReply','createTime','replyTimeFormat','statusFormat','rankStar','goodsInfo'];


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取留言的商品信息  一对多的关系  一个留言可以属于某个商品 商品有多个留言信息
    |
    |-------------------------------------------------------------------------------
    */
    public function goods(){

    	return $this->belongsTo(Goods::class,'id_value','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 留言用户
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){
        return $this->presenter()->user;
    }
}
