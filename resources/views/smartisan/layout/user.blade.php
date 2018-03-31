<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>@yield('title')</title>
<link rel="stylesheet" type="text/css" href="{!!url('front/smartisan/bootstrap/css/bootstrap.min.css')!!}"/>
<link rel="stylesheet" type="text/css" href="{!!url('front/smartisan/font-awesome/css/font-awesome.min.css')!!}"/>
<link rel="stylesheet" href="{{url('front/smartisan/sweetalert/sweetalert.css')}}" type="text/css" />
<link rel="stylesheet" type="text/css" href="{!!url('front/smartisan/style.css')!!}"/>

<script type="text/javascript" src="{!!url('front/smartisan/js/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/smartisan/js/jquery.json-2.4.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/smartisan/js/jquery.cookie.js')!!}"></script>
<script src="{{url('front/smartisan/sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{url('front/smartisan/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{!!url('front/smartisan/js/larastore.js')!!}"></script>
<script src="{{url('front/vue/vue.min.js')}}" type="text/javascript"></script>
</head>
<body id="user-body">
    @yield('content')
</body>
</html>
