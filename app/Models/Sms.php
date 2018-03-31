<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Admin;

class Sms extends Model
{
    protected $table 			= 'sms';
    protected $fillable 	    = [

    								 'sms_content',
    								 'user_id',
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多关联 获取用户信息
    |
    |-------------------------------------------------------------------------------
    */
    public function user(){

    	return $this->belongsTo(User::class,'user_id','id');
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  一对多关联 获取管理员信息
    |
    |-------------------------------------------------------------------------------
    */
    public function admin(){

    	return $this->belongsTo(Admin::class,'admin_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | post_time
    |
    |-------------------------------------------------------------------------------
    */
    public function post_time(){

    	return date('Y-m-d',$this->post_time);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  reply_time
    |
    |-------------------------------------------------------------------------------
    */
    public function reply_time(){

    	return date('Y-m-d',$this->reply_time);
    }
}
