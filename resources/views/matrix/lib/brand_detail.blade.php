
<ul class="brand-detail">
  <li>{!!$model->brand_name!!}</li>
  <li><a href="{!!$model->brand_url!!}" target="_blank">{!!$model->brand_url!!}</a></li>
  <li>
    @if($model->brand_logo)
    <img src="{!!url($model->brand_logo)!!}" class="img-thumbnail">
    @else
    <img src="{!!url('front/matrix/images/brand-def.png')!!}" class="img-thumbnail">
    @endif
  </li>
  <li>{!!$model->brand_desc!!}</li>
  <li><a href="{!!url('brand')!!}">{!!trans('front.preview_all')!!}</a></li>
</ul>
