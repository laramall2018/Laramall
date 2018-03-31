
<div class="goods-form">

        {!!Form::open(['url'=>'cart','method'=>'post','class'=>'form-horizontal'])!!}

        @if($goods_attr)
        @foreach($goods_attr as $item)
        <div class="form-group" style="display:none">
          <label for="attr_id_{!!$item['attr_id']!!}" class="col-sm-2 control-label">{!!$item['attr_name']!!}</label>
          <div class="col-sm-10">
            <select name="goods_attr_ids[]" id="attr_id_{!!$item['attr_id']!!}" class="form-control">
                <option value="0">{!!trans('front.select')!!}</option>
                    @if($item['attr_value'])
                    @foreach($item['attr_value'] as $attr_value)
                    <option value="{!!$attr_value->id!!}">{!!$attr_value->attr_value!!}</option>
                    @endforeach
                    @endif
             </select>
        </div>
        </div>
        @endforeach
        @endif


        @if($goods_attr)
        @foreach($goods_attr as $item)
        <p class="attr-name">{!!$item['attr_name']!!}</p>

        @if($item['attr_value'])
        <div class="attr-value-btn">
        @foreach($item['attr_value'] as $attr_value)

              @if($attr_value->color_img)
                <img src="{!!url($attr_value->color_img)!!}" class="attr-value-img" title="{!!$attr_value->attr_value!!}" data-id="{!!$attr_value->id!!}">
              @else
              <span class="attr-value" data-attr_id="attr_id_{!!$item['attr_id']!!}" data-id="{!!$attr_value->id!!}">
                  {!!$attr_value->attr_value!!}
              </span>
              @endif
        @endforeach
        </div>
        @endif

        @endforeach
        @endif

        <input type="hidden" name="goods_id"  id="goods_id" value="{!!$goods->id!!}">

        <div id="ajax-attr-list">
        </div><!--/ajax-attr-list-->

      <div class="buy-btn-box">

     		<span  class="buy-btn">
     				<i class="fa fa-cart-plus"></i>
     					立即购买
     		</span>
      </div>

    {!!Form::close()!!}
</div><!--/goods-form-->

<div class="pop-box" style="display:none;">
   <div class="pop-box-tit">
     {!!trans('front.info_alert')!!}
     <div class="pop-box-close">
       <i class="fa fa-times"></i>
     </div>
   </div>
   <div class="pop-box-body">
      <div class="pop-box-info"></div>
      <div class="pop-box-url"></div>
  </div><!--/pop-box-body-->
</div>

<script type="text/javascript">
    $(function(){
        front.attr.select("{!!url('front/product/ajax')!!}");
    });
</script>
