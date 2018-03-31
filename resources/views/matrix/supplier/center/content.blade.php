
<div class="panel panel-default">
<div class="panel-heading">
	<h5>{!!trans('front.supplier_center')!!}</h5>
</div>
<div class="panel-body">
	
   @if(Auth::user('supplier')->tag == 0)
   <div class="alert alert-danger">
   		<i class="fa fa-info"></i>
        {!!trans('front.supplier_fails')!!}
   </div>
   @endif
   
   @include('matrix.supplier.center.form')

</div><!--/panel-body-->
</div><!--/panel-->