<div class="container">
<div class="row">
<div class="card">
<div class="card-content">
<div class="row">

  <form action="{!!url('demo')!!}" method="post" class="col s12">
    {!!csrf_field()!!}
    <div class="row">
      <div class="input-field col s12">
        <input id="icon_prefix" name="password" type="text" class="validate" value="demo888">
        <label for="icon_prefix">demo密码</label>
      </div>
      <div class="input-field col s12">
        <button type="submit" class="btn red">
          <i class="material-icons left">done</i>
          确认
        </button>
      </div>

    </div>
  </form>

</div>
</div>
</div>
</div>
</div>
