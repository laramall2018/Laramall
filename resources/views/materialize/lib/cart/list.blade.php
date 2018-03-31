
<div class="row">
	<div class="col s12">
	<div class="card-panel">
		@if($user->cart()->get())
		
		<table class="table bordered" id="cart-table">
			<tr>
				<th style="width:100px;">
					<input type="checkbox" name="all_select" id="all_select">
					<label for="all_select">选择</label>
				</th>
				<th>商品信息</th>
				<th>操作</th>
			</tr>

			
			@foreach($user->cart()->get() as $cart)
			<tr>
				<td>
				     
					<input type="checkbox" 
						   name="ids[]"  
						   @if($cart->is_checked == 1) 
						   checked="checked"
						   @endif
						   value="{!!$cart->id!!}" 
						   class="cart-checkbox"  
						   id="goods_id{!!$cart->id!!}">
					<label for="goods_id{!!$cart->id!!}"></label>
				</td>
				<td>
					@if($cart->goods->thumb())
					<p>
						<a href="{!!$cart->goods->url()!!}">
						<img src="{{$cart->goods->thumb()}}" class="responsive-img cart-thumb">
						</a>
					</p>
					@endif
					<p>{!!$cart->goods_name!!}</p>
					<p><small>{!!$cart->goods_attr!!}</small></p>
					<p class="red-text">{!!$cart->shop_price!!}</p>
					<p>
						<div class="number-div" data-id="{!!$cart->id!!}" data-goods_number="{!!$cart->goods_number!!}">
						<i class="material-icons left cart-add-btn">add</i>
						<i class="material-icons right cart-sub-btn">remove</i>
							 <span class="goods_number_btn{!!$cart->id!!}"> {!!$cart->goods_number!!}</span>
					    </div>
					</p>
				</td>
				<td>
					<span class="cart-delete-btn" data-goods_id="{!!$cart->goods_id!!}" data-id="{!!$cart->id!!}">
					<i class="material-icons red-text">remove_circle</i>
					</span>
				</td>
				
			</tr>
			@endforeach
			

			<tr>
				<td>
					<p><i class="material-icons red-text" id="batch-delete-btn">remove_circle</i></p>
				</td>
				<td colspan="2">
					选中数量:<span class="red-text" id="cart-number-btn">{{$number}}</span>
					总计:<span class="red-text" id="cart-amount-btn">{{$all_number}}</span>
				</td>
				
			</tr>

		</table>
		@endif
	</div>
	</div>
</div>

<div class="row">
	<div class="col s12">
			<span class="btn red left cart-empty">
				<i class="material-icons left">clear</i>
				清空
			</span>
		    <a class="btn blue right" href="{!!url('checkout')!!}">
				<i class="material-icons right">arrow_forward</i>
				{!!trans('front.checkout')!!}
		   </a>
	</div>
</div>

<script type="text/javascript">
	$(function(){

		front.cart.init("{!!url('cart-ajax-mobile')!!}");
	})
</script>
