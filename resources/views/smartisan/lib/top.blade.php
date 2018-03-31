
<div class="header-top">
	<div class="container header-top-bb">
		<a href="{{url('/')}}" class="logo" title="{{$title}}">
			<img src="{{url($shop_logo)}}" alt="">
		</a>
		<div class="nav">
			<ul class="nav-main">
				@if($middle_nav)
				@foreach($middle_nav as $nav)
				<li @if(Request::url() == url($nav->nav_url)) class="active" @endif>
					<a href="{{url($nav->nav_url)}}">{{$nav->nav_name}}</a>
				</li>
				@endforeach
				@endif
			</ul>
		</div><!--/nav-->
        
        <div class="account-panel">
        	@if(Auth::check('user'))
				<span class="btn btn-success btn-login">
					<span class="glyphicon glyphicon-user"></span>
					个人中心
					<span class="caret"></span>
				</span>
				@include('smartisan.lib.popmenu')
        	@else
			<a href="{{url('auth/login')}}" class="btn btn-success btn-login">
				<i class="fa fa-user"></i>
				{{trans('front.login')}}
			</a>
        	@endif
        </div>
	</div><!--/header-top-bb-->
</div><!--/header-top-->
@include('smartisan.index.category')

