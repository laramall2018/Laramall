<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>品牌详情</h4>
	</div><!--/panel-heading-->
	<div class="panel-body" style="padding: 20px;">
		<div class="brand-detail-item">
			<span class="tit">
				品牌名称
			</span>
			<span>{{$model->brand_name}}</span>
		</div><!--/brand-detail-item-->

		<div class="brand-detail-item">
			<span class="tit">
				品牌网址
			</span>
			<span>{{$model->brand_url}}</span>
		</div><!--/brand-detail-item-->

		<div class="brand-detail-item">
			<span class="tit">
				品牌LOGO
			</span>
			<span><img src="{{$model->presenter()->logo}}" alt=""></span>
		</div><!--/brand-detail-item-->

		<div class="brand-detail-item">
			<span>{!!$model->brand_desc!!}</span>
		</div><!--/brand-detail-item-->

	</div><!--/panel-body-->
</div><!--/panel-->