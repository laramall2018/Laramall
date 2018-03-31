
@if($goods->gallery)
<div class="gallery-wrapper">
<div class="thumb-list">
@foreach($goods->gallery()->get() as $gallery)
		<img 	src="{{$gallery->thumb()}}"
			   alt="{{$goods->goods_name}}" 
			   data-img="{{$gallery->img()}}"
			   class="goods-thumb">
@endforeach
</div><!--/thumbnail-->
<div class="detail-img">
<img src="{{$goods->gallery()->first()->img()}}" alt="{{$goods->goods_name}}" class="goods-img">
</div><!--/detail-->
</div><!--/gallery-wrapper-->
@endif

<script type="text/javascript">
	$(function(){
		larastore.goods.detail();
	})
</script>