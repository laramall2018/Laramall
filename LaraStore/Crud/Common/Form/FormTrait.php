<?php

namespace LaraStore\Crud\Common\Form;

trait FormTrait{

	/*
    |-------------------------------------------------------------------------------
    |
    |   设置参数
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key,$value){

    	$this->$key  		= $value;
    	return $this;
    }
}