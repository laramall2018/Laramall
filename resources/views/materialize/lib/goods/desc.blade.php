<!-- 商品详情 -->
<div class="row">
<div class="col s12">
<div class="card-panel">
  <h5>{!!trans('front.goods_detail')!!}</h5>
  <div class="goods-desc-content">
  	{!!$goods->goods_desc!!}
  </div>
  
</div>
</div>
</div>
<!-- 商品详情结束 -->
<script type="text/javascript">
	$(function(){
		$('.goods-desc-content img').addClass('responsive-img');
	})
</script>
