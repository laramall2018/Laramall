<?php echo HTML::script('static/js/jquery.json-2.4.js');?>
<?php echo HTML::script('static/js/phpstore.grid.js');?>
<script type="text/javascript">
   $(function(){   
		ps.ui.grid("{!!$ajax_url!!}","{!!csrf_token()!!}",'{!!$searchInfo!!}');	
   });
</script>