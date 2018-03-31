<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>标签列表</h4>
	</div><!--/panel-heading-->
	<div class="panel-body" style="padding: 20px;">
		@if($tag_list)
		@foreach($tag_list as $tag)
		<a href="{{$tag->goodsUrl}}" target="_blank" class="tag">
			{{$tag->tag_name}}
		</a>
		@endforeach
		@endif
	</div><!--panel-body-->
</div><!--/panel-->