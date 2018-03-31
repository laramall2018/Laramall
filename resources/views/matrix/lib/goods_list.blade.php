<div class="col-md-9">
	<div class="cat-box">

    @if($cat->cat_ad()->get())
     <div class="cat-ad">
    @foreach($cat->cat_ad()->get() as $item)
    	<a href="{!!$item->img_url!!}" target="_blank">
        	<img src="{!!url($item->img_src)!!}" alt="{!!$item->cat_name!!}" />
        </a>
    @endforeach
    </div>
    @endif

    @include('matrix.lib.select_list')

    <div class="cat-title">

        <div class="sort-btn">
            <span class="btn btn-default sort-ajax-btn" data-sort_name="g.shop_price" data-sort_value="asc">
            	<span class="glyphicon glyphicon-menu-up sort-icon"></span>
                价格
            </span>
            <span class="btn btn-default sort-ajax-btn" data-sort_name="g.id" data-sort_value="asc">
            	<span class="glyphicon glyphicon-menu-up sort-icon"></span>
                时间
            </span>
            <span class="btn btn-default sort-ajax-btn" data-sort_name="g.sort_order" data-sort_value="asc">
                <span class="glyphicon glyphicon-menu-up sort-icon"></span>
                排序值
            </span>


        </div>
    </div><!--/cat-title-->

    <div class="goods-list-grid cat-list-grid" id="ajax-goods-list">
    	@if($cat->presenter()->goods()->query())
        @foreach($cat->presenter()->goods()->query() as $item)
        <div class="item cat-item">
            <div class="item-bb">

                <div class="pic">
                 <a href="{{$item->url()}}">
                 	@if($item->thumb())
                 	<img src="{{$item->thumb()}}" alt="{!!$item->goods_name!!}" class="goods-thumb" />
                    @else
                    <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" alt="{!!$item->goods_name!!}" />
                    @endif
                 </a>
                </div><!--/pic-->
                @if($item->gallery)
                <div class="thumb-list">
                @foreach($item->gallery as $key=>$gallery)
                	<img src="{{$gallery->thumb()}}" alt="{!!$item->goods_name!!}" class="thumb-curr{!!$key!!} goods-thumb-min" />
                @endforeach
                </div>
                @endif

                	<p class="text">
                		<a href="{{$item->url()}}">
                			{!!str_limit($item->goods_name,32,'...')!!}
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
    <div class="page" id="page-ajax-btn">

    

    </div>
	</div><!--/cat-box-->
</div><!--/col-md-9-->
