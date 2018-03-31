@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	
	<div class="row">
	<div class="col s12">
		<div class="card-panel2">
			<blockquote>
			 <p>
			 <span class="red-text"> {!!Auth::user('user')->username!!}</span>欢迎您！
			 @if($user->rank)
			 <span>{!!$user->rank->rank_name!!}</span> 
			 @endif
			 </p>
			 <p>{!!trans('front.login_ip')!!}:{!!Request::getClientIp()!!}</p>
			 <p>
			 	{!!trans('front.last_login_time')!!}:{!!$user->last_login_time()!!}
			 </p>
			 <p>{!!trans('front.register_time')!!}:{!!$user->created_at!!}</p>
			 </blockquote>

			 @if(Auth::user('user')->icon())
			 <img src="{{Auth::user('user')->icon()}}" class="circle responsive-img" style="width:80px;">
			 @endif

			 @if($user->rank)
			 @if($user->rank->icon())
			 <img src="{{$user->rank->icon()}}" class="circle responsive-img">
			 @endif
			 @endif

			 @include('materialize.lib.users.profile')
			 			
			
			 <a href="{!!$back_url!!}" class="btn offset-top10">返回用户中心</a>
			 
		</div>
	</div>
	</div>


@stop