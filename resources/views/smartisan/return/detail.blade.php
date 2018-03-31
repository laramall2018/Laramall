<div class="menu-right">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>退货单详情</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
			@include('smartisan.return.base')
			@include('smartisan.return.goods')
			<a href="{{url('auth/return')}}" class="btn btn-success">
				<i class="fa fa-undo"></i>
				返回列表
			</a>
		</div><!--/panel-body-->
	</div><!--/panel-goods-->
</div><!--/menu-right-->