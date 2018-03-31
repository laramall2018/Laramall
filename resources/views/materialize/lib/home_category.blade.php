<div class="row">
<div class="col s12">

  <ul class="collapsible" data-collapsible="accordion">
    <li>
     <div class="collapsible-header"><i class="material-icons">format_line_spacing</i>{!!trans('front.category')!!}</div>
     <div class="collapsible-body">

       <ul class="category-nav">
           <div class="row">
           @if($category)
           @foreach($category as $item)
           <div class="col s6">
           <li class="item">
               <a href="{!!$item->url()!!}" class="a1">

                 {!!$item->cat_name!!}
               </a>
           </li>
          </div>
           @endforeach
           @endif
           </div>
       </ul>

     </div>
   </li>

  </ul>

</div>
</div>
