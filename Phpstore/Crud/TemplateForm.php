<?php namespace Phpstore\Crud;


use HTML;
use DB;
use Form;
use App\Models\Region;
use App\Models\Privi;
use Phpstore\Grid\Common;


/*
|-------------------------------------------------------------------------------
|
|  根据表单的类型 生成不同的form表单
|
|-------------------------------------------------------------------------------
|
|   text()                ------------- 普通输入表单<input type="text">
|   DisabledText()        ------------- 禁止编辑表单<input type="text" disabled="disabled">
|   password()            ------------- 密码输入框<input type="password">
|   password_confirmation ------------- 确认密码框<input type="password">
|   select()              ------------- 下拉选项表单<select name=""></select>
|   radio()               ------------- 单选按钮表单<input type="radio">
|   checkbox()            ------------- 多选输入表单<input type="checkbox">
|   textarea()            ------------- 多行输入文本<textarea></textarea>
|   upload_file()         ------------- 上传文件<input type="file">
|   hide()                ------------- 隐藏表单<input type="hidden">
|   privi()               ------------- 生成权限的处理表单 <input type="checkbox" name="ids[]">
|   pcd()                 ------------- 国家地区地址ajax三级联查表单
|   ueditor()             ------------- 输出百度富文本表单<textarea></textare>
|   code()                ------------- 输出代码显示表单
|   submit()              ------------- 确认表单<input type="submit">
|   button()              ------------- 输出单纯的html元素的dom的按钮
|
|-------------------------------------------------------------------------------
*/
class TemplateForm{

	protected  $row;                         	//用于填充表单的数组数据
	protected  $type;  						 	//表单的类型
	protected  $field; 				 		 	//表单里面的字段名称
	protected  $name;						 	//表单的中文名称
	protected  $value;						 	//表单的值
	protected  $option_list;				 	//下拉表单的所有选项
	protected  $selected_name; 				 	//下拉表单被选中的字段名称
	protected  $selected_value;   		 		//下拉表单被选中的字段的值
	protected  $id;						     	//表单的id
	protected  $radio_row;				   		//单选表单的选项数组
	protected  $radio_checked;					//单选表单被选中的值
	protected  $checkbox_row; 		 			//多选表单的数组
	protected  $checked_row;					//多选表单中被选中的项目数组
	protected  $file_info;			 			//文件上传说明文档
	protected  $upload_img;                  	//图片上传
    protected  $country;                     	//ajax三级地址联查
    protected  $province;                    	//ajax省会
    protected  $city;                        	//ajax城市
    protected  $district;                    	//ajax地区

    protected  $country_str;                 	//ajax三级地址联查
    protected  $province_str;                	//ajax省会
    protected  $city_str;                    	//ajax城市
    protected  $district_str;                	//ajax地区
    protected  $back_url;                    	//返回链接
    protected  $code;                        	//输入code代码

	/*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    function __construct(){


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
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function text(){

    	$str  = '<div class="form-group">'
    	       .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
    	       .'<div class="col-md-4">'
    	       .Form::text($this->field , $this->value,['class'=>'form-control','id'=>$this->id])
    	       .'</div>'
    	       .'</div>';
    	return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串 禁止编辑表单
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function TextDisabled(){

        $str  = '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="col-md-4">'
               .Form::text($this->field , $this->value,['class'=>'form-control','id'=>$this->id,'disabled'=>'disabled'])
               .'</div>'
               .'</div>';
        return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function password(){

        $str  = '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="col-md-4">'
               .Form::password($this->field ,['class'=>'form-control','id'=>$this->id])
               .'</div>'
               .'</div>';
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function password_confirmation(){

        $str  = '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="col-md-4">'
               .Form::password($this->field ,['class'=>'form-control','id'=>$this->id])
               .'</div>'
               .'</div>';
        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field 				----------------- 表单的代码名称
    |  $name  				----------------- 表单的中文名称
    |  $option_list 		----------------- 表单的值
    |  $selected_name       ----------------- 被选中的下拉项的名称
    |  $selected_value      ----------------- 被选中的下拉项的值
    |  $id    				----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function select(){

    	$str  = '<div class="form-group">'
    			.Form::label($this->field,$this->name ,['class'=>'col-md-3 control-label'])
    			.'<div class="col-md-4">'
    			.'<select name="'.$this->field.'" id="'.$this->id.'" class="form-control">'
    			.'<option value="'.$this->selected_value.'" selected="selected">'.$this->selected_name.'</option>'
    			.$this->option_list
    			.'</select>'
    			.'</div>'
    			.'</div>';


    	return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field 				----------------- 表单的代码名称
    |  $name  				----------------- 表单的中文名称
    |  $radio_row   		----------------- 单选表单的选项数组值 ['name'=>'选中','value'=>1]
    |  $checked             ----------------- 被选中的项目值
    |  $id    				----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function radio(){

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


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field 				----------------- 表单的代码名称
    |  $name  				----------------- 表单的中文名称
    |  $radio_row   		----------------- 单选表单的选项数组值 ['name'=>'选中','value'=>1]
    |  $checked             ----------------- 被选中的项目值
    |  $id    				----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function checkbox(){

    	$str    		= '<div class="form-group">'
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


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function textarea(){

    	$str  = '<div class="form-group">'
    	       .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
    	       .'<div class="col-md-4">'
    	       .'<textarea name="'.$this->field.'"  id="'.$this->id.'" cols="65" rows="4" class="form-control">'
               .$this->value
               .'</textarea>'
    	       .'</div>'
    	       .'</div>';
    	return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  根据给定的表单类型 输出不同的模板字符串
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function upload_file(){

    	$str  = '<div class="form-group">'
    	       .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
    	       .'<div class="col-md-4">'
               .'<div class="file-offset">'
    	       .'<input type="file" name="'.$this->field.'" id="'.$this->id.'">'
    	       .'<span>'.$this->file_info.'</span>'
               .'</div>'
    	       .'</div>'
    	       .'</div>';

    	if($this->upload_img){

    		   $str .= '<div class="form-group">'
                    .'<div class="col-md-9 col-md-offset-3">'
                    . HTML::image($this->upload_img,'',['class'=>'img-thumbnail config-img'])
                    .'</div>'
                    .'</div>';
    	}

    	return $str;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  隐藏表单
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function hide(){

    	$str = '<input type="hidden" name="'.$this->field.'" value="'.$this->value.'" id="'.$this->id.'" >';

    	return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  输出所有权限分派表单
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function privi(){

        $privi_list                 = $this->get_privi_list();

        return $this->create_portlet($privi_list , 'blue');

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成权限表单的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet($privi_list , $color){

        $str                = '';

        foreach($privi_list as $item){

            $str            .= '<div class="panel panel-success box panel-privi-box '.$color.'">';
            $str            .= $this->create_portlet_title($item);
            $str            .= $this->create_portlet_body($item);
            $str            .= '</div>';
        }

        return $str; 
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成portlet_title的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet_title($item){


        $str        = '<div class="panel-heading">'
                      .$this->create_portlet_title_caption($item)

                      .'</div>';

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成portlet_title_caption的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet_title_caption($item){


        if(in_array($item->id, $this->value)){

            $checked       = 'checked = "checked"';
        }
        else{

            $checked       = '';
        }

        $str      = '<div class="caption">'
                   .'<i class="fa fa-cogs1"></i>'
                   .'<input type="checkbox"'
                   .' name="ids[]"'
                   .'value="'.$item->id.'" class="icheck privi_checkbox '
                   .$item->privi_code.'_checkbox "'
                   .' data-value="'.$item->privi_code.'"'
                   .' '.$checked.' '
                   .' data-checkbox="icheckbox_square-orange">'
                   .$item->privi_name.'['.$item->privi_code.']'
                   .'</div>';

        return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成portlet_title_caption_tools的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet_title_tools($item){


        $str            = '<div class="tools">'
                         .'<a href="javascript:;" class="collapse"></a>'
                         .'</div>';

        return $str;


    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成portlet_body的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet_body($item){

         $str               = '<div class="panel-body">'
                             .'<div class="table-scrollable">'
                             .$this->create_portlet_body_table($item)
                             .'</div>'
                             .'</div>';

         return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  生成portlet_body_table的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet_body_table($item){

          $str          = '<table class="table table-striped table-bordered table-hover">'
                        .$this->create_portlet_body_table_th()
                        .$this->create_portlet_body_table_main($item)
                        .'</table>';
          return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成portlet_body_table_th的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet_body_table_th(){

        $str            = '<tr>'
                         .'<th scope="col" class="tit">编号</th>'
                         .'<th scope="col">权限名称</th>'
                         .'<th scope="col">权限代码</th>'
                         .'<th scope="col">权限路由</th>'
                         .'<th scope="col">所属权限</th>'
                         .'</tr>';
        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  生成portlet_body_table_body的html元素
    |
    |-------------------------------------------------------------------------------
    */
    public function create_portlet_body_table_main($item){

        $str                        = '';


        foreach($item['child'] as $child){


            if(in_array($child->id , $this->value)){

                $checked   = 'checked = "checked"';
            }
            else{

                $checked   = '';
            }

            $str          .= '<tr>'
                            .'<td class="tit">'
                            .'<input type="checkbox" name="ids[]" '
                            .' value="'.$child->id.'"'
                            .' data-parent="'.$this->get_privi_code($child->parent_id).'"'
                            .' '.$checked.' '
                            .' class="icheck mycheckbox '.$this->get_privi_code($child->parent_id).'_item" >'
                            . $child->id
                            .'</td>'
                            .'<td>'.$child->privi_name.'</td>'
                            .'<td>'.$child->privi_code.'</td>'
                            .'<td>'.$child->privi_route.'</td>'
                            .'<td>'.$child->privi_name.'</td>'
                            .'</tr>';

        }



        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取父亲结点元素
    |
    |-------------------------------------------------------------------------------
    */
    public function get_privi_code($id){

        $privi              = Privi::find($id);

        if(empty($privi)){

            return '';
        }

        return $privi->privi_code;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |  ajax国家省会城市地区多级ajax联查
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值  $value['country'] / $value['province'] / $value['city']
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function pcd(){


        if($this->province && $this->province_str){

            $province_selected  = '<option value="'
                                  .$this->province
                                  .'" selected="selected">'
                                  .$this->province_str
                                  .'</option>';
        }
        else{

            $province_selected  = '';
        }


        if($this->city && $this->city_str){

            $city_selected  = '<option value="'
                                  .$this->city
                                  .'" selected="selected">'
                                  .$this->city_str
                                  .'</option>';
        }
        else{

            $city_selected  = '';
        }

        if($this->district && $this->district_str){

            $district_selected  = '<option value="'
                                  .$this->district
                                  .'" selected="selected">'
                                  .$this->district_str
                                  .'</option>';
        }
        else{

            $district_selected  = '';
        }

        $str    = '<div class="form-group">'
                 .Form::label('pcd',$this->name ,['class'=>'col-md-3 control-label'])
                 .'<div class="col-md-1">'
                 .'<select name="country" id="country" class="form-control">'
                 .'<option value="1" selected="selected">中国</option>'
                 .'</select>'
                 .'</div>'
                 .'<div class="col-md-1">'
                 .'<select name="province" id="province" class="form-control">'
                 .$province_selected
                 .$this->get_region_option_list(1)
                 .'</select>'
                 .'</div>'
                 .'<div class="col-md-1">'
                 .'<select name="city" id="city" class="form-control">'
                 .$city_selected
                 .'<option value="">请选择</option>'
                 .'</select>'
                 .'</div>'
                 .'<div class="col-md-1">'
                 .'<select name="district" id="district" class="form-control">'
                 .$district_selected
                 .'<option value="">请选择</option>'
                 .'</select>'
                 .'</div>'
                 .'</div>';

        return $str;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取省会地址
    |
    |-------------------------------------------------------------------------------
    */
    public function get_region_option_list($type){

         $str               = '';
         $region_list       = Region::where('region_type',$type)->get();

         foreach($region_list as $item){

             $str .='<option value="'.$item->region_id.'">'.$item->region_name.'</option>';
         }

         return $str;

    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出百度的富文本框编辑
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function ueditor(){

        $str  = '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="col-md-7">'
               .'<textarea name="'.$this->field.'"  id="'.$this->id.'" style="width:100%;height:500px;">'.$this->value.'</textarea>'
               .'</div>'
               .'</div>';
        return $str;


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出百度的富文本框编辑
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function ueditor_big(){

        $str  = '<div class="form-group">'

               .'<div class="col-md-12">'
               .'<textarea name="'.$this->field.'"  id="'.$this->id.'" style="width:100%;height:500px;">'.$this->value.'</textarea>'
               .'</div>'
               .'</div>';
        return $str;


    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输入新闻的示范代码 用高亮显示代码
    |
    |  $field ----------------- 表单的代码名称
    |  $name  ----------------- 表单的中文名称
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function code(){

        $str  = '<div class="form-group">'
               .Form::label($this->field , $this->name , ['class'=>'col-md-3 control-label'])
               .'<div class="col-md-7">'
               .'<textarea name="'.$this->field.'"  id="'.$this->id.'" cols="100" rows="20" class="form-control">'
               .$this->value
               .'</textarea>'
               .'</div>'
               .'</div>';


                //如果已经添加了代码
                if($this->value){

                    $str    .= '<div class="form-group">'
                            .'<div class="col-md-offset-3 col-md-7">'
                            .'<pre class="prettyprint linenums" style="font-size:20px;">'
                            .$this->value
                            .'</pre>'
                            .'</div>'
                            .'</div>';
                }


        return $str;
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |  确认表单
    |
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function submit(){

    	$str = '<div class="form-actions fluid">'
              .'<div class="col-md-offset-3 col-md-9">'
    		  .'<input type="submit" class="btn btn-success" id="'.$this->id.'" value="'.$this->value.'">'
              .'&nbsp;&nbsp;<a href="'.$this->back_url.'" class="btn btn-danger">返回</a>'
              .'</div>'
              .'</div>';

    	return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  确认表单
    |
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function submit2(){

        $str = '<div class="form-group">'
              .'<div class="col-md-offset-3 col-md-9">'
              .'<input type="submit" class="btn btn-primary" id="'.$this->id.'" value="'.$this->value.'">'
              .'&nbsp;&nbsp;<a href="'.$this->back_url.'" class="btn btn-danger">返回</a>'
              .'</div>'
              .'</div>';

        return $str;
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |  输出一个纯粹的html元素按钮
    |
    |  $value ----------------- 表单的值
    |  $id    ----------------- 表单的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function button(){

        $str  =  '<div class="form-group">'
                .'<div class="col-md-offset-3 col-md-9">'
                .'<span class="btn btn-success search-btn" id="'.$this->id.'">'.$this->name.'</span>'
								.'&nbsp;&nbsp;&nbsp;&nbsp;'
								.'<a href="'.$this->back_url.'" class="btn btn-info">返回所有记录</a>'
                .'</div>'
                .'</div>';

        return $str;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取系统权限
    |
    |-------------------------------------------------------------------------------
    */
    public function get_privi_list(){

        $privi_list                = Privi::where('parent_id',0)->paginate(20);

        foreach($privi_list as $item){

            $item['child']         = Privi::where('parent_id',$item->id)->get();
        }

        return $privi_list;

    }



    /*
    |-------------------------------------------------------------------------------
    |
    |  生成属性下拉筛选菜单
    |
    |-------------------------------------------------------------------------------
    */
    public function goods_attr(){


        $str  = '<div class="form-group">'
                .Form::label($this->field,$this->name ,['class'=>'col-md-3 control-label'])
                .'<div class="col-md-4">'
                .'<select name="'.$this->field.'" id="'.$this->id.'" class="form-control">'
                .'<option value="'.$this->selected_value.'" selected="selected">'.$this->selected_name.'</option>'
                .$this->option_list
                .'</select>'
                .'</div>'
                .'<div class="col-md-2">'
                .'<span class="btn blue add-attr-btn">'
                .'<i class="fa fa-plus" style="color:#fff;padding:0 3px"></i>'
                .'添加属性'
                .'</span>'
                .'</div>'
                .'</div>'
				.'<div class="attr-div">';



				if(empty($this->value)){

					 return $str.'</div>';
				}

				foreach($this->value as $key=>$value){

						 $attr_name 		= Common::get_attr_name($value->attr_id);
					   $str 	  .= '<div class="form-group">'
											.'<label class="col-md-3 control-label">'.$attr_name.'</label>'
											.'<div class="col-md-2">'
											.'<input type="text" class="form-control" name="attr_value_list[]" value="'.$value->attr_value.'">'
											.'</div>'
											.'<label class="col-md-1 control-label">价格：</label>'
											.'<div class="col-md-2">'
											.'<input type="text" class="form-control" name="attr_price_list[]" value="'.$value->attr_price.'">'
											.'</div>'
											.'<input type="hidden" name="attr_ids[]" value="'.$value->attr_id.'">'
                      .'<div class="col-md-1"><span class="btn red attr-del-btn"><i class="fa fa-times"></i>删除</span></div>'
			  							.'</div>';
			 }


        return  $str .'</div>';
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  输出div元素
    |
    |  $name  ----------------- div的中文名称
    |  $value ----------------- div的内容
    |  $id    ----------------- div的id值
    |
    |-------------------------------------------------------------------------------
    */
    public function div(){

        $str        = '<div id="'.$this->id.'">'
                      .$this->value
                      .'</div>';
        return $str;
    }


}
