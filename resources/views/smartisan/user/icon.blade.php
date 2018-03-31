@if(Session::has('errors'))
<div class="alert alert-danger" id="errors-info">
	<i class="fa fa-times"></i>
	{!!Session::get('errors')!!}
</div>
@endif
<div class="item-list">

	@if($user->icon())
	<img src="{{$user->icon()}}" class="user-thumb img-circle" alt="">
	@endif
	<button type="button" class="ls-btn-info"  data-toggle="modal" data-target="#myModal">
		    <i class="fa fa-edit"></i>上传头像
	</button>
	@include('smartisan.user.user_icon')

</div><!--/item-list-->
<script type="text/javascript">
	$(function(){
		$('#errors-info').delay(1000).fadeOut();
	})
</script>