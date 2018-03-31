<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>@yield('title')</title>
<link rel="stylesheet" type="text/css" href="{!!url('front/matrix/bootstrap/css/bootstrap.min.css')!!}"/>
<link rel="stylesheet" type="text/css" href="{!!url('front/matrix/font-awesome/css/font-awesome.min.css')!!}"/>
<link rel="stylesheet" type="text/css" href="{!!url('front/matrix/style.css')!!}"/>
<link id="color-css-btn" rel="stylesheet" type="text/css" href="{!!url('front/matrix/blue.css')!!}"/>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.json-2.4.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/front.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.animate-colors.js')!!}"></script>
<script type="text/javascript" src="{!!url('files/jquery.confirm.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.cookie.js')!!}"></script>
<script src="{{url('front/vue/vue.min.js')}}" type="text/javascript"></script>

</head>
<body id="{!!$body_id!!}">

	  @include('matrix.lib.top')
      @yield('content')
     

</body>
</html>
