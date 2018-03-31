<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="myModalLabel">上传用户头像</h4>
      </div>
      <div class="modal-body">
        {!!Form::open(['url'=>'api/user-icon','method'=>'post','files'=>true])!!}
        <div class="form-group">
            <input type="file" name="user_icon">
        </div>
        <div class="form-group">
          <button class="btn btn-success" type="submit">确认上传</button>
        </div>
        {!!Form::close()!!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
