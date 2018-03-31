@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<link href="{!!url('static/icheck/skins/all.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('static/icheck/icheck.js')!!}"></script>

   @include('matrix.lib.breadcrumb')
   
   <div class="container">
   		
        <div id="table-btn">
        
        <table class="table table-bordered table-hover table-striped cart-table">
   		
        <tr>
        	<th style="width:60px;">
                @if($user->isAllChecked() == 1)
            	   <div class="ls-checkbox ls-checkbox-on" id="ls-checkbox-all"></div>
                @else
                   <div class="ls-checkbox" id="ls-checkbox-all"></div>
                @endif
            </th>
            <th style="width:110px;">{!!trans('front.thumb')!!}</th>
            <th>{!!trans('front.goods_name')!!}</th>
            <th>{!!trans('front.goods_attr')!!}</th>
            <th>{!!trans('front.shop_price')!!}</th>
            <th>{!!trans('front.cart_number')!!}</th>
            <th>{!!trans('front.total')!!}</th>
            <th>{!!trans('front.operation')!!}</th>
        </tr>
        @if($cart_list)
   		@foreach($cart_list as $item)
        <tr>
        	<td style="vertical-align:middle; text-align:center;">
            	@if($item->is_checked == 1)
                <div class="ls-checkbox ls-checkbox-on ls-checkbox-item" data-id="{{$item->id}}"></div>
                @else
                <div class="ls-checkbox ls-checkbox-item" data-id="{{$item->id}}"></div>
                @endif
            </td>
            <td>
                   @if($item->goods)
            		<a href="{{$item->goods->url()}}" target="_blank">
                        @if($item->goods->thumb())
                    	<img src="{{$item->goods->thumb()}}" class="cart-thumb img-thumbnail" />
                        @else
                        <img src="{{url('front/matrix/images/phpstore-def.png')}}" class="cart-thumb img-thumbnail" />
                        @endif
                    </a>
                   @endif
            </td>
            <td style="vertical-align:middle; text-align:center;">
                <a href="{{$item->goods->url()}}" target="_blank">
                    {{$item->goods_name}}
                </a>
            </td>
            <td style="vertical-align:middle; text-align:center;">{{$item->goods_attr}}</td>
            <td style="vertical-align:middle; text-align:center;">{{$item->shop_price}}</td>
            <td style="vertical-align:middle; text-align:center;width:100px;">
            	<div class="cart-num-btn">
                	<span class="cart-add-btn glyphicon glyphicon-plus" data-id="{!!$item->id!!}" data-tag="add"></span>
                    <input type="text" class="form-control goods_number" name="goods_number" id="goods_number{!!$item->id!!}" value="{!!$item->goods_number!!}" />
                    <span class="cart-sub-btn glyphicon glyphicon-minus" data-id="{!!$item->id!!}" data-tag="sub"></span>
                </div>
            </td>
            <td style="vertical-align:middle; text-align:center;">
            	<span id="cart-list-total-{!!$item->id!!}" class="cart-list-total">{{$item->total()}}</span>
            </td>
            <td style="vertical-align:middle; text-align:center;">
            	<span class="btn btn-danger del cart-del-btn" data-id="{!!$item->id!!}">
                	<i class="fa fa-times"></i>
                	{!!trans('front.delete')!!}
                </span>
            </td>
        
        </tr>
        @endforeach
        @endif
   </table>
   
   	    </div>
   
   		
        <div class="alert alert-success">
        	<div class="row">
            	
                <div class="col-md-4">
                	<span class="cart-total">
                    	总计：<span class="num">{{$amount}}{!!trans('front.price_tag')!!}</span>
                             <span class="checked_number">{{$number}}</span>
                             <span>/</span>
                             <span class="total_number">{{$all_number}}</span>

                    </span>
                </div>
                <div class="col-md-offset-4 col-md-4 text-right">
                
            		<a class="btn btn-primary btn-lg" href="{!!url('/')!!}">
                    	
                        <i class="fa fa-arrow-circle-o-left"></i>
                        {!!trans('front.continue')!!}
                    </a>
                    <a class="btn btn-info btn-lg" href="{!!url('checkout')!!}">
                    	{!!trans('front.checkout')!!}
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                    
                </div>
            
            </div>
            
        </div><!--/alert-->
        
   </div><!--/container-->
<script type="text/javascript">
	$(function(){
		front.cart.number("{!!url('cart-number-update')!!}","{!!csrf_token()!!}");
		front.cart.delete("{!!url('cart-delete')!!}","{!!csrf_token()!!}");
        front.cart.checked("{{url('cart-checked')}}");
        front.cart.checked_all("{{url('cart-checked-all')}}");
	})
</script>
@stop