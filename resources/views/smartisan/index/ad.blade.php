<div class="home-ad">
	<div class="ls-row">
		<div class="ls-col-md-3">
			@if($ad1)
			<a href="{{$ad1->img_url}}" class="cover-link">
			<img src="{{$ad1->icon()}}" alt="{{$ad1->img_name}}" class="left-img">
			</a>
			@endif
		</div>
		<div class="ls-col-md-3">
			@if($ad2)
			<a href="{{$ad2->img_url}}" class="cover-link">
			<img src="{{$ad2->icon()}}" alt="{{$ad2->img_name}}">
			</a>
			@endif
		</div>
		<div class="ls-col-md-3">
			@if($ad3)
			<a href="{{$ad3->img_url}}">
			<img src="{{$ad3->icon()}}" alt="{{$ad3->img_name}}">
			</a>
			@endif
		</div>
		<div class="ls-col-md-3">
			@if($ad4)
			<a href="{{$ad4->img_url}}">
			<img src="{{$ad4->icon()}}" alt="{{$ad4->img_name}}" class="right-img">
			</a>
			@endif
		</div>
	</div>
</div>