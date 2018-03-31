<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>@yield('title')</title>
<link rel="stylesheet" type="text/css" href="{!!url('admin/simple/bootstrap/css/bootstrap.min.css')!!}"/>
<link rel="stylesheet" type="text/css" href="{!!url('admin/simple/font-awesome/css/font-awesome.min.css')!!}"/>
<link rel="stylesheet" href="{{url('admin/simple/sweetalert/sweetalert.css')}}" type="text/css" />
<link rel="stylesheet" type="text/css" href="{!!url('admin/simple/tingle/tingle.min.css')!!}"/>
<link rel="stylesheet" type="text/css" href="{!!url('admin/simple/style.css')!!}"/>

<script type="text/javascript" src="{!!url('admin/simple/js/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('admin/simple/js/jquery.json-2.4.js')!!}"></script>
<script type="text/javascript" src="{!!url('admin/simple/js/jquery.cookie.js')!!}"></script>
<script src="{{url('admin/simple/sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{url('admin/simple/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{url('admin/vue/vue.min.js')}}" type="text/javascript"></script>
<script src="{{url('admin/simple/tingle/tingle.min.js')}}" type="text/javascript"></script>
</head>
<body>
	

    @yield('content')
   
    
</body>
</html>
