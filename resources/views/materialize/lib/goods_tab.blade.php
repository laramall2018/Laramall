<div class="row">
<div class="col s12">
<ul class="tabs">
 <li class="tab col s4"><a class="active" href="#test1">{!!trans('front.new_goods')!!}</a></li>
 <li class="tab col s4"><a href="#test2">{!!trans('front.hot_goods')!!}</a></li>
 <li class="tab col s4"><a href="#test3">{!!trans('front.best_goods')!!}</a></li>
</ul>
</div>
<div id="test1" class="col s12">@include('materialize.lib.new_goods')</div>
<div id="test2" class="col s12">@include('materialize.lib.hot_goods')</div>
<div id="test3" class="col s12">@include('materialize.lib.best_goods')</div>
</div>

<script type="text/javascript">
$(function(){
  $('ul.tabs').tabs();
})
</script>
