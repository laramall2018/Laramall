
<div class="ps-tab-content-item cur">
    
    <div id="app">
    <div class="row theme-item">
   
    <div class="col-md-4" v-for="theme in themes.themes">
        <img v-bind:src="theme.cover" v-bind:class="{active:theme.is_checked == 1}" alt="" class="img-thumbnail theme-thumb">
        <p>@{{theme.name}}</p>
        <span class="btn btn-success" v-if="theme.is_checked == 1">
        <i class="fa fa-check"></i>
        当前模板
        </span>
        <span v-else class="btn btn-default" v-bind:data-id="theme.id" v-on:click="setDefault">
            设为当前
        </span>
        <span class="btn btn-danger" v-bind:data-id="theme.id" v-on:click="deleteTheme">
            <i class="fa fa-times"></i>
            删除模板
        </span>
    </div><!--/col-md-4-->

    </div><!--/theme-item-->
    
    <div class="row theme-item">
        <div class="row">
        <div class="col-md-4">
            <input type="text" v-model="name" class="form-control" v-bind:placeholder="name">
        </div>
        </div><!--/row-->
        <div class="row">
        <div class="col-md-4">
            <select v-model="type" class="form-control">
                <option value="pc">PC版本</option>
                <option value="mobile">手机版本</option>
            </select>
        </div>
        </div><!--/row-->
        <div class="row">
        <div class="col-md-4">
            <span class="btn btn-success" v-on:click="addTheme">
                <i class="fa fa-check"></i>
                添加模板
            </span>
        </div>
        </div><!--/row-->

    </div><!--/row-->

    </div><!--/app-->

</div><!--/ps-tab-content-item -->
<script type="text/javascript">
    var app = new Vue({

            el:'#app',
            data:{
                    themes:[],
                    name:'模板名称-英文',
                    type:'pc',
                    
            },

            created:function(){

                this.getThemeList();
            },
            methods:{
                //获取列表
                getThemeList:function(){

                    $.ajax({

                        type:'GET',
                        url:"{{url('admin/theme-json')}}",
                        dataType:'json',
                        success:function(data){

                            app.themes = data;
                        }
                    });
                },

                //添加模板
                addTheme:function(){

                    var name    = this.name;
                    var type    = this.type;
                    $.ajax({

                        type:'POST',
                        url:"{{url('admin/theme-add')}}",
                        data:'name=' + name + '&type=' + type,
                        dataType:'json',
                        success:function(data){

                            if(data.tag == 'error'){

                                alert(data.info);
                                return false;
                            }
                            if(data.tag == 'success'){
                                swal("操作成功","您已成功添加模板","success");
                                app.themes = data;
                            }
                            
                        }
                    })
                },

                //删除
                deleteTheme:function(event){

                    var that    = event.currentTarget;
                    var id      = $(that).data('id');
                    $.ajax({

                        type:'DELETE',
                        url:"{{url('admin/theme-delete')}}",
                        data:'id=' + id,
                        dataType:'json',
                        success:function(data){

                            if(data.tag == 'error'){

                                swal({
                                    title:"信息提示",
                                    text:data.info,
                                    html:true
                                });
                                return false;
                            }

                            app.themes  = data;
                        }

                    });
                },

                //设置为当前模板
                setDefault:function(event){

                    var that        = event.currentTarget;
                    var id          = $(that).data('id');
                    $.ajax({

                        type:'POST',
                        url:"{{url('admin/theme-default')}}",
                        data:'id=' + id,
                        dataType:'json',
                        success:function(data){
                            if(data.tag =='success'){
                                swal("设置成功","您已成功设置默认模板","success");
                                app.themes = data;
                            }

                        }
                    })
                }
            }
    });
</script>