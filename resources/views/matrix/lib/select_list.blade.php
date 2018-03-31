
<div class="cat-select-list">

<div class="attr_list" id="selected-btn-list" style="display:none;">
	<div class="row">
    	<div class="col-md-1">
        	<span class="tit">已选</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
        
        	
        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->

@if($cat->price())
<div class="attr_list">
	<div class="row">
    	<div class="col-md-1">
        	<span class="tit">价格</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
        <span class="item price-item" data-min="0" data-max="0">所有</span>
        @foreach($cat->price() as $item)
        	<span class="item price-item" data-min="{!!$item['min']!!}" data-max="{!!$item['max']!!}">	{!!$item['min']!!}-{!!$item['max']!!}
            </span>
        @endforeach
        	
        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->
@endif

@if($cat->brand())
<div class="attr_list">
	<div class="row">
    	<div class="col-md-1">
        	<span class="tit">{!!trans('front.brand')!!}</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
            <span class="item brand-item" data-brand_id="0">所有</span>
        @foreach($cat->brand() as $item)
        	<span class="item brand-item" data-brand_id="{!!$item->id!!}">
            {!!$item->brand_name!!}
            </span>
        @endforeach
        	
        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->
@endif

@if($cat->attr())
@foreach($cat->attr() as $attr)
<div class="attr_list">
	<div class="row">
    	<div class="col-md-1">
        	<span class="tit">{!!$attr['attr_name']!!}</span>
        </div><!--/col-md-2-->
        <div class="col-md-10">
            <span class="item attr-item" 
            	data-attr_id="{!!$attr['id']!!}"
                data-goods_attr_id="0"
                >
             	所有
           </span>
        	@if($attr['attr_value'])
            @foreach($attr['attr_value'] as $value)
        	<span class="item attr-item" 
            	data-attr_id="{!!$attr['id']!!}"
                data-goods_attr_id="{!!$value->id!!}"
                >
             	{!!$value->attr_value!!}
           </span>
            @endforeach
            @endif
        </div><!--/col-md-10-->
    </div><!--/row-->
</div><!--/attr_list-->
@endforeach
@endif


</div>