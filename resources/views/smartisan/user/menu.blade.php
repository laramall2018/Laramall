
<div class="menu-left">

    <div class="panel panel-goods">
    	<div class="tit text-center">
         @if($user->icon())
          <img src="{{$user->icon()}}" class="user-thumb img-circle" alt="">
         @else
          <img src="{{url('front/smartisan/images/user-default.png')}}" class="img-circle" alt="">
         @endif

         <h4>{{$user->username}}</h4>
        </div>
        <div class="panel-body">
            <ul class="menu-nav">

                <li @if($menu_tag == 'center') class="active" @endif>
                	<a href="{!!url('auth/center')!!}">
                		<span class="glyphicon glyphicon-user"></span>
                		{!!trans('front.profile')!!}
                	</a>
               	</li>
								<li @if($menu_tag == 'address') class="active" @endif>
                	<a href="{!!url('auth/address')!!}">
                		<i class="fa fa-map"></i>
                		{!!trans('front.address_manager')!!}
                	</a>
               	</li>
								 
								<li @if($menu_tag == 'tag') class="active" @endif>
                	<a href="{!!url('auth/tag')!!}">
                		<span class="glyphicon glyphicon-tags"></span>
                		{!!trans('front.my_tag')!!}
                	</a>
               	</li>
								<li @if($menu_tag == 'message') class="active" @endif>
                	<a href="{!!url('auth/message')!!}">
                		<i class="fa fa-comments"></i>
                		{!!trans('front.my_message')!!}
                	</a>
               	</li>

                <li @if($menu_tag == 'order') class="active" @endif>
                	<a href="{!!url('auth/order')!!}">
                		<span class="glyphicon glyphicon-briefcase"></span>
                		{!!trans('front.my_order')!!}
                 	</a>
                </li>
                <li @if($menu_tag == 'order.return') class="active" @endif>
                	<a href="{!!url('auth/return')!!}">
                	<span class="glyphicon glyphicon-retweet"></span>
                	{!!trans('front.my_return')!!}
                	</a>
                </li>
                <li @if($menu_tag == 'collect') class="active" @endif>
                	<a href="{!!url('auth/collect')!!}">
                	<span class="glyphicon glyphicon-heart"></span>
                	{!!trans('front.my_favorite')!!}
                	</a>
               	</li>
                <li @if($menu_tag == 'money') class="active" @endif>
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

        </div><!--/panel-body-->
    </div><!--/panel-->
</div>
