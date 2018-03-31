<div class="row">
<div class="col s12">
<div class="card-panel">

<p>
	商品总计:<span class="price">{!!App\Models\Cart::amount()!!}</span> 
	+
	运费:<span class="price" id="shipping-fee">0</span> 
	=
	<span class="price" id="checkout-total">{!!App\Models\Cart::amount()!!}</span>
</p>

<span class="btn red" id="order-submit-btn">确认下单</span>


</div><!--/card-panel-->
</div><!--/col s12-->
</div><!--/row-->