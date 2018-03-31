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

   
    {!!Form::open(array('url'=>$batch_url,'method'=>'post','class'=>'common-form'))!!}
    	
	 <div id="ajax-box">
     
     	<div class="panel panel-success">
        	
            <div class="panel-heading">颜色属性</div>
            <div class="panel-body">
        
            	<table class="table table-striped table-bordered table-hover ajax-sort-tab">
                <tr>
                	<th style="width:50px;">
                    	<input type="checkbox" name="select_all" class="icheck mycheckbox checkbox" />
                    </th>
                    <th>编号</th>
                    <th>商品名称</th>
                    <th>商品类型</th>
                    <th>商品属性</th>
                    <th>商品属性值</th>
                    <th>颜色16进制值</th>
                    <th>颜色图片</th>
                    <th>相关操作</th>
                </tr>
                @foreach($grid as $item)
                    <tr>
                    
                    	<td>
                        	<input type="checkbox" name="ids[]" class="icheck mycheckbox checkbox-item" value="{!!$item->id!!}" />
                        </td>
                        <td>{!!$item->id!!}</td>
                        <td>{!!$item->goods_name!!}</td>
                        <td>{!!$item->type_name!!}</td>
                        <td>{!!$item->attr_name!!}</td>
                        <td>{!!$item->attr_value!!}</td>
                        <td>
                        	@if($item->color_value)
                            <span class="color-btn" style="background:{!!$item->color_value!!}">{!!$item->color_value!!}</span>
                            @endif
                         </td>
                        <td>
                        @if($item->color_img)
                        	<a href="{!!url($item->color_img)!!}" target="_blank">
                            <img src="{!!url($item->color_img)!!}" style="width:100px;" />
                            </a>
                        @endif
                        </td>
                        <td style="width:180px;">
                        	<a href="{!!url('admin/color/'.$item->id.'/edit')!!}" class="btn btn-primary">
                            	<span class="glyphicon glyphicon-plus"></span>
                                操作
                            </a>
                            <a href="{!!url('admin/color/del/'.$item->id)!!}" class="btn btn-danger">
                            	<span class="glyphicon glyphicon-remove"></span>
                                删除
                            </a>
                            
                        </td>
                    </tr>
                @endforeach
            </table>
           
           </div>
            
        </div><!--/panel-->
        
      </div>
	
	{!!Form::hidden('del_type','delete',array('id'=>'del_type'))!!}
	
    
    
    {!!$batch_btn!!}
    
    {!!Form::close()!!}
    
    
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
</script>
@stop

