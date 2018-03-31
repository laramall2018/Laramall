<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>@yield('title')</title>
<link href="{!!url('files/bootstrap/css/bootstrap.min.css')!!}" type="text/css" rel="stylesheet" />
<link href="{!!url('files/font-awesome/css/font-awesome.min.css')!!}" type="text/css" rel="stylesheet" />
<link href="{!!url('files/style.css')!!}" type="text/css" rel="stylesheet" />
<link href="{!!url('files/css/hoe.css')!!}" type="text/css" rel="stylesheet" />
<link href="{{url('front/smartisan/sweetalert/sweetalert.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{!!url('files/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('files/hoe.js')!!}"></script>
<script type="text/javascript" src="{{url('front/smartisan/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{!!url('files/phpstore.js')!!}"></script>

@yield('script')
</head>

<body>

<body hoe-navigation-type="horizontal" hoe-nav-placement="left" >
    <div id="hoeapp-wrapper" class="hoe-hide-lpanel" hoe-device-type="desktop">
        <header id="hoe-header" hoe-lpanel-effect="shrink" class="hoe-minimized-lpanel">
            <div class="hoe-left-header">
                <a href="#"><i class="fa fa-graduation-cap"></i> <span>PhpStore商城系统</span></a>
                <span class="hoe-sidebar-toggle"><a href="#"></a></span>
            </div>

            <div class="hoe-right-header" hoe-position-type="relative" >
                <span class="hoe-sidebar-toggle"><a href="#"></a></span>
                <ul class="left-navbar"></ul>
                <ul class="right-navbar">
                
                <a href="{{url('admin/administrator/logout')}}" class="btn btn-primary">
                    <i class="fa fa-unlock" style="color: #fff"></i>
                    退出登录
                </a>
                <a class="btn btn-danger" href="{!!url('admin/cache-clear')!!}"><i class="fa fa-times" style="color:#fff;"></i>清除缓存</a>
                <a class="btn btn-info" href="{!!url('/')!!}" target="_blank"><i class="fa fa-eye" style="color:#fff;"></i>查看前台</a>
                </ul>
            </div>
        </header>
        <div id="hoeapp-container" hoe-color-type="lpanel-bg2" hoe-lpanel-effect="shrink" class="hoe-minimized-lpanel">
            <aside id="hoe-left-panel" hoe-position-type="absolute">
                <div class="profile-box">
                    <div class="media">
                        
                        <a class="pull-left">    
                        	<img class="img-circle" src="{!!url('files/images/ps.png')!!}" />
                        </a>
                        <div class="media-body">
                            <h5 class="media-heading">您好！
                            	<span class="text-danger">
                                @if(Auth::check('admin'))
                                {!!Auth::user('admin')->username!!}
                                @else
                                匿名用户
                                @endif
                                </span>
                                
                             </h5>
                            <small>欢迎您</small>
                        </div>
                    </div>
                </div>
                
                {!!$menu!!}
				 
            </aside>
            
            <section id="main-content">
            	<div>
                 	@yield('content')
                    <p>@www.prorigine.com版权所有</p>
                </div>
            </section>  
        </div>
    </div>
</body>
<script type="text/javascript">
	$(function(){
		
		ps.menu.init("{!!$page!!}","{!!$tag!!}");
	});
</script>
</html>
