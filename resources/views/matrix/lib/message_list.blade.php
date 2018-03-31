<div class="container">
	
	<div class="row">
	<div class="col-md-12">
	<a href="{!!url('message-form')!!}" class="message-btn red-btn fancybox fancybox.iframe">
		<span class="glyphicon glyphicon-comment"></span>
		添加留言
	</a>
	</div>
	</div>
	
	<div class="message-list">
		@if($messages)
		@foreach($messages as $item)
		<div class="message-item">
		<div class="row">
		 	<div class="col-md-1">
		 		@if($item['user'])
		 		@if($item['user']->icon())
		 			<img src="{{$item['user']->icon()}}" class="img-thumbnail user-icon">
		 		@else
		 			<img src="{!!url('front/matrix/images/user-def.png')!!}" class="img-thumbnail user-icon">
		 		@endif
		 		@else
		 				<img src="{!!url('front/matrix/images/user-def.png')!!}" class="img-thumbnail user-icon">
		 		@endif
		 	</div>
		 	<div class="col-md-11">
		 	    <div class="row">
		 	    		<div class="col-md-2">{!!$item->username!!}</div>
		 	      		<div class="col-md-1 col-md-offset-7"><span>[{!!$item->type!!}]</span></div>
		 	      		<div class="col-md-1"><small>{!!$item->email!!}</small></div>
		 	      		<div class="col-md-1"><small>{!!$item['add_time_str']!!}</small></div>
		 	     </div>
		 	    <div>{!!$item->content!!}</div>
		 		@if($item->reply)
		 		<div class="row admin-reply">
		 		<div class="alert alert-info">
		 			<div class="row">
		 			
		 			<div class="col-md-10">
		 			{!!$item->reply!!}
		 			</div>
		 			<div class="col-md-2">
		 					{!!$item->admin!!}
		 					<?php echo date('Y/m/d',$item->reply_time);?>
		 				</div>
		 			</div>
		 		</div>
		 		</div>
		 		@endif
		    </div>
		</div><!--/row-->
		
		
		</div><!--/message-item-->
		
		@endforeach
		@endif
		
		<div class="page-list">
			{!!$messages->render()!!}
		</div>

	</div><!--/message-list-->

</div><!--/container-->
<script type="text/javascript">
	$(function(){
		$('.fancybox').fancybox();
	});
</script>