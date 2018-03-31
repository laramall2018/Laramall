<!-- 商品属性 -->
<div class="row">
<div class="col s12">
<div class="card-panel">

    @if($goods->attr_list())
    @foreach($goods->attr_list() as $item)
        <p>
          {!!$item['attr_name']!!}
          @if($item['attr_value'])
          @foreach($item['attr_value'] as $attr)


          <p>
            <input class="with-gap attr_list" name="goods_attr_ids{{$item['attr_id']}}[]" type="radio" value="{!!$attr->attr_value!!}" id="goods-attr-value{!!$attr->id!!}" />
            <label for="goods-attr-value{!!$attr->id!!}">{{$attr->attr_value}}</label>
          </p>

          @endforeach
          @endif
        </p>
    @endforeach
    @endif

    @include('materialize.lib.goods.buy')

</div>
</div>
</div>
<!-- 商品属性结束 -->

