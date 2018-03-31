<!DOCTYPE html>
<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="{!!url('front/matrix/googlecss/js/jquery.min.js')!!}"></script>
      <script type="text/javascript" src="{!!url('front/matrix/googlecss/materialize/js/materialize.min.js')!!}"></script>
      <script type="text/javascript" src="{!!url('front/matrix/googlecss/js/order.js')!!}"></script>
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="{!!url('front/matrix/googlecss/materialize/css/materialize.min.css')!!}"  media="screen,projection"/>
      <link href="{!!url('front/matrix/googlecss/materialize/css/googlefont.css')!!}" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="{!!url('front/matrix/googlecss/css/style.css')!!}" />
      <title>{!!trans('front.user_message')!!}</title>
    </head>
    <body>
        
        
  <div class="row">
    
        {!!Form::open(['url'=>'message','method'=>'post','files'=>true,'class'=>'col s12'])!!}
        
      
        <div class="row">
        <div class="input-field col s12">
          
          <input id="username" name="username" type="text" class="validate" length=20  @if(Auth::check('user')) value="{!!Auth::user('user')->username!!}" @endif>
          <label for="username">用户名称</label>
        </div>
            
        <div class="row">
        <div class="input-field col s12">
         
          <input id="email" name="email" type="email" class="validate" @if(Auth::check('user')) value="{!!Auth::user('user')->email!!}"   @endif>
          <label for="email" data-error="格式错误" data-success="正确">电子邮件</label>
        </div>
       </div><!--/row-->
       
                   
             
             
       <div class="row">
        <div class="input-field col s12">
          
          <textarea id="content" name="content" class="materialize-textarea"></textarea>
          <label for="content">留言内容</label>
         </div>
       </div><!--/row-->
       
       
     
      <div class="row">
           
          <div class="input-field col s12">
    <select name="type" id="type">
      <option value="留言" selected>留言</option>
      <option value="建议">建议</option>
      <option value="意见">意见</option>
    </select>
    
  </div>

     
     </div>
        
    
  <div class="row">
      <div class="input-field col s10">
    <button type="submit" class="waves-effect btn-large red">
    <i class="material-icons left">done</i>
    确认
    </button>
      </div>
      
 </div>
      
    

      {!!Form::close()!!}
      
  </div><!--/row--> 
  <script type="text/javascript">
  $(document).ready(function() {
      $('select').material_select();
    });
  </script>
   
</body>
</html>