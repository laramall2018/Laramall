<script type="text/javascript">
$(function(){
	
	var second = $('#totalSecond').html();
		second = parseInt(second);
		
		function mytime(){
			 second = second -1 ;
			 $('#totalSecond').html(second);
			
			if(second < 0){
				 window.location.href="{!!url('admin/list')!!}";
			}
       }
	   
		setInterval(mytime, 1000);
});

</script>