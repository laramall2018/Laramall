<?php

namespace Phpstore\Table;
use DB;

class Common{

	/*
    |-------------------------------------------------------------------------------
    |
    | 获取系统所有的数据表
    |
    |-------------------------------------------------------------------------------
    */
    public function tables(){

    	return collect(json_decode(json_encode(DB::select('SHOW TABLES')),true))
    		->map(function($item){

    				return array_values($item)[0];
    		});
    }
}