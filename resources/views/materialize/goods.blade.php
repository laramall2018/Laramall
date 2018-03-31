@extends('materialize.layout.common-goods')
@section('title')
{!!$title!!}
@stop

@section('content')
       @include('materialize.lib.breadcrumb')
       @include('materialize.lib.goods_img')
       @include('materialize.lib.goods_info')
       <script type="text/javascript">
          $(function(){

              $('.slider').slider({

                  height:300
              });

              $( '.swipebox' ).swipebox();
              $('select').material_select();

          })
       </script>
@stop
