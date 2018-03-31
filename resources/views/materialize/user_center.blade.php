@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')

<div class="row">
	<div class="col s12">
		<div class="card-panel">
			<blockquote>
			 <p>
			 <span class="red-text"> {!!Auth::user('user')->username!!}</span>欢迎您！
			 @if($rank)<span>{!!$rank->rank_name!!}</span> @endif
			 </p>
			 <p>{!!trans('front.login_ip')!!}:{!!Request::getClientIp()!!}</p>
			 <p>
			 	{!!trans('front.last_login_time')!!}:{!!$last_login_time!!}
			 </p>
			 <p>{!!trans('front.register_time')!!}:{!!Auth::user('user')->created_at!!}</p>
			 <p>
				<strong class="red-text">账户余额：￥{{Auth::user('user')->money()}}</strong>
			 </p>
			 </blockquote>

			 @if(Auth::user('user')->icon())
			 <img src="{{Auth::user('user')->icon()}}" class="circle responsive-img" style="width:80px;">
			 @endif
			 			

			 @include('materialize.lib.users.button-menu')

		</div>
	</div>
	</div>

@stop