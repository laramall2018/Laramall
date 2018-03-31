


<h5 class="tit per95">{!!trans('front.goods_list')!!}</h5>
<div id="ajax-goods-list">
@if($cat->goods_list())
<div class="row">
@foreach($cat->goods_list() as $item)
  <div class="col s6">
  <div class="card">
    <div class="card-image waves-effect waves-block waves-light">
      <a href="{{$item['url']}}">
      @if($item['thumb'])
      <img src="{{$item['thumb']}}" alt="{{$item['goods_name']}}" class="activator" />
      @else
       <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" alt="{{$item['goods_name']}}" class="activator" />
      @endif
     </a>

    </div>
    <div class="card-content">
      <p><a href="{{$item['url']}}">{!!str_limit($item['goods_name'],15,'..')!!}</a></p>
      <p class="price-btn red-text"><strong>￥{{$item['shop_price']}}</strong></p>
      
      <a class="btn go-btn" href="{{$item['url']}}">立即购买</a>
    </div>
  </div>
</div>
@endforeach
</div><!--/row-->
</div><!--/ajax-goods-list-->



@endif
