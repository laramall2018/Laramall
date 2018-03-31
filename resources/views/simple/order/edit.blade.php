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
    
     <!--/订单基本信息-->
     <div class="panel panel-success">
     	<div class="panel-heading">
        	<h5>订单信息</h5>
        </div>
        <div class="panel-body">
        	
        	 <div class="alert alert-success">
        	 	<span>订单当前状态：</span>
        	 	<span class="org">{!!$order_status!!}</span>
        	 </div>
        	 <div class="alert alert-info">
        	 	<div class="row">
        	 	<div class="col-md-8">
        	 	<a href="{!!url('admin/order/done?act=cancel&id='.$order->id)!!}" class="btn btn-danger">
        	 	<span class="glyphicon glyphicon-remove"></span>
        	 	取消订单
        	 	</a>
        	 	
        	 	  <a href="{!!url('admin/order/done?act=submit&id='.$order->id)!!}" class="btn btn-success">
        	 	   <span class="glyphicon glyphicon-ok"></span>
        	 	   确认订单
        	 	  </a>
        	 	  
        	 	  <a href="{!!url('admin/order/done?act=payno&id='.$order->id)!!}" 
        	 	   class="btn btn-danger">
        	 	    <span class="glyphicon glyphicon-remove"></span>
        	 	    取消支付
        	 	    </a>
        	 	  <a href="{!!url('admin/order/done?act=pay&id='.$order->id)!!}" class="btn btn-success">
        	 	  <span class="glyphicon glyphicon-ok"></span>
        	 	  确认支付
        	 	  </a>
        	 	  
        	 	   <a href="{!!url('admin/order/done?act=shippingno&id='.$order->id)!!}" class="btn btn-danger">
        	 	      <span class="glyphicon glyphicon-ok"></span>
        	 	      取消发货
        	 	      </a>
        	 	   <a href="{!!url('admin/order/done?act=shipping&id='.$order->id)!!}" class="btn btn-success">
        	 	    <span class="glyphicon glyphicon-ok"></span>
        	 	    确认发货
        	 	    </a>
        	 	    
        	 	    <a href="{!!url('admin/order')!!}" class="btn btn-info">
        	 	      <span class="glyphicon glyphicon-chevron-left"></span>
        	 	      返回订单
        	 	      </a>
        	 	    
        	 	   
        	 	   </div><!--/col-md-10-->
        	 	   <div class="col-md-4 text-right">
        	 	   		<a href="{!!url('admin/order/done?act=all&id='.$order->id)!!}" class="btn btn-success">
        	 	   			<span class="glyphicon glyphicon-ok"></span>
        	 	   			一键确认
        	 	   		</a>
        	 	  		<a href="{!!url('admin/return')!!}" class="btn btn-info">
        	 	  		<span class="glyphicon glyphicon-repeat"></span>
        	 	  		处理退货
        	 	  		</a>
        	 	   </div>
        	 	  </div><!--/row-->
        	 </div>
        	
            <div class="panel panel-default">
            	<div class="panel-heading">
                	<h5><span class="glyphicon glyphicon-th-list"></span>订单基本信息</h5>
                </div>
                <div class="panel-body">
                	<table class="table table-bordered table-hover table-striped table-condensed">
            	<tr>
                	<th>订单编号</th>
                    <td>{!!$order->order_sn!!}</td>
                    <th>下单会员</th>
                    <td>{!!$username!!}</td>
                </tr>
                <tr>
                	<th>订单状态</th>
                    <td>{!!$order_status!!}</td>
                    <th>下单时间</th>
                    <td><?php echo date("Y-m-d",$order->add_time);?></td>
                </tr>
                <tr>
                	<th>商品总金额</th>
                    <td>{!!$order->goods_amount!!}</td>
                    <th>运输费用</th>
                    <td>{!!$order->shipping_fee!!}</td>
                </tr>
                <tr>
                	<th>配送方式</th>
                    <td>
                        {!!$order->shipping_name!!}
                        @if($order->shipping_status == 1)
                            {!!$express_sn!!}
                        @endif
                    </td>
                    <th>支付方式</th>
                    <td>{!!$order->pay_name!!}</td>
                </tr>
                <tr>
                	<th>订单总金额</th>
                    <td class="red"><strong>{!!$order->order_amount!!}</strong></td>
                    <th>订单来源</th>
                    <td>{!!$order->referer!!}</td>
                </tr>
                <tr>
                	<th>下单IP</th>
                    <td>{!!$order->ip!!}</td>
                    <th>订单备注</th>
                    <td>{!!$order->order_note!!}</td>
                </tr>
            </table>
                </div>
            </div><!--/panel-->
            
            <div class="panel panel-default">
            	<div class="panel-heading">
                	<h5><span class="glyphicon glyphicon-th-list"></span>订单收货地址</h5>
                </div>
                <div class="panel-body">
                	<table class="table table-bordered table-hover table-striped table-condensed">
            			<tr>
                        	<th>收货人姓名</th>
                            <th>收货地址</th>
                            <th>物流状态</th>
                            <th>相关操作</th>
                        </tr>
                        <tr>
                        	<td>{!!$order->consignee!!}</td>
                            <td>{!!$address!!}</td>
                            <td>{!!$shipping_status!!}</td>
                            <td>
                            	
                                <a href="{!!url('admin/order/done?act=express&id='.$order->id)!!}" class="btn btn-info">
                                    添加发货单
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                </a>
                               
                            
                            </td>
                        </tr>
                   </table>
                </div><!--/panel-body-->
            </div><!--/panel-->
            
            <div class="panel panel-default">
            	<div class="panel-heading">
                	<h5><span class="glyphicon glyphicon-th-list"></span>订单产品</h5>
                </div>
                <div class="panel-body">
                	<table class="table table-bordered table-hover table-striped table-condensed">
            			<tr>
                        	<th style="width:120px;">商品图片</th>
                            <th>商品名称</th>
                            <th>商品价格</th>
                            <th>购买数量</th>
                            <th>总计</th>
                           
                        </tr>
                        @if($goods_list)
                        @foreach($goods_list as $item)
                        <tr>
                        	<td style="vertical-align:middle; text-align:center;">
                            	@if($item->goods->thumb())
                            	<img src="{{$item->goods->thumb()}}" class="order-img img-thumbnail" style="width:100px;height:100px;" />
                                @else
                                <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" class="order-img img-thumbnail" style="width:100px;height:100px;" />
                                @endif
                            </td>
                            <td style="vertical-align:middle; text-align:center;">
                            	<a href="{{$item->goods->url()}}" target="_blank">
                                    {!!$item->goods_name!!}
                                    <span style="color: #ff6600;">{{$item->goods_attr}}</span>
                                </a>
                            </td>
                            <td style="vertical-align:middle; text-align:center;">
                            	{!!$item->shop_price!!}
                            </td>
                            <td style="vertical-align:middle; text-align:center;">
                            	{!!$item->goods_number!!}
                            </td>
                            <td style="vertical-align:middle; text-align:center;">
                            	{{$item->total()}}
                            </td>
                        </tr>
                        @endforeach
                        @endif
                   </table>
                </div><!--/panel-body-->
            </div>
            
            
            <div class="alert alert-success order-total-btn">
            	<div class="row">
                	<div class="col-md-2">
                    	商品总价：<span class="num">{!!$order->goods_amount!!}</span>
                    </div>
                    <div class="col-md-2">
                    	运输费用：<span class="num">{!!$order->shipping_fee!!}</span>
                    </div>
                    <div class="col-md-2">
                    	订单总价：<span class="num">{!!$order->order_amount!!}</span>
                    </div>
                 </div>
            </div>
            
            @if($order_log)
            <div class="panel panel-success">
                <div class="panel-heading">订单操作日志</div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <tr>
                            <th>管理员</th>
                            <th>订单编号</th>
                            <th>操作说明</th>
                            <th>操作时间</th>
                        </tr>
                        @foreach($order_log as $item)
                        <tr>
                            <td>{!!$item->username!!}</td>
                            <td>{!!$item->order_sn!!}</td>
                            <td>{!!$item->log!!}</td>
                            <td>
                            <?php echo date('Y-m-d',$item->add_time);?>
                            </td>
                        
                        </tr>
                        @endforeach
                    
                    </table>
                </div>
            </div><!--/panel-->
            @endif
            
            <a href="{!!url('admin/order')!!}" class="back-btn text-center">
            	<span class="glyphicon glyphicon-chevron-left"></span>
                
             </a>
            
        </div><!--/panel-body-->
     </div><!--/panel-->
    
    
    </div><!--/content-box-->
@stop