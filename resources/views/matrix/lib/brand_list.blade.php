
@if($brand_list)
@foreach($brand_list as $brand)
<div class="col-md-3">
  @if($brand->brand_logo)
  <a href="{!!$brand->url()!!}" target="_blank">
  <img src="{!!url($brand->brand_logo)!!}" alt="{!!$brand->brand_name!!}" class="img-thumbnail"  style="width:200px;height:50px;" >
  </a>
  @else
  <a href="{!!$brand->url()!!}" target="_blank">
  <img src="{!!url('front/matrix/images/brand-def.png')!!}" alt="{!!$brand->brand_name!!}" class="img-thumbnail">
  </a>
  @endif
  <p><a href="{!!$brand->url()!!}" target="_blank">{!!$brand->brand_name!!}[{!!$brand->goods_number()!!}]</a></p>

</div>
@endforeach
@endif
<div class="col-md-12">
    {!!$brand_list->render()!!}
</div>
