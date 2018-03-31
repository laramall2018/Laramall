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
        <div class="panel-heading">发货</div>
        <div class="panel-body">
            {!!Form::open(['url'=>'admin/order/express','method'=>'post','files'=>true,'class'=>'form-horizontal common-form'])!!}
            
             <div class="form-group">
                <label class="col-md-3 control-label">快递公司</label>
                <div class="col-md-4">
                    <input type="text" name="express_name" id="express_name" value="{!!$model->shipping_name!!}" class="form-control"> 
                </div>
             </div>
            <div class="form-group">
                <label class="col-md-3 control-label">收货人</label>
                <div class="col-md-4">
                    <input type="text" name="consignee" id="consignee" value="{!!$model->consignee!!}" class="form-control"> 
                </div>
             </div>
            <div class="form-group">
                <label class="col-md-3 control-label">收货地址</label>
                <div class="col-md-4">
                    <input type="text" name="address" id="address" value="{!!$address!!}" class="form-control"> 
                </div>
             </div>
            <div class="form-group">
                <label class="col-md-3 control-label">联系电话</label>
                <div class="col-md-4">
                    <input type="text" name="phone" id="phone" value="{!!$model->phone!!}" class="form-control"> 
                </div>
             </div>
            <div class="form-group">
                <label class="col-md-3 control-label">订单号</label>
                <div class="col-md-4">
                    <input type="text" name="order_sn" id="order_sn" value="{!!$model->order_sn!!}" class="form-control"> 
                </div>
             </div>
            <div class="form-group">
                <label class="col-md-3 control-label">快递单号</label>
                <div class="col-md-4">
                    <input type="text" name="express_sn" id="express_sn" value="{!!$express_sn!!}" class="form-control"> 
                </div>
             </div>
            <input type="hidden" name="order_id" value="{!!$model->id!!}">
             <div class="form-group">
             <div class="col-md-4 col-md-offset-3">
                 <input type="submit" class="btn btn-success" value="确认发货">
                 <a href="{!!url('admin/order/'.$model->id.'/edit')!!}" class="btn btn-info">
                     <span class="glyphicon glyphicon-chevron-left"></span>返回
                 </a>
             </div>
             </div>
            
            {!!Form::close()!!}
        </div>
    </div><!--/panel-->
    </div><!--/col-md-12-->
</div><!--/row-->

</div><!--/content-box-->
@stop