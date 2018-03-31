@extends('phpstore.layout.common')
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
	
    <div class="content">
    	
        <h2>后台表单样式</h2>
        
        <pre class="prettyprint linenums" style="font-size:20px;">
          &lt;?php
             echo phpinfo();
          ?&gt; 
        </pre>
        
        
        
    
    </div>
@stop