<?php

namespace Phpstore\Repository;

trait AdminRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    | 获取管理员optionList
    |
    |-------------------------------------------------------------------------------
    */
    public static function optionList(){

    	$self 			= new static;
    	$str 			= '';
    	foreach($self->all() as $admin){

    		$str 	   .= '<option value="'.$admin->id.'">'.$admin->username.'</option>';
    	}
    	return $str;
    }
}