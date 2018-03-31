
<div class="container">
<div class="ad-box">
	<div class="row">
    
    	@if($home_ad5)
        <div class="col-md-4">
        	<a href="{!!url($home_ad5->img_url)!!}" target="_blank">
            <img src="{!!url($home_ad5->icon())!!}" class="ad5" alt="{!!$home_ad5->img_name!!}" style="width: 1200px;" />
            </a>
        </div>
        @endif
    	
	</div>
</div>
</div>

<script type="text/javascript">
	$(function(){
			
	  //front.home.border_animate();
	});
</script>