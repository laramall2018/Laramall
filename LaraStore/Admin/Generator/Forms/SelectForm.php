<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class SelectForm extends TypeForm{


	/*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	return  '<div class="form-group">'
    			.Form::label($this->field,$this->name ,['class'=>'col-md-3 control-label'])
    			.'<div class="col-md-4">'
    			.'<select name="'.$this->field.'" id="'.$this->id.'" class="form-control">'
    			.'<option value="'.$this->selected_value.'" selected="selected">'.$this->selected_name.'</option>'
    			.$this->option_list
    			.'</select>'
    			.'</div>'
    			.'</div>';

    }

}