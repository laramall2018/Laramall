<div class="slider">
   @if($slider)
    <ul class="slides">
      @foreach($slider as $item)
      <li>
        <img src="{{$item->icon()}}" style="height:200px;"> <!-- random image -->
        <div class="caption center-align">
          <h3>{!!$item->img_name!!}</h3>
          <h5 class="light grey-text text-lighten-3">{!!$item->img_desc!!}</h5>
        </div>
      </li>
      @endforeach
    </ul>
  @endif
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
      $('.slider').slider({
          height:200,
      });
    });
  </script>
