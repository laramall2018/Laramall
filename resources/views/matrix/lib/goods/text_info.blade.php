
<div class="goods-text-info">

    <p class="tit" style="border:none">{!!$goods->goods_name!!}</p>

    <table class="table table-hover table-striped" id="goods-text-tab">
    	<tr>
      	<th style="width:150px;">{!!trans('front.goods_sn')!!}:</th>
        <td><span id="ajax_goods_sn">{!!$goods->goods_sn!!}</span></td>
			</tr>
			<tr>
      	<th>{!!trans('front.goods_number')!!}:</th>
        <td><span id="ajax_goods_number">{!!$goods->goods_number!!}</span></td>
      </tr>
      <tr>
        <th>{!!trans('front.brand')!!}</th>
        <td>
            @if($brand)
            {!!$brand->brand_name!!}
            @endif
        </td>
		 </tr>
      <tr>
        	<th>{!!trans('front.rank_name')!!}</th>
            <td>
							@if($rank)
            	{!!$rank['rank_name']!!}
							@endif
            </td>
			</tr>
      @if(Auth::check('user'))
			@if(Auth::user('user')->rank)
			@if(Auth::user('user')->rank->icon())
			<tr>
            	<th>{!!trans('front.rank_pic')!!}</th>
            	<td> <img src="{{Auth::user('user')->rank->icon()}}"></td>
      		</tr>
      		@endif
      		@endif
          @endif

        <tr>
        	<th>{!!trans('front.rank_price')!!}</th>
            <td>
							@if($rank)
            	<span class="price">{!!$rank['rank_price']!!}</span>
							@endif
            </td>
        </tr>
				<tr>
	         <th>{!!trans('front.shop_price')!!}:</th>
	         <td><span class="price">{!!$goods->shop_price!!}</span></td>
	       </tr>
				 <tr>
					 <th>{!!trans('front.buy_number')!!}</td>
					<td>
							<span class="sub-num">-</span>
							<input type="text" name="goods_number" class="goods-num" id="goods_number" value="1">
							<span class="add-num">+</span>
					</td>
				</tr>
    </table>

    <div class="buy-btn-box">
		<span class="collect-btn" data-id="{!!$goods->id!!}">
		 <i class="fa fa-heart"></i>
		 收藏
		</span>
		<span  class="add-to-cart-btn">
				 <span class="glyphicon glyphicon-shopping-cart"></span>
					加入购物车
		</span>
	</div><!--/buy-btn-box-->
</div>
