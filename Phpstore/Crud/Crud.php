<?php namespace Phpstore\Crud;


use HTML;
use Form;
use App\Models\GoodsGallery;
/*
|-------------------------------------------------------------------------------
|
|  Crud 类 提供系统基础的crud操作封装
|
|  C --------- create 	创建数据 在数据库中添加记录  对应的模板为 crud_add.blade.php
|						对应的aciton为insert操作
|
|  R --------- read   	读取数据 把数据库中的数据读取出来  做成分页显示表格  如果需要做
|					    ajax排序  只需要调用grid组件模板即可
|                       如果不需要做grid 那只需要调用模板 crud_list.blade.php
|
|  U --------- update   更新数据  根据数据的编号id 读取出数据 再做更新 对应模板
|					    读取显示数据模板 crud_edit.blade.php
|					    对应的action操作为：update
|
|  D --------- Delete   根据数据编号id  删除这条记录  delete()操作
|
|-------------------------------------------------------------------------------
|
|  get_type_list()                      返回表单类型
|  put($key,$value)	                    设置值
|  get($key)                            获取值
|  render()                             获取带portlet的整体输出
|  FormDom()                            render()辅助函数 返回所有表单的输出
|  createFormTypeDom()                  根据不同表单类型 返回不同的处理函数
|
|--------------------------------------------------------------------------------
|  textForm()                           text表单输出函数
|  text_disabledForm                    text disabled表单输出函数（不可编辑）
|  passwordForm                         password 表单输出函数
|  password_confirmationForm()          确认密码表单输出函数
|  selectForm                           select表单输出函数
|  radioForm                            单选表单输出函数
|  checkboxForm()                       多选表单输出函数
|  textareaForm()                       多行表单输出函数
|  fileForm()                           文件表单
|  pcdForm()                            输出三级联查表单
|  ueditorForm()                        输出百度富文本
|  codeForm()                           输出代码
|  privi_listForm()                     输出权限表单
|  hiddenForm()                         输出隐藏表单
|  submitForm()                         确认表单输出
|  buttonForm()                         输出按钮表单
|-------------------------------------------------------------------------------
|  form()                               单纯输出表单
|  uploadify                            输出uploadify网页元素
|-------------------------------------------------------------------------------
*/

class Crud{

	protected  $row;  						 //数据表中需要处理的字段数组
	protected  $url;						 //表单操作中的链接
	protected  $form;                        //系统对应的表单
    protected  $type_list;                   //限制所能处理的表单类型


	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){

        $this->form             = new TemplateForm();
        $this->type_list        = $this->get_type_list();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回所有处理的表单类型
    |
    |-------------------------------------------------------------------------------
    */
    public function get_type_list(){

        return [
                    'text',
                    'text_disabled',
                    'password',
                    'password_confirmation',
                    'select',
                    'radio',
                    'checkbox',
                    'textarea',
                    'file',
                    'pcd',
                    'ueditor',
                    'ueditor_big',
                    'code',
                    'privi_list',
                    'hidden',
                    'submit',
                    'submit2',
                    'button',
                    'goods_attr',
                    'div',
        ];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  设置值
    |
    |-------------------------------------------------------------------------------
    */
    public function put($key , $value){

    	$this->$key 		=  $value;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  获取值
    |
    |-------------------------------------------------------------------------------
    */
    public function get($key){


    	if($this->$key){

    		return $this->$key;
    	}

    	return '';
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成form的html元素字符串 并返回html字符串
    |
    |-------------------------------------------------------------------------------
    */
    public function render(){

        $str  = '<div class="form-body">'
                .Form::open(['url'=>$this->url,'method'=>'post','files'=>true,'class'=>'form-horizontal common-form'])
                .$this->FormDom()
                .Form::close()
                .'</div>';

        return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  根据递交的表单类型数组 循环输出form字符串
    |
    |-------------------------------------------------------------------------------
    */
    public function FormDom(){

        $str  = '';
        if(empty($this->row)){

             return '';
        }

        //根据不同的表单类型 生成不同的表单dom元素
        foreach($this->row as $item){

            $str .= $this->createFormTypeDom($item);
        }

        return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据递交的表单类型数组 循环输出form字符串 不同类型表单 返回的函数 是：表单类型+Form
    |
    |-------------------------------------------------------------------------------
    */
    public function createFormTypeDom($item){


        if(in_array($item['type'],$this->type_list)){

            $TypeForm           = $item['type'].'Form';
            return $this->$TypeForm($item);
        }
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  text 表单处理函数
    |
    |-------------------------------------------------------------------------------
    */
    public function  textForm($item){

        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('value',$item['value']);
        $this->form->put('id',$item['id']);

        return $this->form->text();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  text 禁止编辑表单处理函数
    |
    |-------------------------------------------------------------------------------
    */
    public function text_disabledForm($item){

         //设置参数
         $this->form->put('field',$item['field']);
         $this->form->put('name',$item['name']);
         $this->form->put('value',$item['value']);
         $this->form->put('id',$item['id']);

         return $this->form->TextDisabled();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  pasword 表单处理函数  passwordForm
    |
    |-------------------------------------------------------------------------------
    */
    public function passwordForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);

        return $this->form->password();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  pasword_confirmation 确认密码表单处理函数
    |
    |-------------------------------------------------------------------------------
    */
    public function password_confirmationForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);

        return $this->form->password_confirmation();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  selectForm 处理表单
    |
    |-------------------------------------------------------------------------------
    */
    public function selectForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('option_list',$item['option_list']);
        $this->form->put('selected_name',$item['selected_name']);
        $this->form->put('selected_value',$item['selected_value']);
        $this->form->put('id',$item['id']);

        return $this->form->select();
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  商品属性下拉选择 处理表单
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_attrForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('option_list',$item['option_list']);
        $this->form->put('selected_name',$item['selected_name']);
        $this->form->put('selected_value',$item['selected_value']);
        $this->form->put('id',$item['id']);
				$this->form->put('value',$item['value']);

        return $this->form->goods_attr();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  radio 单选表单处理函数 radioForm表单
    |
    |-------------------------------------------------------------------------------
    */
    public function radioForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('radio_row',$item['radio_row']);
        $this->form->put('checked',$item['checked']);
        $this->form->put('id',$item['id']);

        return $this->form->radio();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  checkbox 多选表单处理函数  checkboxForm
    |
    |-------------------------------------------------------------------------------
    */
    public function checkboxForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('checkbox_row',$item['checkbox_row']);
        $this->form->put('checked_row',$item['checked_row']);
        $this->form->put('id',$item['id']);

        return $this->form->checkbox();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  textare 多行输入表单处理函数 textareForm表单
    |
    |-------------------------------------------------------------------------------
    */
    public function textareaForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('value',$item['value']);
        $this->form->put('id',$item['id']);

        return $this->form->textarea();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  处理图片上传表单的函数  fileForm
    |
    |-------------------------------------------------------------------------------
    */
    public function fileForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('name',$item['name']);
        $this->form->put('file_info',$item['file_info']);
        $this->form->put('id',$item['id']);
        $this->form->put('upload_img',$item['upload_img']);

        return $this->form->upload_file();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  处理ajax三级联查国家地区城市区县等
    |
    |-------------------------------------------------------------------------------
    */
    public function pcdForm($item){

        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);
        $this->form->put('country',$item['country']);
        $this->form->put('province',$item['province']);
        $this->form->put('city',$item['city']);
        $this->form->put('district',$item['district']);

        $this->form->put('country_str',$item['country_str']);
        $this->form->put('province_str',$item['province_str']);
        $this->form->put('city_str',$item['city_str']);
        $this->form->put('district_str',$item['district_str']);

        return $this->form->pcd();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  输出百度富文本编辑框 ueditorForm
    |
    |-------------------------------------------------------------------------------
    */
    public function ueditorForm($item){

        $this->form->put('field',$item['field']);
        $this->form->put('value',$item['value']);
        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);

        return $this->form->ueditor();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  输出百度富文本编辑框 ueditorForm
    |
    |-------------------------------------------------------------------------------
    */
    public function ueditor_bigForm($item){

        $this->form->put('field',$item['field']);
        $this->form->put('value',$item['value']);
        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);

        return $this->form->ueditor_big();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  输出代码表单 codeForm
    |
    |-------------------------------------------------------------------------------
    */
    public function codeForm($item){

        $this->form->put('field',$item['field']);
        $this->form->put('value',$item['value']);
        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);

        return $this->form->code();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出权限列表表单（添加和编辑时) privi_listForm
    |
    |-------------------------------------------------------------------------------
    */
    public function privi_listForm($item){

        $this->form->put('value',$item['value']);
        return $this->form->privi();

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出隐藏表单  hiddenForm
    |
    |-------------------------------------------------------------------------------
    */
    public function hiddenForm($item){

        //设置参数
        $this->form->put('field',$item['field']);
        $this->form->put('value',$item['value']);
        $this->form->put('id',$item['id']);

        return $this->form->hide();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出确认表单 submitForm
    |
    |-------------------------------------------------------------------------------
    */
    public function submitForm($item){

        //设置参数
        $this->form->put('value',$item['value']);
        $this->form->put('id',$item['id']);
        $this->form->put('back_url',$item['back_url']);

        return $this->form->submit();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  输出确认表单 submitForm
    |
    |-------------------------------------------------------------------------------
    */
    public function submit2Form($item){

        //设置参数
        $this->form->put('value',$item['value']);
        $this->form->put('id',$item['id']);
        $this->form->put('back_url',$item['back_url']);

        return $this->form->submit2();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  输出单纯的html按钮元素 button
    |
    |-------------------------------------------------------------------------------
    */
    public function buttonForm($item){

        //设置参数
        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);
				$this->form->put('back_url',$item['back_url']);

        return $this->form->button();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  输出单纯的div元素到表单中
    |
    |-------------------------------------------------------------------------------
    */
    public function divForm($item){

        //设置参数
        $this->form->put('name',$item['name']);
        $this->form->put('id',$item['id']);
        $this->form->put('value',$item['value']);

        return $this->form->div();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  用过程式的方法 生成所有类型的表单form
    |
    |-------------------------------------------------------------------------------
    */
    public function form(){

    	$str  = '<div class="form-body">'
                .Form::open(['url'=>$this->url,'method'=>'post','files'=>true,'class'=>'form-horizontal']);

        if(empty($this->row)){

            return '';
        }

        foreach($this->row as $item){

            //直接输入表单
            if($item['type'] == 'text'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('value',$item['value']);
                $this->form->put('id',$item['id']);

                $str .= $this->form->text();
            }

            //直接输入表单 禁止编辑表单
            elseif($item['type'] == 'text_disabled'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('value',$item['value']);
                $this->form->put('id',$item['id']);

                $str .= $this->form->TextDisabled();
            }

            //输出密码表单
            elseif($item['type'] == 'password'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('id',$item['id']);

                $str .= $this->form->password();
            }

            //输出确认密码
            //输出密码表单
            else if($item['type'] == 'password_confirmation'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('id',$item['id']);

                $str .= $this->form->password_confirmation();
            }

            //如果是下拉选中表单
            elseif($item['type'] == 'select'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('option_list',$item['option_list']);
                $this->form->put('selected_name',$item['selected_name']);
                $this->form->put('selected_value',$item['selected_value']);
                $this->form->put('id',$item['id']);

                $str .= $this->form->select();
            }

            //如果是单选按钮
            elseif($item['type'] == 'radio'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('radio_row',$item['radio_row']);
                $this->form->put('checked',$item['checked']);
                $this->form->put('id',$item['id']);
                $str .= $this->form->radio();
            }


            //如果是多选按钮
            elseif($item['type'] == 'checkbox'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('checkbox_row',$item['checkbox_row']);
                $this->form->put('checked_row',$item['checked_row']);
                $this->form->put('id',$item['id']);
                $str .= $this->form->checkbox();
            }

            //如果是textare
            elseif($item['type'] == 'textarea'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('value',$item['value']);
                $this->form->put('id',$item['id']);
                $str .= $this->form->textarea();
            }

            //如果是上传文件
            elseif($item['type'] == 'file'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('name',$item['name']);
                $this->form->put('file_info',$item['file_info']);
                $this->form->put('id',$item['id']);
                $this->form->put('upload_img',$item['upload_img']);
                $str .= $this->form->upload_file();
            }

            //如果需要显示地址多级联查
            elseif($item['type'] == 'pcd'){


                 $this->form->put('name',$item['name']);
                 $this->form->put('id',$item['id']);
                 $this->form->put('country',$item['country']);
                 $this->form->put('province',$item['province']);
                 $this->form->put('city',$item['city']);
                 $this->form->put('district',$item['district']);

                 $this->form->put('country_str',$item['country_str']);
                 $this->form->put('province_str',$item['province_str']);
                 $this->form->put('city_str',$item['city_str']);
                 $this->form->put('district_str',$item['district_str']);

                 $str .= $this->form->pcd();



            }

            //输入出百度富文本框
            elseif($item['type'] =='ueditor'){

                $this->form->put('field',$item['field']);
                $this->form->put('value',$item['value']);
                $this->form->put('name',$item['name']);
                $this->form->put('id',$item['id']);
                $str .= $this->form->ueditor();
            }


            //输出代码
            elseif($item['type'] =='code'){

                $this->form->put('field',$item['field']);
                $this->form->put('value',$item['value']);
                $this->form->put('name',$item['name']);
                $this->form->put('id',$item['id']);
                $str .= $this->form->code();
            }

            //输出代码
            elseif($item['type'] =='div'){

               
                $this->form->put('value',$item['value']);
                $this->form->put('name',$item['name']);
                $this->form->put('id',$item['id']);
                $str .= $this->form->div();
            }


            //输出权限分配列表
            elseif($item['type'] == 'privi_list'){


                $this->form->put('value',$item['value']);

                $str .= $this->form->privi();
            }

            //隐藏表单
            elseif($item['type'] == 'hidden'){

                //设置参数
                $this->form->put('field',$item['field']);
                $this->form->put('value',$item['value']);
                $this->form->put('id',$item['id']);
                $str .= $this->form->hide();

            }

            //隐藏表单
            elseif($item['type'] == 'submit'){

                //设置参数
                $this->form->put('value',$item['value']);
                $this->form->put('id',$item['id']);
                $this->form->put('back_url',$item['back_url']);
                $str .= $this->form->submit();

            }
        }




        $str  .= Form::close().'</div>';

        return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成选项卡tab
    |
    |-------------------------------------------------------------------------------
    */
    public function tab(){

        $str            = '<div class="ps-tab">';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成选项卡的title
    |
    |-------------------------------------------------------------------------------
    */
    public function tabTitle(){

        $tab_title      = $this->tab_title;
        $str            = '<ul class="ps-tab-title">';

        if(empty($tab_title)){

            return $str;

        }

        foreach($tab_title as $key=>$item){

            if($key == 0){

                $cls    = 'cur';
            }
            else{

                $cls    = '';
            }

            $str  .= '<li class="'.$cls.'">'.$item.'</li>';
        }

            $str  .= '</ul>';


        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出确认表单 uploadify()
    |
    |-------------------------------------------------------------------------------
    */
    public function uploadify(){

        $str    = '<div class="img-upload">'
                 .'<div id="queue"></div>'
                 .'<input id="file_upload" name="file_upload" type="file" multiple="true">'
                 .'</div>'
                 .'<div id="goods-img-list"></div>';
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出编辑商品的时候批量上传商品图片表单 edit_uploadify()
    |
    |-------------------------------------------------------------------------------
    */
    public function edit_uploadify($model){


        $str              = '<div class="img-upload">'
                            .'<div id="queue"></div>'
                            .'<input id="file_upload" name="file_upload" type="file" multiple="true">'
                            .'</div>';

        $goods_id         = $model->id;

        $goods_gallery    = GoodsGallery::where('goods_id',$goods_id)->get();

        if(empty($goods_gallery)){

            return $str;
        }

        $str              .= '<div id="goods-img-list">';

        foreach($goods_gallery as $value){

                $str         .='<div class="img-item">'
                             . '<input type="hidden" name="source_imgs[]" value="'.$value->original.'">'
                             . '<input type="hidden" name="goods_thumbs[]" value="'.$value->thumb.'">'
                             . '<input type="hidden" name="goods_imgs[]" value="'.$value->img.'">'
                             . HTML::image($value->original)
                             . '<span class="img-del" '
                             . 'data-source_img="'.$value->original.'" '
                             . 'data-goods_img="'.$value->img.'" '
                             . 'data-goods_thumb="'.$value->thumb.'" >'
                             . '删除</span>'
                             . '</div>';
        }

        $str             .= '</div>';

        return $str;

    }

    

}
