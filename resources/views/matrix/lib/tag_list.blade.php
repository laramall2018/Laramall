<div class="col-md-9">
	
	<div class="panel panel-info">
		<div class="panel-heading">标签列表</div>
		<div class="panel-body">
		@if($tag_list)
		@foreach($tag_list as $item)
		<span class="tag-item">
			<a href="{!!url('goods/'.$item->goods_id)!!}" target="_blank" >
			{!!$item->tag_name!!}
			</a>
		</span>
		@endforeach
		@endif
		</div><!--/panel-body-->
	</div><!--/panel-->
</div><!--/col-md-9-->