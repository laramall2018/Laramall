
<div class="container">

    <div class="home-grid">

    	<div class="grid-title grid-title-2">
            <i class="fa fa-star"></i>
        	<span>{!!trans('front.hot_goods')!!}</span>
        </div>

        <div class="goods-list-grid">

           @if($hot_goods)
           @foreach($hot_goods as $item)
           <div class="item">
            <div class="item-bb">
            	<a href="{{$item->url()}}"><div class="item-mask"></div></a>
                <div class="pic">
                 <a href="{{$item->url()}}">
                 	@if($item->thumb())
                 	<img src="{{$item->thumb()}}" alt="{!!$item->goods_name!!}" />
                    @else
                    <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" alt="{!!$item->goods_name!!}" />
                    @endif
                 </a>
                </div><!--/pic-->

                	<p class="text">
                        <a href="{{$item->url()}}">
                            {{str_limit($item->goods_name,35,'..')}}
                        </a>
                    </p>
                    <p class="price">{!!$item->shop_price!!}</p>

                <div class="cart-icon" data-goods_id="{!!$item->id!!}">
                	<i class="fa fa-shopping-cart"></i>
                </div>
                <div class="tag sale-tag"></div>
            </div><!--/item-bb-->
            </div>
           @endforeach
           @endif

        </div><!--/goods-list-grid-->

    </div><!--/home-grid-->
</div>
