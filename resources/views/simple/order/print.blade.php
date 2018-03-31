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


@section('content')
{!!HTML::style('static/icheck/skins/all.css')!!}
{!!HTML::script('static/icheck/icheck.js')!!}
{!!HTML::script('static/js/jquery.json-2.4.js')!!}

<div class="content-box">
<div class="row">
<div class="col-md-12">
    {!!$path_url!!}
</div>
</div><!--/row-->
    
<div class="row">
    <div class="col-md-12">
    <div class="panel panel-success">
        <div class="panel-heading">订单打印</div>
        <div class="panel-body">
            {!!Form::open(['url'=>'admin/order/print','method'=>'post','files'=>true,'class'=>'form-horizontal common-form','target'=>'_blank'])!!}
            
             <div class="form-group">
                <label class="col-md-3 control-label">选择订单</label>
                <div class="col-md-4">
                    <select name="order_sn" class="form-control">
                    	<option value="">请选择</option>
                    	@foreach($order_list as $item)
                    	<option value="{!!$item->order_sn!!}">{!!$item->order_sn!!}</option>
                    	@endforeach
                    </select>
                </div>
             </div><!--/form-group-->
             <div class="form-group">
             	<div class="col-md-4 col-md-offset-3">
             		 <button type="submit" class="btn btn-success">
             		 	确认打印
             		 	<span class="glyphicon glyphicon-ok-sign"></span>
             		 </button>
             		 <a href="{!!url('admin/order')!!}" class="btn btn-info">
             		 	<span class="glyphicon glyphicon-arrow-left"></span>
             		 	返回列表
             		 </a>
             	</div><!--/col-md-4-->
             </div>
             
             {!!Form::close()!!}
         </div><!--/panel-body-->
     </div><!--/panel-->
 @stop
