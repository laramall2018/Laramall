<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class TextareaForm extends TypeForm{

	
	/*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	return '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="col-md-4">'
               .'<textarea name="'.$this->field.'"  id="'.$this->id.'" cols="65" rows="4" class="form-control">'
               .$this->value
               .'</textarea>'
               .'</div>'
               .'</div>';

    }

}