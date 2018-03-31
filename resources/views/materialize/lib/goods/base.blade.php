<!-- 商品基本信息 -->
<div class="row">
<div class="col s12">
<div class="card-panel">
<h5>{!!$goods->goods_name!!}</h5>
<p>
      {!!trans('front.goods_sn')!!}
      {!!$goods->goods_sn!!}
</p>
<p>
    {{trans('front.goods_number')}}
    {!!$goods->goods_number!!}
</p>
@if($goods->brand)
<p>
    {{trans('front.brand')}}
    {{$goods->brand->brand_name}}
</p>
@endif
<p>
    {!!trans('front.category')!!}
    <a href="{!!$goods->category->url()!!}">{{$goods->category->cat_name}}</a>
</p>
<p class="price">
    {{trans('front.price')}}
    {{$goods->shop_price}}
</p>

</div>
</div>
</div>
<!-- 商品基本信息结束 -->
