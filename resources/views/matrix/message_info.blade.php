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

<script src="{!!url('front/matrix/fancybox/jquery.fancybox.js')!!}" type="text/javascript"></script>
<link href="{!!url('front/matrix/fancybox/jquery.fancybox.css')!!}" type="text/css" rel="stylesheet">
<title>{!!trans('front.user_message')!!}</title>
</head>
<body>
   
    
       
        
        	
            @if($info)
           
            <div class="row">
      <div class="col s12">
        <div class="card-panel red">
          <span class="white-text">
             {!!$info!!} 
          </span>
        </div>
      </div>
    </div>
           
            @endif
             <div class="row">
             <div class="col s12">
            
            	<span class="waves-effect btn-large red" id="close-btn">关闭</span>
          
             </div><!--/col s12-->
            </div>
        
	<script type="text/javascript">
		
		$(function(){
			$('#close-btn').on('click',function(){
				parent.$.fancybox.close();
			});
		});
		
	</script>
    
</body>
</html>