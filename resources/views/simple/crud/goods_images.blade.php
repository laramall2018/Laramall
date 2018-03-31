@extends('simple.layout.common')
@section('title')
{!!$title!!}
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

@section('script')
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('files/bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('files/jquery.confirm.js')!!}
{!!HTML::script('static/js/jquery.json-2.4.js')!!}
{!!HTML::script('static/js/phpstore.grid.js')!!}
@stop


@section('content')

<div class="content-box">

	<div class="row">
    	<div class="col-md-12">
        	{!!$path_url!!}
        </div>
    </div>

    <div class="panel panel-info">
    	<div class="panel-heading">设置商品图片尺寸</div>
        <div class="panel-body">
        
        	{!!Form::open(['url'=>'admin/goods/config','method'=>'post','class'=>'form-horizontal'])!!}
            	<div class="form-group">
                		<label class="col-md-3 control-label">缩略图宽度</label>
                        <div class="col-md-4">
                        	<input type="text" class="form-control" name="thumb_width" value="{!!$thumb_width!!}" />
                        </div>
                </div><!--/form-group-->
                <div class="form-group">
                		<label class="col-md-3 control-label">缩略图高度</label>
                        <div class="col-md-4">
                        	<input type="text" class="form-control" name="thumb_height" value="{!!$thumb_height!!}" />
                        </div>
                </div><!--/form-group-->
                <div class="form-group">
                		<label class="col-md-3 control-label">商品图片宽度</label>
                        <div class="col-md-4">
                        	<input type="text" class="form-control" name="img_width" value="{!!$img_width!!}" />
                        </div>
                </div><!--/form-group-->
                <div class="form-group">
                		<label class="col-md-3 control-label">商品图片高度</label>
                        <div class="col-md-4">
                        	<input type="text" class="form-control" name="img_height" value="{!!$img_height!!}" />
                        </div>
                </div><!--/form-group-->
                <div class="form-group">
                	<div class="col-md-4 col-md-offset-3">
                    	<input type="submit" class="btn btn-success" value="设置" />
                    </div>
                </div>
            {!!Form::close()!!}
        
        </div><!--/panel-body-->
    </div>
 
    
    
     <div class="panel panel-success">
     	
        <div class="panel-heading">商品图片列表</div>
        <div class="panel-body">
     	
        <table class="table table-striped table-bordered table-hover ajax-sort-tab">
        	<tr>
            	<th style="width:50px;">
                	<input type="checkbox" name="select_all" class="icheck mycheckbox checkbox"  />
                </th>
                <th style="width:60px;">编号</th>
                <th>商品名称</th>
                <th>缩略图</th>
                <th>商品图片</th>
                <th>原始图片</th>
            </tr>
            @if($grid)
            @foreach($grid as $item)
            	<tr>
                	<td>
                    	<input type="checkbox" name="ids[]" class="icheck mycheckbox checkbox-item" value="{!!$item->id!!}" />
                    </td>
                    <td>
                    {{$item->id}}
                    </td>
                    <td>{{$item->goods->goods_name}}</td>
                    <td>
                    	@if($item->thumb())
                        <a href="{{$item->thumb()}}" target="_blank">
                        	<img src="{{$item->thumb()}}" class="img-thumbnail" style="width:100px;" />
                        </a>
                        @endif
                    </td>
                    <td>
                    	@if($item->img)
                        <a href="{{$item->img()}}" target="_blank">
                        	<img src="{{$item->img()}}" class="img-thumbnail" style="width:100px;" />
                        </a>
                        @endif
                    </td>
                    <td>
                    	@if($item->original)
                        <a href="{{$item->_original()}}" target="_blank">
                        	<img src="{{$item->_original()}}" class="img-thumbnail" style="width:100px;" />
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            @endif
        </table>
        
        </div><!--/panel-body-->
     </div><!--/panel-->
    
    <div class="form-group">
    	<span class="btn btn-success" id="image-redo-btn">
        	<span class="glyphicon glyphicon-repeat"></span>
            立即生成
        </span>
    </div>
    
    <div class="content">
    <div class="panel panel-success" id="redo-btn" style="display:none;">
    <div class="panel-heading">商品生成状态</div>
    <div class="panel-body" id="redo-ajax-btn">
    	
       
        
    </div>
    </div>
    </div>
    
   
    
    
    <div id="ajax-page-bar">
        <div id="ajax-page">
         {!!$grid->render()!!}
        </div>
        <div class="ajax-total">
        总记录为：{!!$grid->total()!!}
        </div>
        </div>
     
    </div><!--/content-->
    
</div><!--/widget-->
<script type="text/javascript">
	ps.icheckbox();
    ps.privi_checkbox();
	ps.confirm();
	ps.batch();
	ps.image.resize("{!!url('admin/goods/image/redo')!!}",'{!!$current_page!!}',"{!!$last_page!!}","{!!$per_page!!}","{!!$total!!}");
</script>
@stop

