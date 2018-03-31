<div class="row">

  <ul class="collapsible" data-collapsible="accordion">
    <li>
      <div class="collapsible-header"><i class="material-icons">swap_vert</i>{!!trans('front.sort')!!}</div>
      <div class="collapsible-body">
          <p>
            <span class="btn sort-btn grey" data-sort_name="shop_price" data-sort_value="asc">
              <i class="material-icons left">arrow_upward</i>价格
            </span>
            <span class="btn sort-btn grey" data-sort_name="id" data-sort_value="asc">
              <i class="material-icons left">arrow_upward</i>时间
            </span>
          </p>
      </div>
    </li>
    @if($cat->price())
    <li>
      <div class="collapsible-header"><i class="material-icons">crop</i>{!!trans('front.price')!!}</div>
      <div class="collapsible-body">
        <p>
              <span class="btn grey price-btn" data-min="0" data-max="0">{!!trans('front.all')!!}</span>
          @foreach($cat->price() as $key=>$item)

              <span  class="btn grey price-btn" data-min="{!!$item['min']!!}" data-max="{!!$item['max']!!}">
                {!!$item['min']!!}--{!!$item['max']!!}
              </span>

          @endforeach
        </p>
      </div>
    </li>
    @endif

    @if($cat->brand())
    <li>
      <div class="collapsible-header"><i class="material-icons">format_bold</i>{!!trans('front.brand')!!}</div>
      <div class="collapsible-body">
        <p>
          <span class="btn grey brand-btn" data-brand_id="0">{!!trans('front.all')!!}</span>
          @foreach($cat->brand() as $brand)
          <span class="btn grey brand-btn" data-brand_id="{!!$brand->id!!}">{!!$brand->brand_name!!}</span>
          @endforeach
        </p>
      </div>
    </li>
    @endif
    
    @if($cat->attr())
    @foreach($cat->attr() as $attr)
    <li>
      <div class="collapsible-header"><i class="material-icons">timeline</i>{!!$attr['attr_name']!!}</div>
      <div class="collapsible-body">
        <p>
            @if($attr['attr_value'])
            <span class="btn grey attr-btn" data-attr_id="{!!$attr['id']!!}" data-goods_attr_id="0">{!!trans('front.all')!!}</span>
            @foreach($attr['attr_value'] as $value)
            <span class="btn grey attr-btn" data-attr_id="{!!$attr['id']!!}" data-goods_attr_id="{!!$value->id!!}">{!!$value->attr_value!!}</span>
            @endforeach
            @endif
        </p>
      </div>
    </li>
    @endforeach
    @endif
  </ul>


</div><!--/row-->
<script type="text/javascript">
  $(function(){

      cat.select("{!!url('category-ajax')!!}","{!!$cat->id!!}");

  })
</script>
