
<div class="message-item" v-for="comment in rows.comment_list" v-if="rows.comment_list">
	<div class="alert alert-info tit-box">
		<div class="row">
			<div class="col-md-1">
				
				<img v-if="comment.userIcon" 
					 v-bind:src="comment.userIcon" class="img-thumbnail img-circle thumb">
				
			</div><!--/col-md-2-->
			<div class="col-md-5" style="vertical-align: middle;">
				<span class="type">
				@{{comment.type}}
				</span>
				<span class="username">
				@{{comment.username}}
				</span>
				<span class="price">
				@{{comment.hasReply}}
				</span>

				<a v-bind:href="comment.goods.url" v-if="comment.goods">
					@{{comment.goods.goods_name}}
				</a>
			</div><!--/col-md-1-->
			<div class="col-md-6 text-right">
				<span v-html="comment.rank"></span>
				<span class="time">@{{comment.createTime}}</span>
				<span class="ip">@{{comment.front_ip}}</span>
			</div><!--/col-md-9-->
		</div><!--/row-->
	</div><!--/alert-->

	<div class="msg-content">
		@{{comment.content}}
	</div>
	
		<div class="alert alert-success" v-if="comment.reply">
			<strong>管理员回复：</strong>@{{comment.admin}}
			@{{comment.replyTime}}
		</div>
		<div class="reply-content" v-if="comment.reply">
			@{{comment.reply}}
		</div>

</div>

<div class="message-item" v-else>
	<i class="fa fa-times"></i>
	暂无评价
</div>

