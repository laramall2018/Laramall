<div class="ls-popmenu">

	 @if(Auth::user('user'))
		<img src="{{Auth::user('user')->icon()}}" class="user-thumb" alt="">
		<p>{{Auth::user('user')->username}}</p>
	 @endif
	<ul>
                <li>
                	<a href="{!!url('auth/center')!!}">
                		<span class="glyphicon glyphicon-user"></span>
                		{!!trans('front.profile')!!}
                	</a>
               	</li>
				<li>
                	<a href="{!!url('auth/address')!!}">
                		<i class="fa fa-map"></i>
                		{!!trans('front.address_manager')!!}
                	</a>
               	</li>
				
				<li>
                	<a href="{!!url('auth/tag')!!}">
                		<span class="glyphicon glyphicon-tags"></span>
                		{!!trans('front.my_tag')!!}
                	</a>
               	</li>
				<li>
                	<a href="{!!url('auth/message')!!}">
                		<i class="fa fa-comments"></i>
                		{!!trans('front.my_message')!!}
                	</a>
               	</li>

                <li>
                	<a href="{!!url('auth/order')!!}">
                		<span class="glyphicon glyphicon-briefcase"></span>
                		{!!trans('front.my_order')!!}
                 	</a>
                </li>
                <li>
                	<a href="{!!url('auth/return')!!}">
                	<span class="glyphicon glyphicon-retweet"></span>
                	{!!trans('front.my_return')!!}
                	</a>
                </li>
                <li>
                	<a href="{!!url('auth/collect')!!}">
                	<span class="glyphicon glyphicon-heart"></span>
                	{!!trans('front.my_favorite')!!}
                	</a>
               	</li>
                <li>
                	<a href="{!!url('auth/money')!!}">
                	<span class="glyphicon glyphicon-yen"></span>
                	{!!trans('front.my_money')!!}
                	</a>
               	</li>
                <li>
                	<a href="{!!url('auth/logout')!!}">
                	<span class="glyphicon glyphicon-lock"></span>
                	{!!trans('front.logout')!!}
                	</a>
                </li>

        	</ul>
</div>