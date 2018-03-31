<div class="menu-right">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				{{$model->title}}
				<small style="padding: 0 10px;">{{$model->created_at->diffForHumans()}}</small>
			</h4>
		</div><!--/panel-->
	    <div class="panel-body" style="padding: 20px;">
			{!!$model->content!!}

			<div class="alert alert-info">
				<div class="row">
					<div class="col-md-6">
						@if($model->presenter()->pre)
						<a href="{{$model->presenter()->pre()->url()}}">
							{{$model->presenter()->pre->title}}
						</a>
						@endif
					</div><!--/col-md-6-->
					<div class="col-md-6 text-right">
					    @if($model->presenter()->next)
						<a href="{{$model->presenter()->next->url()}}">
							{{$model->presenter()->next->title}}
						</a>
						@endif
					</div><!--/col-md-6-->
				</div>
			</div>
		</div><!--/panel-body-->
	</div><!--/panel-->
</div><!--/menu-right-->