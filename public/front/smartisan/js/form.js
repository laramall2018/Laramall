/*
|----------------------------------------------------------------------------
|
|  前台使用js生成带 bootstrap的form表单
|
|----------------------------------------------------------------------------
*/

var  lsForm 		= {};


/*
|----------------------------------------------------------------------------
|
|  生成form
|
|----------------------------------------------------------------------------
*/
lsForm.form 		= function(content){

	return  '<form class="form-horizontal">' + content + '</form>';
}


/*
|----------------------------------------------------------------------------
|
|  生成formGroup整体布局
|
|----------------------------------------------------------------------------
*/
lsForm.group = function(label,formDom){

	var str 	= '<div class="form-group">'
				+ '<label class="col-sm-2 control-label">'+label + '</label>'
				+ '<div class="col-md-10">'
				+ formDom
				+ '</div>'
				+ '</div>';
	return str;
}


/*
|----------------------------------------------------------------------------
|
|  生成textarea
|
|----------------------------------------------------------------------------
*/
lsForm.textarea   = function(label,model){

	var formDom   = '<textarea class="form-control" rows="10"'
		          + ' name="' + model +'"' 
		          + 'id="' + model +'"'
				  + '></textarea>';
	return lsForm.group(label,formDom);
}

/*
|----------------------------------------------------------------------------
|
|  生成text
|
|----------------------------------------------------------------------------
*/
lsForm.text   = function(label,model){

	var formDom   = '<input type="text" class="form-control" '
		          + ' name="' + model +'"' 
		          + 'id="' + model +'"'
				  + '>';
	return lsForm.group(label,formDom);
}


/*
|----------------------------------------------------------------------------
|
|  生成下拉选择项目
|
|----------------------------------------------------------------------------
*/
lsForm.select   = function(label,model,option){

	var formDom = '<select class="form-control" id="' + model  +'" name="' + model + '">' 
				+ option 
				+ '</select>';
	return lsForm.group(label,formDom);
}



/*
|----------------------------------------------------------------------------
|
|  生成下拉选项
|
|----------------------------------------------------------------------------
*/
lsForm.option 	= function(data){

	var  str  	= '<option value="">请选择</option>';
	$.each(data,function(i,item){

		str   += '<option value="' +  item.value +'">' + item.name + '</option>';
	})
	return str;
}


/*
|----------------------------------------------------------------------------
|
|  rank option list
|
|----------------------------------------------------------------------------
*/
lsForm.rankOption  = function(){

	var  data  = [
					{'name':1,'value':1},
					{'name':2,'value':2},
					{'name':3,'value':3},
					{'name':4,'value':4},
					{'name':5,'value':5},
	];

	return lsForm.option(data);
}
