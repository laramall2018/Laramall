
<form class="form-horizontal" role="form">

  <div class="form-group">
    <label  class="col-sm-2 control-label">评价等级</label>
    <div class="col-sm-10">
      <select v-model="rank" class="form-control">
        
         <option value="1">一星</option>
         <option value="2">两星</option>
         <option value="3">三星</option>
         <option value="4">四星</option>
         <option value="5">五星</option>

      </select>
    </div>
  </div><!--/form-group-->
  
  <div class="form-group">
    <label  class="col-sm-2 control-label">评价内容</label>
    <div class="col-sm-10">
      <textarea v-model="content" class="form-control" cols="30" rows="10"></textarea>
    </div>
  </div><!--/form-group-->

  

</form><!--/form-->