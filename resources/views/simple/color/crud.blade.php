@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('script')
{!!HTML::script('files/jquery.validate.min.js')!!}
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('static/tinycolorpicker/jqColorPicker.min.js')!!}
{!!HTML::script('static/tinycolorpicker/index.js')!!}
{!!$form_validate_url!!}
{!!$crud_js!!}
@stop

@section('description')
{!!$description!!}
@stop

@section('keywords')
{!!$keywords!!}
@stop

@section('appname')
{!!$appname!!}
@stop


@section('content')

    <div class="content-box">
    	
       {!!$path_url!!}
    	
       <div class="panel panel-success">
  					<div class="panel-heading">{!!$action_name!!}</div>
  					<div class="panel-body">
    					
                        {!!Form::open(['url'=>'admin/color/'.$row->id,'method'=>'post','class'=>'form-horizontal','files'=>'true'])!!}
                        
                        	<div class="form-group">
                            	<label class="col-md-3 control-label">商品名称</label>
                                <div class="col-md-4">
                                	<input type="text"  disabled="disabled" class="form-control" value="{!!$row->goods_name!!}" />
                                </div>
                            </div><!--/form-group-->
                            <div class="form-group">
                            	<label class="col-md-3 control-label">商品类型</label>
                                <div class="col-md-4">
                                	<input type="text"  disabled="disabled" class="form-control" value="{!!$row->type_name!!}" />
                                </div>
                            </div><!--/form-group-->
                            <div class="form-group">
                            	<label class="col-md-3 control-label">属性名称</label>
                                <div class="col-md-4">
                                	<input type="text"  disabled="disabled" class="form-control" value="{!!$row->attr_name!!}" />
                                </div>
                            </div><!--/form-group-->
                            <div class="form-group">
                            	<label class="col-md-3 control-label">属性值</label>
                                <div class="col-md-4">
                                	<input type="text"  disabled="disabled" class="form-control" value="{!!$row->attr_value!!}" />
                                </div>
                            </div><!--/form-group-->
                            
                            <div class="form-group">
                            	<label class="col-md-3 control-label">颜色值</label>
                                <div class="col-md-4">
                                	<input type="text" name="color_value" id="color_value" class="form-control color no-alpha"  value="{!!$row->color_value!!}" />
                                </div>
                            </div><!--/form-group-->
                            
                            <div class="form-group">
                            	<label class="col-md-3 control-label">属性图片</label>
                                <div class="col-md-4">
                                	<input type="file" name="color_img" />
                                </div>
                            </div><!--/form-group-->
                            
                            @if($row->color_img)
                            <div class="form-group" id="color-img-content">
                            	<div class="col-md-4 col-md-offset-3">
                                	<img src="{!!url($row->color_img)!!}" class="img-thumbnail" style="width:100px;" />
                                </div>
                                
                            </div>
                            @endif
                            
                        	<input type="hidden" name="id" id="id" value="{!!$row->id!!}" />
                            <input type="hidden" name="_method" id="method" value="PUT" />
                            <div class="form-group">
                            	<div class="col-md-4 col-md-offset-3">
                                	<button type="submit" class="btn btn-success">
                                    	<span class="glyphicon glyphicon-ok"></span>
                                        确认
                                    </button>
                                    @if($row->color_img)
                                    <span class="btn btn-danger" data-id="{!!$row->id!!}" id="color-img-del-btn">
                                    	<i class="fa fa-times"></i>
                                        删除图片
                                    </span>
                                    @endif
                                    <a href="{!!url('admin/color')!!}" class="btn btn-info">
                                    	<span class="glyphicon glyphicon-circle-arrow-left"></span>
                                        返回
                                    </a>
                                </div>
                            </div>
                        {!!Form::close()!!}
                        
  					</div>
				</div>
                
    </div>
 
 <script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	$(function(){
		
		$('.color').colorPicker();
	});
	ps.color_del("{!!url('admin/color/img-del')!!}");
</script>
@stop
