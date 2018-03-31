<div class="menu-right">
<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>新闻列表</h4>
	</div><!--/panel-heading-->
	<div class="panel-body" style="padding: 20px;">
		@if($model->article)
		<ul class="article-item">
		@foreach($model->article()->paginate(20) as $article)
		<li>
			<a href="{{$article->url()}}">{{$article->title}}</a>
		</li>
		@endforeach
		</ul>
		@endif
		
	</div><!--/panel-body-->

</div><!--/panel-->
{!!$model->article()->paginate(20)->render()!!}
</div><!--/menu-right-->