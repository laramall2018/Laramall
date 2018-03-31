<?php

namespace LaraStore\Crud\Nav;

use App\Models\{
	Category,
	Brand,
	Article,
	Goods
};

trait MakeFormTrait{

	/*
    |-------------------------------------------------------------------------------
    |
    | 创建表单的数据 create
    |
    |-------------------------------------------------------------------------------
    */
	public static function createData(){

    	return [

                    [
                        'type'          => 'text',
                        'field'         => 'nav_name',
                        'name'          => '导航栏名称',
                        'value'         => '',
                        'id'            => 'nav_name',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   => Category::cat_select(),
                        'selected_name' => '请选择商品分类',
                        'selected_value'=> '',
                        'id'            => 'cat_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Brand::brand_option(),
                        'selected_name' => '请选择商品品牌',
                        'selected_value'=> '',
                        'id'            => 'brand_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'article_id',
                        'name'          => '新闻列表',
                        'option_list'   => Article::option_list(), 
                        'selected_name' => '请选择新闻列表',
                        'selected_value'=> '',
                        'id'            => 'article_id',
                        'crud_tag'      => 'off',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'nav_url',
                        'name'          => '导航栏链接',
                        'value'         => '',
                        'id'            => 'nav_url',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'link',
                        'name'          => '站外链接',
                        'value'         => '',
                        'id'            => 'link',
                    ],
                    

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => '',
                        'id'            => 'sort_order',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'opennew',
                        'name'          => '新窗口',
                        'radio_row'     => (new static)->get_radio_show_list(),
                        'checked'       => 1,
                        'id'            => 'opennew',
                    ],
                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => (new static)->get_radio_show_list(),
                        'checked'       => 1,
                        'id'            => 'is_show',
                    ],
                    

                    [
                        'type'          => 'select',
                        'field'         => 'position',
                        'name'          => '导航栏位置',
                        'option_list'   => (new static)->get_nav_position_list(),
                        'selected_name' => '请选择导航栏位置',
                        'selected_value'=> 0,
                        'id'            => 'position',
                    ],
                    
                    [
                        'type'          => 'file',
                        'field'         => 'nav_pic',
                        'name'          => '导航图片',
                        'file_info'     => '',
                        'id'            => 'nav_pic',
                        'upload_img'    => ''
                    ],

                    [
                        'type'          => 'ueditor',
                        'field'         => 'note',
                        'name'          => '备注说明',
                        'value'         => '',
                        'id'            => 'editor',
                        'class'         => 'col-md-7',
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'base_url',
                        'value'         =>url(''),
                        'id'            =>'base_url',
                        'crud_tag'      => 'off',
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url('admin/nav'),
                    ],
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | 创建编辑表单的数据
    |
    |-------------------------------------------------------------------------------
    */
    public function editData(){

        return [

                    [
                        'type'          => 'text',
                        'field'         => 'nav_name',
                        'name'          => '导航栏名称',
                        'value'         => $this->nav_name,
                        'id'            => 'nav_name',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'cat_id',
                        'name'          => '商品分类',
                        'option_list'   => Category::cat_select(),
                        'selected_name' => '请选择',
                        'selected_value'=> '',
                        'id'            => 'cat_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'brand_id',
                        'name'          => '商品品牌',
                        'option_list'   => Brand::brand_option(),
                        'selected_name' => '请选择商品品牌',
                        'selected_value'=> '',
                        'id'            => 'brand_id',
                        'crud_tag'      => 'off',
                    ],
                    [
                        'type'          => 'select',
                        'field'         => 'article_id',
                        'name'          => '新闻列表',
                        'option_list'   => Article::option_list(), 
                        'selected_name' => '请选择新闻列表',
                        'selected_value'=> '',
                        'id'            => 'article_id',
                        'crud_tag'      => 'off',
                    ],

                    [
                        'type'          => 'text',
                        'field'         => 'nav_url',
                        'name'          => '导航栏链接',
                        'value'         => $this->nav_url,
                        'id'            => 'nav_url',
                    ],
                    [
                        'type'          => 'text',
                        'field'         => 'link',
                        'name'          => '站外链接',
                        'value'         => $this->link,
                        'id'            => 'link',
                    ],
                    

                    [
                        'type'          => 'text',
                        'field'         => 'sort_order',
                        'name'          => '排序',
                        'value'         => $this->sort_order,
                        'id'            => 'sort_order',
                    ],

                    [
                        'type'          => 'radio',
                        'field'         => 'opennew',
                        'name'          => '新窗口',
                        'radio_row'     => (new static)->get_radio_show_list(),
                        'checked'       => $this->opennew,
                        'id'            => 'opennew',
                    ],
                    [
                        'type'          => 'radio',
                        'field'         => 'is_show',
                        'name'          => '是否显示',
                        'radio_row'     => (new static)->get_radio_show_list(),
                        'checked'       => $this->is_show,
                        'id'            => 'is_show',
                    ],
                    

                    [
                        'type'          => 'select',
                        'field'         => 'position',
                        'name'          => '导航栏位置',
                        'option_list'   => (new static)->get_nav_position_list(),
                        'selected_name' => $this->get_nav_position_name(),
                        'selected_value'=> $this->postion,
                        'id'            => 'position',
                    ],
                    
                    [
                        'type'          => 'file',
                        'field'         => 'nav_pic',
                        'name'          => '导航图片',
                        'file_info'     => '',
                        'id'            => 'nav_pic',
                        'upload_img'    => $this->nav_pic,
                    ],

                    [
                        'type'          => 'ueditor',
                        'field'         => 'note',
                        'name'          => '备注说明',
                        'value'         => $this->note,
                        'id'            => 'editor',
                        'class'         => 'col-md-7',
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'base_url',
                        'value'         =>url(''),
                        'id'            =>'base_url',
                        'crud_tag'      => 'off',
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'id',
                        'value'         =>$this->id,
                        'id'            =>'id',
                    ],

                    [
                        'type'          =>'hidden',
                        'field'         =>'_method',
                        'value'         =>'PUT',
                        'id'            =>'_method',
                    ],

                    [
                        'type'          => 'submit',
                        'value'         => '确认添加',
                        'id'            => 'cat-submit',
                        'back_url'      => url('admin/nav'),
                    ],
        ];
    }
}