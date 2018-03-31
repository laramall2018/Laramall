
<div class="row" id="batchroot">
	
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>批量下单</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
		    @include('smartisan.batch.info')
			@include('smartisan.batch.form')
			@include('smartisan.batch.goods_list')
			@include('smartisan.batch.order_list')
		</div><!--/body-->
	</div><!--/panel-->
</div><!--/row-->
@include('smartisan.vue.batch')