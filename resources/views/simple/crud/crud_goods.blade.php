@extends('simple.layout.common')
@section('title')
{!!$title!!}
@stop

@section('description')
{!!$description!!}
@stop

@section('keywords')
{!!$keywords!!}
@stop

@section('appname')
{!!$appname!!}
@stop
@section('content')
<script type="text/javascript">
$(function(){
	
	ps.goods_tab();
});
</script>
	
    <div class="content-box">
    <div class="row">
    	<div class="col-md-12">
        {!!$path_url!!}
        </div>
    </div><!--/row-->
    
    <div class="row">
    <div class="col-md-12">
       
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="caption">
					<i class="fa fa-cog"></i>{!!$action_name!!}
				</div>
			</div><!--/panel-heading-->
			
            <div class="panel-body">
			    
               <div class="ps-tab">
                   <form action="{!!url('admin/goods')!!}" method="post" enctype="application/x-www-form-urlencoded" class="form-horizontal">
                   <input type="hidden" name="_token" value="{!!csrf_token()!!}" />
                   
                    <ul class="ps-tab-title">
                    	<li class="cur">基本信息</li>
                        <li>商品相册</li>
                        <li>详情描述</li>
                        <li>其他信息</li>
                        <li>商品属性</li>
                        <li>商品规格</li>
                        <li>关联商品</li>
                        <li>关联新闻</li>
                    </ul>
                    
                    <div class="ps-tab-content">
                    		
                        @include('simple.goods.base')
                        @include('simple.goods.xq')
                        @include('simple.goods.other')
                        @include('simple.goods.attr')
                        @include('simple.goods.field')
                        @include('simple.goods.goods')
                        @include('simple.goods.article')
                    </div>                
               		</form>
               </div><!--/ps-tab-->
               
			</div><!--/portlet-body-->
                                    
		</div><!--/portlet-->
													
    </div><!--/col-md-12-->
    </div><!--/row-->
    </div><!--/content-box-->
@include('simple.lib.js_baidu')
@stop