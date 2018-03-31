
/*
|-------------------------------------------------------------------------------
|
| 添加权限的时候 对表单进行验证
|
|-------------------------------------------------------------------------------
*/
$(function(){

    

      

        // validate signup form on keyup and submit
        $(".common-form").validate({

            success: function(label) {    label.addClass("valid").html('<i class="fa fa-check"></i>');  },
            rules: {

                        privi_name: {
                                        required: true,
                                        minlength: 2,
                                        
                                    },
                        privi_code:{

                        				required:true,
                        				minlength:2
                        }

                    },
            messages: {

                        privi_name: {
                            required: "*请输入权限名称*",
                            minlength: "*权限名称至少2位*"
                        },

                        privi_code:{

                        	required:"*请输入权限代码*",
                        	minlength:"*权限代码至少2位*"
                        }

            }
        });

})
