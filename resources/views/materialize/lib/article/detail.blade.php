<div class="row">
<div class="col s12">
<div class="card-panel">
	
	@if($article_info)
   		<h5 class="tit">
        	{!!$article_info->title!!}
            <small><?php echo date('Y-m-d',$article_info->add_time);?></small>
        </h5>
        <div class="content">
        	{!!$article_info->content!!}
        </div>
   @endif


   @if($model->next())
	<a href="{!!$model->next()->url()!!}">{!!$model->next()->title!!}</a>
   @endif

   @if($model->pre())
	<a href="{!!$model->pre()->url()!!}">{!!$model->pre()->title!!}</a>
   @endif

</div>
</div>	
</div>

<script type="text/javascript">
	
	$(function(){

		$('img').addClass('responsive-img');
	})
</script>