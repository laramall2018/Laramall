<?php

namespace LaraStore\Repository\Nav;

trait BaseRepository{

	/*
    |-------------------------------------------------------------------------------
    |
    |  返回自定义导航栏的位置
    |
    |-------------------------------------------------------------------------------
    */
    public static function position_arr(){

        return  [

                   	['position'=>'top','name'=>'顶部导航'],
                    ['position'=>'middle','name'=>'中间导航'],
                    ['position'=>'bottom','name'=>'底部导航'],
                    ['position'=>'1f','name'=>'1f'],
                    ['position'=>'2f','name'=>'2f'],
                    ['position'=>'3f','name'=>'3f'],
                    ['position'=>'4f','name'=>'4f'],
                    ['position'=>'5f','name'=>'5f'],
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回自定义导航栏的所有位置
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_nav_position_list(){

        $row        = (new static)->position_arr();
        $str        = '';

        foreach($row as $item){

            $str .= '<option value="'.$item['position'].'">'.$item['name'].'</option>';

        }

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
   	|  返回导航栏的位置名称
    |
    |-------------------------------------------------------------------------------
    */
    public function get_nav_position_name(){

        $row        = (new static)->position_arr();
        foreach($row as $item){

           if($item['position']== $this->positon){

                return $item['name'];
            }
        }

            return '';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  返回radio表单的list
    |
    |-------------------------------------------------------------------------------
    */
    public static function get_radio_show_list(){

        return [

                    ['name'=>'不显示','value'=>0],
                    ['name'=>'显示','value'=>1],

        ];
    }

}