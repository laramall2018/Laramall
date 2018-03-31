
<div class="col-md-9">

<div class="panel panel-default">
<div class="panel-heading">
	 
	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.order_detail')!!}</span>
    </h5>
 </div>

<div class="panel-body">

	<table class="table table-bordered table-hover">
    	@if($order)
        <tr>
        	<th>{!!trans('front.order_sn')!!}</th>
            <td>{!!$order->order_sn!!}</td>
        </tr>
        <tr>
            <th>订单来源</th>
            <td>{{$order->order_from}}</td>
        </tr>
        
        <tr>
        	<th>{!!trans('front.goods_amount')!!}</th>
            <td>{!!$order->goods_amount!!}</td>
        </tr>
        
        <tr>
        	<th>{!!trans('front.shipping_fee')!!}</th>
            <td>{!!$order->shipping_fee!!}</td>
        </tr>
        <tr>
        	<th>{!!trans('front.order_amount')!!}</th>
            <td>{!!$order->order_amount!!}</td>
        </tr>
        <tr>
        	<th>{!!trans('front.order_status')!!}</th>
            <td>{!!$order_status!!}</td>
        </tr>
        <tr>
        	<th>{!!trans('front.shipping')!!}</th>
            <td>{!!$order->shipping_name!!}</td>
        </tr>
        <tr>
            <th>收货人姓名</th>
            <td>{{$order->consignee}}</td>
        </tr>
        <tr>
            <th>收货人电话</th>
            <td>{{$order->phone}}</td>
        </tr>
        <tr>
            <th>收货地址</th>
            <td>{{$order->address()}}</td>
        </tr>
        <tr>
        	<th>{!!trans('front.payment')!!}</th>
            <td>
            	{!!$order->pay_name!!}
                @if($order->pay_status == 0)
                {!!$pay_btn!!}
                @endif
            </td>
        </tr>
        @endif
    </table>

</div><!--/panel-body-->
</div><!--/panel-->


<div class="panel panel-default">
<div class="panel-heading">
	 
	<h5>
    	<span class="glyphicon glyphicon-th-list"></span>
        <span class="tit">{!!trans('front.goods_list')!!}</span>
    </h5>
 </div>

<div class="panel-body">

	<table class="table table-bordered table-hover table-striped cart-table">
   		
        <tr>
        	
            <th style="width:110px;">{!!trans('front.thumb')!!}</th>
            <th>{!!trans('front.goods_name')!!}</th>
            <th>{!!trans('front.goods_attr')!!}</th>
            <th>{!!trans('front.shop_price')!!}</th>
            <th>{!!trans('front.cart_number')!!}</th>
            <th>{!!trans('front.total')!!}</th>
           
        </tr>
        @if($order_goods)
   		@foreach($order_goods as $item)
        <tr>
        	
            <td>
            		<a href="{{$item->goods->url()}}" target="_blank">
                    	<img src="{{$item->goods->thumb()}}" class="cart-thumb img-thumbnail" />
                    </a>
            </td>
            <td style="vertical-align:middle; text-align:center;">
                <a href="{{$item->goods->url()}}" target="_blank">
                   {{$item->goods_name}}
                </a>
            </td>
            <td style="vertical-align:middle; text-align:center;">{!!$item->goods_attr!!}</td>
            <td style="vertical-align:middle; text-align:center;">{!!$item->shop_price!!}</td>
            <td style="vertical-align:middle; text-align:center;width:100px;">{!!$item->goods_number!!}</td>
            <td style="vertical-align:middle; text-align:center;">
            	<span id="cart-list-total-{!!$item->id!!}" class="cart-list-total">
                {{$item->total()}}
                </span>
            </td>
            
        
        </tr>
        @endforeach
        @endif
   </table>

</div><!--/panel-body-->
</div>

<a href="{!!url('auth/order')!!}" class="btn btn-success btn-lg">
	<i class="fa fa-arrow-circle-o-left"></i>
	{!!trans('front.back_to_order_list')!!}
</a>

</div><!--/col-md-9-->
