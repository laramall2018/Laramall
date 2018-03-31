<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>
		留言列表
		<a class="btn btn-success ls-btn-right" href="{{url('auth/message')}}">
			<i class="fa fa-pencil"></i>添加
		</a>
		</h4>
	</div><!--/panel-heading-->
	<div class="panel-body" style="padding: 20px;">
		@include('smartisan.message.all.detail')
	</div><!--/panel-body-->
</div><!--/panel-->