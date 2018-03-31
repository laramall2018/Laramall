<div class="col-md-3">
	<div class="panel panel-success z-depth-1">
    <div class="panel-heading">
        <h5>
        <i class="fa fa-list"></i>
        {!!trans('front.category')!!}
			</h5>
    </div><!--/ps-cat-box-tit-->
    <div class="panel-body">
    	<ul class="nav nav-pills nav-stacked category-tree">
        @if($category)
        @foreach($category as $item)
					<li @if($item->id == $cat->id) class="first active" @else class="first"  @endif>

        <a href="{!!$item->url()!!}" class="a1"><i class="fa fa-chevron-right"></i>{!!$item->cat_name!!}</a>
        @if($item->children()->get())

                	<ul class="nav">
                    	<li>
                    	@foreach($item->children()->get() as $child)
                		<a href="{!!$child->url()!!}" @if($child->id == $cat->id) class="a2 a2-active" @else class="a2" @endif>{!!$child->cat_name!!}</a>

                        @if($child->children()->get())
                        <div class="nav3">
                        @foreach($child->children()->get() as $child2)
                        	<p>
                            	<a href="{!!$child2->url()!!}"
                                	@if($child2->id == $cat->id) class="a3 a3-active" @else class="a3" @endif>
                                    {!!$child2->cat_name!!}
                                </a>
                           </p>
                        @endforeach
                        </div>
                        @endif

                        @endforeach
                        </li>
                	</ul>

        @endif
        </li>
        @endforeach
        @endif
	   </ul>
	 </div><!--/ps-cat-box-body-->

 </div><!--/ps-cat-box-->

</div><!--/col-md-3-->
