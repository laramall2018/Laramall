@if($brand_list)
<div class="row brand-item">
@foreach($brand_list as $brand)
	<div class="col-md-3 text-center">
		<a href="{{$brand->url()}}" alt="{{$brand->brand_name}}">
			<img src="{{$brand->presenter()->logo()}}" alt="" class="brand-img">
		</a>
		<p>
			<a href="{{$brand->url()}}" alt="{{$brand->brand_name}}">{{$brand->brand_name}}</a>
		</p>
	</div><!--/col-md-3-->
@endforeach
</div><!--/row-->
@endif