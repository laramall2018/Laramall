
<div class="panel panel-success">

<div class="panel-heading">
	<h5>{!!trans('front.goods_list')!!}</h5>
</div>
<div class="panel-body">
    <div id="table-btn">
		
        <table class="table table-bordered table-hover table-striped cart-table">
   		
        <tr>
        	
            <th style="width:110px;">{!!trans('front.thumb')!!}</th>
            <th>{!!trans('front.goods_name')!!}</th>
            <th>{!!trans('front.goods_attr')!!}</th>
            <th>{!!trans('front.shop_price')!!}</th>
            <th>{!!trans('front.cart_number')!!}</th>
            <th>{!!trans('front.total')!!}</th>
           
        </tr>
        @if($cart_list)
   		@foreach($cart_list as $item)
        <tr>
        	
            <td>
            		<a href="{{$item->goods->url()}}" target="_blank">
                    	<img src="{{$item->goods->thumb()}}" class="cart-thumb img-thumbnail" />
                    </a>
            </td>
            <td style="vertical-align:middle; text-align:center;">
                <a href="{{$item->goods->url()}}" target="_blank">{{$item->goods_name}}</a>
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
    </div>
    
    <div class="alert alert-success">
        	<div class="row">
            	
                <div class="col-md-8">
                	<span class="cart-total">
                    	
                        商品价格：<span class="num">{!!$cart_total!!}{!!trans('front.price_tag')!!}</span>
                   
                    	<span>+</span>
                    	运费：
                       <span id="shipping_fee" class="num">0</span>
                       <span>=</span>
                       <span id="checkout-total" class="num">{!!$cart_total!!}{!!trans('front.price_tag')!!}</span>
                    </span>
                </div>
                <div class="col-md-4 text-right">
                
            		
                    <span class="btn btn-info btn-lg" id="checkout-done">
                    	{!!trans('front.order_submit')!!}
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </span>
                    
                </div>
            
            </div>
            
        </div><!--/alert-->

</div>

</div>
   
   
<script type="text/javascript">
	$(function(){
		
		front.cart.shipping("{!!url('shipping-fee')!!}","{!!csrf_token()!!}");
		front.cart.done("{!!url('order')!!}","{!!csrf_token()!!}","{!!url('order-done')!!}");
	})
</script>
   