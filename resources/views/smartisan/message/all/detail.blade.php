@if($messages)
@foreach($messages as $message)
<div class="message-item">
	<div class="alert alert-info tit-box">
		<div class="row">
			<div class="col-md-1">
				@if($message->presenter()->user)
				<img src="{{$message->presenter()->user->icon()}}" class="img-thumbnail img-circle thumb">
				@endif
			</div><!--/col-md-2-->
			<div class="col-md-5" style="vertical-align: middle;">
				<span class="type">
				{{$message->type}}
				</span>
				<span class="username">
				{{$message->username}}
				</span>
				<span class="price">{{$message->hasReply}}</span>
				<span class="goods-info">
				{!!$message->goodsInfo!!}
				</span>
			</div><!--/col-md-1-->
			<div class="col-md-6 text-right">
				<span>{!!$message->presenter()->rankStar!!}</span>
				<span class="time">{{$message->time()}}</span>
				<span class="ip">{{$message->front_ip}}</span>
			</div><!--/col-md-9-->
		</div><!--/row-->
	</div><!--/alert-->

	<div class="msg-content">
		{{$message->content}}
	</div>
	@if($message->reply)
		<div class="alert alert-success">
			<strong>管理员回复：</strong>{{$message->admin}}
			{{$message->replyTimeFormat}}
		</div>
		<div class="reply-content">
			{{$message->reply}}
		</div>
	@endif
</div>
@endforeach
@endif
{!!$messages->render()!!}