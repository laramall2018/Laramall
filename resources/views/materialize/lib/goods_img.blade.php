
@if($goods->gallery)
<div class="slider">
<ul class="slides">

@foreach($goods->gallery as $key=>$gallery)
<li>
   <a href="{{$gallery->_original()}}" class="swipebox" title="{!!$goods->goods_name!!}">
   		<img src="{{$gallery->img()}}">
   </a>
</li>
@endforeach

</ul>
</div>
@endif
