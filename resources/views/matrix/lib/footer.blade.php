<div class="help-tit">
<div class="help-tit-bb"></div>
</div>


<div class="container help-content">
<div class="row">
	    @if($help)
		@foreach($help as $item)
	  <div class="col-md-3">
		<h4>
				<a href="{!!$item->url()!!}">
					<span class="glyphicon glyphicon-folder-open"></span>
					{!!$item->cat_name!!}
				</a>
		</h4>

		@if($item->getArticle())
		<ul>
		@foreach($item->getArticle() as $key=>$article)
		  @if($key <=5)
			<li><a href="{!!$article->url()!!}">{!!str_limit($article->title,30,'..')!!}</a></li>
			@endif
		@endforeach
	  </ul>
		@endif
	  </div>
		@endforeach
		@endif

</div><!--/help-bb-->
</div><!--/help-->

<div class="footer">
		{!!$copyright!!}{!!$icp!!}
		<span><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259995058'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1259995058' type='text/javascript'%3E%3C/script%3E"));</script></span>
</div>
<script type="text/javascript">
	$(function(){
		front.nav("{!!Request::url()!!}");
		front.color.select("{!!$domain!!}");
		front.common.cart("{!!url('ajax-buy')!!}");
	});
</script>
