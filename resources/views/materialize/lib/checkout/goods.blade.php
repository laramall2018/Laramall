<div class="row">
<div class="col s12">
<div class="card-panel">
<table class="table bordered">
	
	<tr>
		<th>商品信息</th>
		<th>购买信息</th>
	</tr>

	@foreach(Auth::user('user')->cart()->where('is_checked',1)->get() as $cart)
	<tr>
		<td>
			@if($cart->goods->thumb())
			 <p>
			 	<a href="{!!$cart->goods->url()!!}">
			 		<img src="{!!url($cart->goods->gallery()->first()->thumb())!!}" style="width:80px;height:80px;">
			 	</a>
			 </p>
			@endif
			<p><a href="{!!$cart->goods->url()!!}">{!!$cart->goods_name!!}</a></p>
		</td>
		<td>
				<p>价格:<span class="price">{!!$cart->shop_price!!}</span></p>
				<p>数量:{!!$cart->goods_number!!}</p>
				<p>总计:<span class="price">{!!$cart->total()!!}</span></p>
		</td>
	</tr>
	@endforeach
	<tr>
		<td>总计</td>
		<td><span class="price">{!!App\Models\Cart::amount()!!}</span></td>
	</tr>
</table>
<a href="{!!url('cart')!!}" class="btn red offset-top10">编辑</a>
</div><!--/card-panel-->
</div><!--/col s12-->
</div><!--/row-->