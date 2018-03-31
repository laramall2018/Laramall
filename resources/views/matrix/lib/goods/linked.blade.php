<div class="panel panel-success">
    
    <div class="panel-heading">
    	<h5>关联产品</h5>
    </div>
	<div class="panel-body">
    
    	<div class="xg-grid text-center">
        	@if($relation_goods)
            @foreach($relation_goods as $item)
        	<div class="item">
            	<div class="pic">
                 <a href="{!!url($item['url'])!!}">
                 	@if($item['gallery'])
                 	<img src="{!!url($item['gallery']->thumb)!!}" alt="{!!$item['goods_name']!!}" />
                    @else
                    <img src="{!!url('front/matrix/images/phpstore-def.png')!!}" alt="{!!$item['goods_name']!!}" />
                    @endif
                 </a>
                </div><!--/pic-->
                
                	<p class="text"><a href="{!!url($item['url'])!!}">{!!$item['goods_name']!!}</a></p>
            </div>
            @endforeach
            @endif
        </div>
   
    </div>
    
</div>