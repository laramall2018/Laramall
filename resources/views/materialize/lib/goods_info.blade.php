

  <div class="row">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s3"><a href="#test1">{{trans('front.goods_base')}}</a></li>
        <li class="tab col s3"><a class="active" href="#test2">{{trans('front.goods_attr')}}</a></li>
        <li class="tab col s3"><a href="#test3">{{trans('front.goods_desc')}}</a></li>
      </ul>
    </div>
    <div id="test1" class="col s12">@include('materialize.lib.goods.base')</div>
    <div id="test2" class="col s12">@include('materialize.lib.goods.attr')</div>
    <div id="test3" class="col s12">@include('materialize.lib.goods.desc')</div>
    
  </div>
