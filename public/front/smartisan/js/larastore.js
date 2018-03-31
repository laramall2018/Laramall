
/*
|----------------------------------------------------------------------------
|
|  smatisan模板前端js
|
|----------------------------------------------------------------------------
*/

var  larastore 				= {};
	 larastore.goods 		= {};
	 larastore.user 		= {};


/*
|----------------------------------------------------------------------------
|
|  商品相册效果
|
|----------------------------------------------------------------------------
*/
larastore.goods.gallery 	= function(){

	$(document).on('click','img.gallery-thumb',function(){

		$(this).parent('.gallery-list').find('.gallery-thumb').removeClass('gallery-thumb-active');
		$(this).addClass('gallery-thumb-active');
		var curr_src 	= $(this).attr('src');
		$(this).parent('.gallery-list').parent('.goods-item').find('a.thumb-img img').attr('src',curr_src);
	})
}


/*
|----------------------------------------------------------------------------
|
|  商品详情页面 切换效果
|
|----------------------------------------------------------------------------
*/
larastore.goods.detail  = function(){

	$(document).on('click','.thumb-list img',function(){

		 $(this).addClass('on').siblings('.thumb-list img').removeClass('on');
		 var curr_img 	= $(this).data('img');
		 $('.detail-img .goods-img').attr('src',curr_img);
	})
}


/*
|----------------------------------------------------------------------------
|
|  设置弹出框内容
|
|----------------------------------------------------------------------------
*/
larastore.user.popbox = function(){
	$(function(){
		$(document).on('click','.user-edit-btn',function(){
			larastore.user.popboxcontent();
		})
	})
}



/*
|----------------------------------------------------------------------------
|
|  设置弹出框内容
|
|----------------------------------------------------------------------------
*/
larastore.user.popboxcontent  = function(){

	// instanciate new modal
	var modal = new tingle.modal({
    	footer: true,
    	stickyFooter: false,
    	cssClass: ['custom-class-1', 'custom-class-2']
	});

	// set content
	var str 		= $('#form-content').html();
	modal.setContent(str);

	// add a button
	modal.addFooterBtn('关闭', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
    	// here goes some logic
    	modal.close();
	});
	// open modal
	modal.open();
}









