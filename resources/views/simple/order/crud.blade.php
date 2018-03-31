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
<script type="text/javascript">
$(function(){
	
	ps.goods_tab();
});
</script>
	
    <div class="content-box">
    <div class="row">
    	<div class="col-md-12">
        {!!$path_url!!}
        </div>
    </div><!--/row-->
    
    <div class="row">
    <div class="col-md-12">
       
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="caption">
					<i class="fa fa-cog"></i>{!!$action_name!!}
				</div>
			</div><!--/panel-heading-->
			
            <div class="panel-body">
			    
               <div class="ps-tab">
                  
                   
                   {!!Form::open(['url'=>'admin/order','method'=>'post','files'=>true,'class'=>'form-horizontal'])!!}
                   
                    <ul class="ps-tab-title">
                    	<li class="cur">下单会员</li>
                        <li>订单产品</li>
                        <li>收货人地址</li>
                        <li>支付方式</li>
                        <li>物流信息</li>
                       
                       
                        
                    </ul>
                    
                    <div class="ps-tab-content">
                    		
                       @include('simple.order.lib.base')
                       @include('simple.order.lib.goods')
                       @include('simple.order.lib.address')
                       @include('simple.order.lib.payment')
                       @include('simple.order.lib.shipping')
                       
                    </div>
                        
                        <div class="alert alert-success">
                        	所有信息都添加完毕后 再递交确认按钮
                        </div>
                    	<div class="form-group">
                        	<div class="col-md-offset-3 col-md-9">
                            	<input type="submit" name="submit" class="btn btn-primary" value="确认添加" />
                                <a href="{!!url('admin/order')!!}" class="btn btn-danger">返回</a>
                            </div>
                        </div><!--/form-group-->              
               		{!!Form::close()!!}
               </div><!--/ps-tab-->
               
			</div><!--/portlet-body-->
                                    
		</div><!--/portlet-->
													
    </div><!--/col-md-12-->
    </div><!--/row-->
    </div><!--/content-box-->
@stop