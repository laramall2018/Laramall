
<div class="container">
<div class="goods-box">
<div class="row">
<script type="text/javascript" src="{!!url('front/matrix/jetzoom/jetzoom.js')!!}"></script>
<script type="text/javascript" src="{!!url('front/matrix/fancybox/jquery.fancybox.js')!!}"></script>
<link href="{!!url('front/matrix/jetzoom/jetzoom.css')!!}" type="text/css" rel="stylesheet" />
<link href="{!!url('front/matrix/fancybox/jquery.fancybox.css')!!}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{!!url('front/matrix/bootstrap/js/bootstrap.min.js')!!}"></script>
<script type="text/javascript">
            JetZoom.quickStart();
			$(function(){
        		$('#zoom1').bind('click',function(){
            		var jetZoom = $(this).data('JetZoom');
            		$.fancybox.open(jetZoom.getGalleryList());
            		return false;
        		});
    		});
</script>

    @if($gallery)
    <div class="col-md-9">
    	<div class="row">
        	<div class="col-md-7">

               @if($img)
               <div class="img-wrap">
               		<img id="zoom1"
                    	class="big  jetzoom"
                        src="{{$img->img()}}"
                        title="{!!$goods->goods_name!!}"
                        alt="{!!$goods->goods_name!!}"
                        data-jetzoom = "zoomImage: '{{$img->_original()}}'" />
               </div>
               @endif
               <ul class="goods-thumb clearfix">
               @foreach($gallery as $item)
               <li class="list">
               		<img  src="{{$item->thumb()}}"
                    	  class="jetzoom-gallery text-center"
                          data-jetzoom =
         "useZoom: '#zoom1', image: '{{$item->img()}}', zoomImage: '{{$item->_original()}}'"
                            /></li>

               @endforeach
               </ul>
            </div>
            <div class="col-md-5">

                @include('matrix.lib.goods.text_info')

            </div><!--/col-md-3-->
        </div><!--/row-->
    </div><!--/col-md-9-->
    @endif

    <div class="col-md-3">
        @include('matrix.lib.goods.buy_btn')
    </div><!--/col-md-3-->
</div><!--/row-->
</div><!--/goods_box-->
</div><!--/container-->

<div class="container">

	<div class="goods-nav-title">
    	<div class="item item-curr">商品详情</div>
      <div class="item">商品评论</div>
      <div class="item">商品标签</div>
  </div>



        <div class="nav-content">
    		{!!$goods->goods_desc!!}
       </div>
       <div class="nav-content" style="display:none;">
       		@include('matrix.lib.goods.duoshuo')
       </div>
       <div class="nav-content" style="display:none;">
       		@include('matrix.lib.goods.tag')
       </div>


</div>

<script type="text/javascript">

		$(function(){
				front.goods.jetzoom();
				front.goods.tab();
        front.goods.num();
        front.goods.buy("{!!url('ajax-buy')!!}");
        front.goods.cart("{!!url('ajax-buy')!!}");
        front.goods.tag("{!!url('ajax-tag')!!}");
			});

</script>
