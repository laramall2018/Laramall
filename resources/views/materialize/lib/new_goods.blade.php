@if($new_goods)
<div class="row">
@foreach($new_goods as $item)
  <div class="col s6">
  <div class="card">
    <div class="card-image waves-effect waves-block waves-light">
      <a href="{!!url($item->url())!!}">
      @if($item->thumb())
     <img src="{{$item->thumb()}}" alt="{!!$item->goods_name!!}"  class="activator"/>
       @else
       <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" alt="{!!$item->goods_name!!}" class="activator" />
       @endif
     </a>

    </div>
    <div class="card-content">
      <p><a href="{{$item->url()}}">{!!str_limit($item->goods_name,15,'..')!!}</a></p>
      <p class="price-btn red-text"><strong>￥{!!$item->shop_price!!}</strong></p>
      <p class="btn-collect" data-goods_id="{!!$item->id!!}">
           @if($item->is_collect())
           <i class="material-icons red-text">favorite</i>
           @else
           <i class="material-icons red-text">favorite_border</i>
           @endif
           <small class="right">{!!$item->collect_number()!!}</small>
      </p>
      <a class="btn go-btn" href="{{$item->url()}}">立即购买</a>
    </div>
  </div>
</div>
@endforeach
</div>
</div>
@endif
