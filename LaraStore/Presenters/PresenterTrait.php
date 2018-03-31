<?php

namespace LaraStore\Presenters;

trait PresenterTrait{

	/*
    |-------------------------------------------------------------------------------
    |
    |  魔术方法 __get
    |
    |-------------------------------------------------------------------------------
    */
    public function __get($property){

    	return (method_exists($this, $property))? call_user_func([$this,$property]) : false;
    }
}