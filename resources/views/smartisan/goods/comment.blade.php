<div class="row">
	<div class="panel panel-goods" id="commentapp">
		<div class="panel-heading">
			<h4>
				商品评价
			<span class="ls-btn-gray ls-btn-right" data-toggle="modal" data-target="#myModalNew">
				    <i class="fa fa-plus"></i>
					我要评价
			</span>
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 30px;">
			@include('smartisan.goods.comment.list')
		</div>
		@include('smartisan.goods.comment.popbox')
	</div><!--/commentapp-->
</div>
@include('smartisan.vue.comment')