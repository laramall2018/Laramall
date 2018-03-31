


<div class="col-md-12">
    
    <div class="goods-list-grid cat-list-grid" style="width:1200px;">
    	@if($goods_list)
        @foreach($goods_list as $item)
        <div class="item">
            <div class="item-bb">
            	<a href="{{$item->url()}}"><div class="item-mask"></div></a>
                <div class="pic">
                 <a href="{{$item->url()}}">
                 	@if($item->thumb())
                 	<img src="{{$item->thumb()}}" alt="{!!$item['goods_name']!!}" />
                    @else
                    <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" alt="{!!$item['goods_name']!!}" />
                    @endif
                 </a>
                </div><!--/pic-->
                
                	<p class="text"><a href="{{$item->url()}}">{!!$item['goods_name']!!}</a></p>
                    <p class="price">{!!$item['shop_price']!!}</p>
                
                <div class="cart-icon">
                	<i class="fa fa-shopping-cart"></i>
                </div>
                <div class="tag sale-tag"></div>
            </div><!--/item-bb-->
            </div>
        @endforeach
        @endif
        
        
    </div><!--/goods-list-grid-->
    <div class="page">
    
    	{!!$goods_list->render()!!}
    
    </div>
	</div><!--/cat-box-->
</div><!--/col-md-9-->
