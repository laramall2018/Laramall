<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class HiddenForm extends TypeForm{

	
	  /*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	 return '<input type="hidden" name="'.$this->field.'" value="'.$this->value.'" id="'.$this->id.'" >';

    }

}