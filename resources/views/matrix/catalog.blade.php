@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<script type="text/javascript" src="{!!url('front/matrix/tree/jstree.min.js')!!}"></script>
<link  type="text/css" href="{!!url('front/matrix/tree/themes/default/style.css')!!}" rel="stylesheet" />
   @include('matrix.lib.breadcrumb')

   <div class="container">
   <div class="list-box">
   <div class="row">
   <div class="col-md-12">
         
         <div id="jstree_div">
         {!!$catalog!!}
         </div>
   </div>
   </div><!--/row-->
   </div><!--/list-box-->
   </div><!--/container-->

   <script type="text/javascript">
         $(function () {
               $("#jstree_div").jstree({
                              "checkbox" : {
                                             "keep_selected_style" : false
                              },
                              "plugins" : [ "checkbox" ]
               });
         });
   </script>
@stop