<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    

    protected $table            = 'admin_role';
    protected $fillable         = ['role_id','admin_id'];


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系  一个管理员在 管理员角色表中有多条记录
    |
    |-------------------------------------------------------------------------------
    */
    public function admin(){

    	return $this->belongsTo('App\Admin','admin_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系  一个角色 在管理员角色表中有多条记录
    |
    |-------------------------------------------------------------------------------
    */
    public function role(){

    	return $this->belongsTo(Role::class,'role_id','id');
    }
}
