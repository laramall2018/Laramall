<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="{!!url('front/matrix/googlecss/js/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/googlecss/materialize/js/materialize.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/googlecss/js/order.js')!!}"></script>
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="{!!url('front/matrix/googlecss/materialize/css/materialize.min.css')!!}"  media="screen,projection"/>
<link href="{!!url('front/matrix/googlecss/materialize/css/googlefont.css')!!}" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="{!!url('front/matrix/googlecss/css/style.css')!!}" />
<title>{!!trans('front.user_message')!!}</title>
</head>
<body>
   
    
       
        
        	
            @if($messages)
            @foreach($messages->all() as $message)
            <div class="row">
      <div class="col s12">
        <div class="card-panel teal">
          <span class="white-text">
             {!!$message!!} 
          </span>
        </div>
      </div>
    </div>
            @endforeach
            @endif
             <div class="row">
             <div class="col s12">
            
            	<a href="{!!url('message-form')!!}" class="waves-effect btn-large red">返回上一页</a>
          
             </div><!--/col s12-->
            </div>
        

    
    
</body>
</html>