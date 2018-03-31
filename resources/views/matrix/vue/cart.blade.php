@extends('matrix.layout.vue')
@section('title')
{!!$title!!}
@stop

@section('content')


   @include('matrix.lib.breadcrumb')
   
   <div class="container" id="app">
   		
        
       
        <table class="table table-bordered table-hover table-striped cart-table">
      
        <tr>
          <th style="width:60px;">
               
                 <div class="ls-checkbox ls-checkbox-on" id="ls-checkbox-all" v-if="carts.is_all_checked == 1" v-on:click="checkAll"></div>
                 <div class="ls-checkbox" id="ls-checkbox-all" v-else v-on:click="checkAll"></div>
              
            </th>
            <th style="width:110px;">{!!trans('front.thumb')!!}</th>
            <th>{!!trans('front.goods_name')!!}</th>
            <th>{!!trans('front.goods_attr')!!}</th>
            <th>{!!trans('front.shop_price')!!}</th>
            <th>{!!trans('front.cart_number')!!}</th>
            <th>{!!trans('front.total')!!}</th>
            <th>{!!trans('front.operation')!!}</th>
        </tr>
       
            <tr v-for="cart in carts.cart_list" v-bind:cart="cart" >
              <td style="vertical-align:middle; text-align:center;">
              
                <div class="ls-checkbox ls-checkbox-on ls-checkbox-item" v-if="cart.is_checked == 1" v-bind:data-id="cart.id" v-on:click="checkedItem"> 
                </div>
                <div class="ls-checkbox ls-checkbox-item" v-else v-bind:data-id="cart.id" v-on:click="checkedItem">
                </div>
              </td>
              <td style="vertical-align:middle; text-align:center;"><img v-bind:src="cart.thumb" class="cart-thumb img-thumbnail"></td>
              <td>@{{cart.goods_name}}</td>
              <td>@{{cart.goods_attr}}</td>
              <td>@{{cart.shop_price}}</td>
              <td>
                
                  <div class="cart-num-btn">
                  <span class="cart-add-btn glyphicon glyphicon-plus" 
                        v-bind:data-id="cart.id" 
                        data-tag="add" 
                        v-on:click="changeNumber"></span>
                  <input type="text" 
                          class="form-control goods_number" 
                          name="goods_number"
                          v-model="cart.goods_number" />
                    <span class="cart-sub-btn glyphicon glyphicon-minus" 
                          v-bind:data-id="cart.id" 
                          data-tag="sub"
                          v-on:click="changeNumber"></span>
                </div>

              </td>
              <td>@{{cart.total}}</td>
              <td>
                <span class="btn btn-danger" v-bind:data-id="cart.id" v-on:click="deleteItem">
                  <i class="fa fa-times"></i>
                  删除
                </span>
              </td>
            </tr>
       
        </table>
       

        <div class="alert alert-success">
          <div class="row">
              
                <div class="col-md-4">
                  <span class="cart-total">
                      总计：<span class="num">@{{carts.cart_total}}{!!trans('front.price_tag')!!}</span>
                             <span class="checked_number">@{{carts.cart_number}}</span>
                             <span>/</span>
                             <span class="total_number">@{{carts.all_number}}</span>

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

      var app = new Vue({
          el: '#app',
          data: {
                  carts:[]
          },

          created:function(){

              this.getCartList();
          },

          methods:{

                //ajax获取所有列表
                getCartList:function(){

                      $.ajax({
                        url:"{{url('cart-json')}}",
                        type:'GET',
                        dataType:'json',
                        success:function(data){
                          app.carts = data;
                        }
                      });
                },
                //ajax 选择和取消选项
                checkedItem:function(event){


                      var  that            = event.currentTarget;
                      var   id             = $(that).data('id'); 
                      var  is_checked      = 1;

                      if($(that).hasClass('ls-checkbox-on')){

                            is_checked   = 0;
                      }

                      $.ajax({

                          type:'POST',
                          url:"{{url('cart-checked')}}",
                          data:'id=' + id  + '&is_checked=' + is_checked,
                          dataType:'json',
                          success:function(data){

                            app.carts = data;
                          }
                      });

                },

                //ajax 选中所有
                checkAll:function(event){

                   var  is_checked        = 1;
                   var  that              = event.currentTarget;

                   if($(that).hasClass('ls-checkbox-on')){

                        is_checked     = 0;
                   }

                      $.ajax({

                        url:"{{url('cart-checked-all')}}",
                        type:'POST',
                        data:'is_checked=' + is_checked,
                        dataType:'json',
                        success:function(data){

                            app.carts = data;
                        }
                      });
                },

                //ajax 改变商品数量
                changeNumber:function(event){

                    var  that     = event.currentTarget;
                    var  id       = $(that).data('id');
                    var  tag      = $(that).data('tag');

                    $.ajax({

                       type:'POST',
                       url:"{{url('cart-number-update')}}",
                       data:'id=' + id +'&tag=' + tag,
                       dataType:'json',
                       success:function(data){

                         app.carts = data;
                       }
                    })
                },

                //ajax 删除
                deleteItem:function(event){

                    var  that     = event.currentTarget;
                    var  id       = $(that).data('id');
                    var  _token   = "{{csrf_token()}}";
                     

                      $.ajax({
                          type:"POST",
                          url:"{{url('cart-delete')}}",
                          data:'id=' + id + '&_token=' + _token,
                          dataType:'json',
                          success:function(data){

                             app.carts = data;
                          }
                      });
                },
     
          },
      });
   </script>
@stop