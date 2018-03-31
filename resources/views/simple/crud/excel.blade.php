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

    
 	
    <div class="alert alert-info">
    	<a href="{!!url('admin/excel/in')!!}" class="btn btn-success">
        	<span class="glyphicon glyphicon-log-in"></span>
            导入excel
        </a>
    </div>
    {!!Form::open(array('url'=>$batch_url,'method'=>'post','class'=>'common-form'))!!}
	
	{!!Form::hidden('del_type','all',array('id'=>'del_type'))!!}
     <div class="panel panel-success">
     	
        <div class="panel-heading">Excel导入导出</div>
        <div class="panel-body">
     	
        <table class="table table-striped table-bordered table-hover ajax-sort-tab">
        	<tr>
            	<th style="width:50px;">
                	<input type="checkbox" name="select_all" class="icheck mycheckbox checkbox"  />
                </th>
                <th style="width:60px;">编号</th>
                <th>商品名称</th>
                <th style="width:110px;">缩略图</th>
                <th>分类</th>
                <th>品牌</th>
                <th>库存</th>
                <th>新品</th>
                <th>精品</th>
                <th>热卖</th>
                <th>促销</th>
                <th>上线</th>
               
            </tr>
            @if($grid)
            @foreach($grid as $item)
            	<tr>
                	<td>
                    	<input type="checkbox" name="ids[]" class="icheck mycheckbox checkbox-item" value="{!!$item->id!!}" />
                    </td>
                    <td>
                    {!!$item->id!!}
                    </td>
                    <td>{!!$item->goods_name!!}</td>
                    <td>
                    	@if($item->thumb)
                        <a href="{!!url($item->img)!!}" target="_blank">
                        	<img src="{!!url($item->thumb)!!}" class="img-thumbnail" style="width:100px;" />
                        </a>
                        @endif
                    </td>
                    <td>
                    	{!!$item->cat_name!!}
                    </td>
                    <td>{!!$item->brand_name!!}</td>
                    <td>{!!$item->goods_number!!}</td>
                    <td>
                    	@if($item->is_new == 1)
                        <span class="green">
                        <i class="fa fa-check"></i>
                        </span>
                        @else
                        <i class="fa fa-times org"></i>
                        @endif
                    </td>
                    <td>
                    	@if($item->is_best == 1)
                        <i class="fa fa-check green"></i>
                        @else
                        <i class="fa fa-times org"></i>
                        @endif
                    </td>
                    <td>
                    	@if($item->is_hot == 1)
                        <i class="fa fa-check green"></i>
                        @else
                        <i class="fa fa-times org"></i>
                        @endif
                    </td>
                    <td>
                    	@if($item->is_promote == 1)
                        <i class="fa fa-check green"></i>
                       
                        @else
                        <i class="fa fa-times org"></i>
                        @endif
                    </td>
                    <td>
                    	@if($item->is_on_sale == 1)
                        <i class="fa fa-check green"></i>
               
                        @else
                        <i class="fa fa-times org"></i>
                        @endif
                    </td>
                    
                </tr>
            @endforeach
            @endif
        </table>
        
        </div><!--/panel-body-->
     </div><!--/panel-->
     
     <div class="form-group">
    	
        <span class="btn del-btn btn-primary" data-value="select">
        	<i class="feature-icon fa fa-upload"></i>导出选中
        </span>
        <a href="{!!url('admin/excel/all')!!}" class="btn btn-success">
        	<span class="glyphicon glyphicon-download"></span>导出全部
        </a>
    
    </div><!--/form-group-->
     
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

