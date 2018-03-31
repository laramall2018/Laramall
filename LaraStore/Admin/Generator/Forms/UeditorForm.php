<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class UeditorForm extends TypeForm{

	
	  /*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	return   '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="'.$this->class.'">'
               .'<textarea name="'.$this->field.'"  id="'.$this->id.'" style="width:100%;height:500px;">'
               .$this->value.
               '</textarea>'
               .'</div>'
               .'</div>';
    }

}