@if($help)
@foreach($help as $item)
	<div class="col-md-3">
		<h4 class="tit">
			<a href="{!!$item->url()!!}">
				{!!$item->cat_name!!}
			</a>
		</h4>
		@if($item->getArticle())
		<ul>
		@foreach($item->getArticle() as $key=>$article)
		  	@if($key <=5)
			<li><a href="{!!$article->url()!!}">{!!str_limit($article->title,25,'..')!!}</a></li>
			@endif
		@endforeach
	    </ul>
		@endif
	</div>
@endforeach
@endif