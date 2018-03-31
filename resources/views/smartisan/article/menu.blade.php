
<div class="menu-left">

    <div class="panel panel-goods">
    	<div class="panel-heading">
            <h4>新闻分类</h4>
        </div><!--/heading-->
        <div class="panel-body">
            <ul class="menu-nav">
             @if($article_category)
             @foreach($article_category as $cat)
             <li @if($cat->id == $cat_id) class="active" @endif>
                 <a href="{{$cat->url()}}">{{$cat->cat_name}}</a>
             </li>
             @endforeach
             @endif
        	</ul>
        </div><!--/panel-body-->
    </div><!--/panel-->
</div>
