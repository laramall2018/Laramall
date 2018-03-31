<script type="text/javascript">
	var fpapp 	= new Vue({
		el:'#fpapp',
		data:{

			  fp_title:'个人',
			  fp_type:0,
			  fp_content:'',
			  fp_tag:0,

		},
		methods:{

			//改变发票类型
			changeType:function(type){
				this.fp_type = type;
			},
			//改版分类为个人或者公司
			changeTag:function(tag){
				this.fp_tag 	= tag;
			}
		}
	})
</script>