
<script type="text/javascript" src="{!!url('front/matrix/unslider/js/unslider-min.js')!!}"></script>
<link href="{!!url('front/matrix/unslider/css/unslider.css')!!}" rel="stylesheet" type="text/css" />
<link href="{!!url('front/matrix/unslider/css/def.css')!!}" rel="stylesheet" type="text/css" />

<div class="col-md-9" style="padding-right:0; overflow:hidden;">
<div class="my-slider">
	
    <ul>
    @if($slider)
    @foreach($slider as $item)
    <li>
    	<a href="{!!$item->img_url!!}" target="_blank"><img src="{{$item->icon()}}" style="width: 900px;height: 480px;" /></a>
    </li>
    @endforeach
    @endif
    </ul>

</div><!--/my-slider-->
</div>

<script type="text/javascript">
	$(function(){
		
		$('.my-slider').unslider({
			
			autoplay:true
			
		});
	});
</script>