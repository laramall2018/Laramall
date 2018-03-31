
<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<li class="dropdown dropdown-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                   
                    
                    @if(Auth::user()->user_icon)
                    {!!HTML::image(Auth::user()->user_icon,'',['class'=>'img-circle'])!!}
                    @else
                     <img alt="" class="img-circle" src="{!!url('assets/admin/layout/img/avatar3_small.jpg')!!}"/>
                    @endif
					
					<span class="username username-hide-on-mobile">
                     @if(Auth::check())
					 {!!Auth::user()->username!!}
                     @else
                     匿名用户
                     @endif
                    </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="{!!url('admin/edit/'.Auth::user()->id)!!}">
							<i class="icon-user"></i>我的信息</a>
						</li>
                        <li>
                        	<a href="{!!url('admin/index')!!}">
                            <i class="fa fa-mail-forward"></i>
                            系统信息
                            </a>
                        </li>
						
						
						
						<li class="divider">
						</li>
						
						<li>
							<a href="{!!url('admin/logout')!!}">
							<i class="icon-key"></i>退出登录</a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- BEGIN QUICK SIDEBAR TOGGLER -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<li class="dropdown dropdown-quick-sidebar-toggler">
					<a href="javascript:;" class="dropdown-toggle">
					<i class="icon-logout"></i>
					</a>
				</li>
				<!-- END QUICK SIDEBAR TOGGLER -->
			</ul>
</div><!--/top_menu-->