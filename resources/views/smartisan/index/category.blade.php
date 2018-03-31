
<div class="container">
<div class="sub-nav-list">
	<ul class="nav-home-category">
		@if($category)
		@foreach($category as $item)
		<li><a href="{{$item->url()}}">{{$item->cat_name}}</a></li>
		@endforeach
		@endif
	</ul>
	@include('smartisan.lib.cart')
</div><!--/sub-nav-list-->
</div><!--/container-->