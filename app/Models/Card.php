<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phpstore\Repository\CardRepository;
use App\User;
use App\Admin;

class Card extends Model
{
	use CardRepository;
    protected $table 		= 'card';
    protected $fillable 	= [
    							'card_sn',
    							'sort_order',
    							'price',
    							'admin_id',
    							'user_id',
    							'tag',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个用户会有多个礼品卡
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){

    	return $this->belongsTo(User::class,'user_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系 一个管理员会分配多个礼品卡
    |
    |-------------------------------------------------------------------------------
    */
    public function admin(){

    	return $this->belongsTo(Admin::class,'admin_id','id');
    }
}
