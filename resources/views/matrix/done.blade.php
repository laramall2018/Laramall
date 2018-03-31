@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />

   @include('matrix.lib.breadcrumb')
   
   <div class="container">
   		
        <div class="panel panel-success">
        	<div class="panel-heading">
            <h5>您已经成功下单</h5>
            </div>
            <div class="panel-body">
            	
                <div class="alert alert-info order-done">
                	<div class="row">
                    	<div class="col-md-6">
                        	<span>订单编号：{!!$order->order_sn!!}</span>
                            
                            <a class="pad10" href="{!!url('auth/center')!!}">{!!trans('front.user_center')!!}</a>
                            
                        </div>
                        <div class="col-md-6 text-right">
                        	<span class="num">订单金额:{!!$order->order_amount!!}</span>
                        </div>
                        
                    </div>
                </div>
                
                <div class="alert alert-info order-done-pay">
                	@if($pay_btn)
                    {!!$pay_btn!!}
                    @endif
                </div>
                
            </div><!--/panel-body-->
        </div>
   
   </div><!--/container-->
@stop