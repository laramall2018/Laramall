<?php

namespace LaraStore\Entity;
use LaraStore\Cache\Helper;

class CommonEntity{

	public $table;
	public $helper;
	public $model;
	public $modelClass;
	public $price;


	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(){

    	$this->modelClass 	= $this->getModelClass();
    	$this->table 		= $this->getTableName();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 返回模型
    |
    |-------------------------------------------------------------------------------
    */
    public function getModelClass(){

    	 return true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 获取数据表名称
    |
    |-------------------------------------------------------------------------------
    */
    public function getTableName(){

    	return call_user_func(array($this->modelClass,'getTableName'));
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 从缓存中获取数据通用函数 （从缓存中获取）
    |
    |-------------------------------------------------------------------------------
    */
    public function getCache(){

    	$this->helper 						= new Helper();
    	$this->helper->key 					= $this->key;
    	$this->helper->time 				= 3600;
    	$this->helper->obj 					= $this;
    	$this->helper->funcName 			= $this->funcName;

    	//从缓存中获取记录
    	return $this->helper->get($this->id);
    }




    /*
    |-------------------------------------------------------------------------------
    |
    | 从数据库中获取模型
    |
    |-------------------------------------------------------------------------------
    */
    public function getModelFromDatabase($id){

    	return call_user_func(array($this->modelClass,'find'),$id);
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  从缓存中获取
    |
    |-------------------------------------------------------------------------------
    */
    public function find($id){

    	$this->key 							= $this->table.'_get_model_by_id_is_'.$id;
    	$this->funcName 					= 'getModelFromDatabase';
    	$this->id 							= $id;
    	$this->model 						= $this->getCache();

    	return $this->model;
    }

}