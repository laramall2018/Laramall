<div class="col-md-12">
	<div class="cat-box">




    <div class="cat-title">

        <div class="sort-btn">
          {!!trans('front.goods_list')!!}
        </div>
    </div><!--/cat-title-->

    <div class="goods-list-grid cat-list-grid" id="ajax-goods-list" style="width:1200px;">

    	@if($goods_list)
        @foreach($goods_list as $item)
        <div class="item cat-item">
            <div class="item-bb">

                <div class="pic">
                 <a href="{!!url($item->url())!!}">
                 	@if($item->thumb())
                 	<img src="{{$item->thumb()}}" alt="{!!$item->goods_name!!}" class="goods-thumb" />
                    @else
                    <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" alt="{!!$item->goods_name!!}" />
                    @endif
                 </a>
                </div><!--/pic-->
                @if($item->gallery()->get())
                <div class="thumb-list">
                @foreach($item->gallery()->get() as $key=>$gallery)
                	<img src="{{$gallery->thumb()}}" alt="{!!$item->goods_name!!}" class="thumb-curr{!!$key!!} goods-thumb-min" />
                @endforeach
                </div>
                @endif

                	<p class="text">
                		<a href="{!!url($item->url())!!}">
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

    {!!$goods_list->render()!!}

    </div>
	</div><!--/cat-box-->
</div><!--/col-md-9-->
<script type="text/javascript">
  $(function(){
    cat.thumb();
  })
</script>
