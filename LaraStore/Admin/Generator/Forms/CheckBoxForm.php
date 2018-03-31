<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class CheckboxForm extends TypeForm{

	
	/*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	$str           = '<div class="form-group">'
                          .Form::label($this->field,$this->name,['class'=>'col-md-3 control-label','id'=>$this->id])
                          .'<div class="col-md-9">';

        foreach($this->checkbox_row as $item){

            if(in_array($item['value'],$this->checked_row)){

                $checked_str  = 'checked';
             }
             else{

                $checked_str  = '';
             }

                     $str .='<input type="checkbox" class="icheck mycheckbox" name="'
                          .$this->field
                          .'" value="'
                          .$item['value']
                          .'" '
                          .$checked_str
                          .'>'
                          .'&nbsp;&nbsp;'.$item['name'].'&nbsp;&nbsp;'
                          .'';
        }

        $str   .='</div></div>';
        return $str;

    }

}