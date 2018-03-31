<!-- Modal -->
<div class="modal fade" id="myModalNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">添加商品评论</h4>
      </div>
      <div class="modal-body">
        @include('smartisan.goods.comment.form')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          取消
        </button>
        <button type="button" class="btn btn-success" v-on:click="addCmt">
          添加
        </button>
      </div>
    </div>
  </div>
</div>