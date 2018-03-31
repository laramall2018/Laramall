<div class="col-md-3">
	<div class="spverticalmenu">
    	<div class="title_block">
        	<i class="fa fa-bars"></i>
        	{!!trans('front.category')!!}
        </div>
        <ul class="category-nav">
        	
            @if($category)
            @foreach($category as $item)
            
            <li class="item">
            	<i class="fa-icon"></i>
                <a href="{!!$item['url']!!}" class="a1">{!!$item['cat_name']!!}</a>
                <i class="fa fa-angle-right right-i"></i>
                
                @if($item['child'])
                <div class="dropdown-menu">
                	<ul class="category-nav-2">
                    	@foreach($item['child'] as $child)
                		<li>
                        	<h2><a href="{!!$child['url']!!}" target="_blank">{!!$child['cat_name']!!}</a></h2>
                            @if($child['child'])
                            <div class="category-nav-3">
                            @foreach($child['child'] as $child2)
                             <p class="item"><a href="{!!$child2['url']!!}" target="_blank">{!!$child2['cat_name']!!}</a></p>
                            @endforeach
                            </div>
                            @endif
                        </li>
                        @endforeach
                	</ul>
                </div><!--/dropdown-menu-->
                @endif
            </li>
            
            @endforeach
            @endif  
            
        </ul>
    </div><!--/menu-->
</div>
<script type="text/javascript">
 $(function(){
	 
	 front.category();
 });
</script>