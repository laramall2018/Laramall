<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class TextForm extends TypeForm{

	
	/*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	$str  = '<div class="form-group">'
    	       .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
    	       .'<div class="col-md-4">'
    	       .Form::text($this->field , $this->value,['class'=>'form-control','id'=>$this->id])
    	       .'</div>'
    	       .'</div>';
    	return $str;

    }

}