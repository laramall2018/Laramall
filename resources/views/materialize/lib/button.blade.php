<div class="row button-box">
<div class="col s3">
<div class="icon-item text-center">
	<a href="{!!url('/')!!}">
		<i @if(Request::url() == url('/')) class="material-icons pink-text" @else class="material-icons  white-text valign" @endif>home</i>
	</a>
</div>
</div><!--/col s3-->
<div class="col s3">
<div class="icon-item">
	<a href="{!!url('catalog')!!}">
	<i @if(Request::route()->getName() == 'front.catalog') class="material-icons  pink-text " @else class="material-icons  white-text" @endif>reorder</i>
	
	</a>
</div>
</div><!--/col s3-->
<div class="col s3">
<div class="icon-item">
	<a href="{!!url('help')!!}">
		<i @if(Request::url() == url('help')) class="material-icons  pink-text valign" @else class="material-icons  white-text valign" @endif>library_books</i>
    </a>
</div>
</div><!--/col s3-->
<div class="col s3">
<div class="icon-item">
	
	<a href="{!!url('auth/center')!!}">
		<i @if(Request::url() == url('auth/center')) class="material-icons  pink-text valign" @else class="material-icons  white-text valign" @endif>perm_identity</i>
	</a>
</div>
</div><!--/col s3-->
</div>
