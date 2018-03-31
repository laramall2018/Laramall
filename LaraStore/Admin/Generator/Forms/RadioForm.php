<?php

namespace LaraStore\Admin\Generator\Forms;

use Form; 

class RadioForm extends TypeForm{

	
	/*
    |-------------------------------------------------------------------------------
    |
    | 返回参数
    |
    |-------------------------------------------------------------------------------
    */
    public function make(){

    	$str    = '<div class="form-group">'
                 .Form::label($this->field,$this->name,['class'=>'col-md-3 control-label'])
                 .'<div class="col-md-4">';

        foreach($this->radio_row as $item){

             if($item['value'] == $this->checked){

                $checked_str  = 'checked="checked"';
             }
             else{

                $checked_str  = '';
             }

            $str    .='<input type="radio" class="icheck mycheckbox" name="'
                    .$this->field
                    .'" value="'
                    .$item['value']
                    .'"'
                    .$checked_str
                    .'>'
                    .'&nbsp;&nbsp;'.$item['name'].'&nbsp;&nbsp;'
                    .' ';
        }

        $str   .='</div></div>';
        return $str;
    }

}