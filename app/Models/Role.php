<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{

	
	protected $table = 'role';
	protected $primaryKey = 'id';


	/*
    |-------------------------------------------------------------------------------
    |
    | 一对多的关系  一个角色在 管理员角色表中有多条记录
    |
    |-------------------------------------------------------------------------------
    */
    public function admin_role(){

    	return $this->hasMany(AdminRole::class,'role_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 多对多关系  角色和管理
    |
    |-------------------------------------------------------------------------------
    */
    public function admin(){

    	return $this->belongsToMany('App\Admin','admin_role','role_id','admin_id')->groupBy('admin_id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  角色权限  role == role_privi 一对多
    |
    |-------------------------------------------------------------------------------
    */
    public function role_privi(){

    	return $this->hasMany(RolePrivi::class,'role_id','id');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 多对多关系  角色和权限关系
    |
    |-------------------------------------------------------------------------------
    */
    public function privi(){

    	return $this->belongsToMany(Privi::class,'role_privi','role_id','privi_id')->groupBy('privi_id');
    }



}