<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.2</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    @include('admin.public.resources')
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form action="" method="POST" class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>规则名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="cate_id" class="layui-form-label">
                    <span class="x-red">*</span>所属菜单
                </label>
                <div class="layui-input-inline" style="width: 60%">
                    <select name="cate_id" id="cate_id" class="layui-input">
                        @foreach($menulist as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="method" class="layui-form-label">
                    <span class="x-red">*</span>HTTP方法
                </label>
                <div class="layui-input-inline" style="width: 60%">
                    <select name="method" id="method" class="layui-input">
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                        <option value="PUT">PATCH</option>
                        <option value="DELETE">DELETE</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="guard_name" class="layui-form-label">
                    <span class="x-red">*</span>guard_name
                </label>
                <div class="layui-input-inline" style="width: 60%">
                    <input type="text" id="guard_name" name="guard_name" required="" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="route" class="layui-form-label">
                    <span class="x-red">*</span>路由
                </label>
                <div class="layui-input-inline" style="width: 60%">
                    <input type="text" id="route" name="route" required="" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="sort" class="layui-form-label">
                    <span class="x-red">*</span>排序
                </label>
                <div class="layui-input-inline" style="width: 60%">
                    <input type="text" id="sort" name="sort" required="" lay-verify="required" autocomplete="off" class="layui-input" value="50">
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //自定义验证规则
        form.verify({
            nikename: function(value){
                if(value.length < 5){
                    return '昵称至少得5个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
        });

        //监听提交
        form.on('submit(add)', function(data){
            // console.log(data);
            //发异步，把数据提交给php
            $.ajax({
                type: 'POST',
                url: '{{ url("admin/permissions") }}',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data.field,
                success: function (res,err){
                    if(res.code == 1){
                        layer.alert(res.msg, {icon: 6},function () {
                            parent.location.reload();
                        });
                    }else{
                        layer.alert("增加失败", {icon: 5},function () {
                            return false;
                        });
                    }

                },
                error: function (error){
                    console.log(error);
                }
            })
            // layer.alert("增加成功", {icon: 6},function () {
            //     // 获得frame索引
            //     var index = parent.layer.getFrameIndex(window.name);
            //     //关闭当前frame
            //     parent.layer.close(index);
            // });
            return false;
        });


        form.on('checkbox(father)', function(data){

            if(data.elem.checked){
                $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                form.render();
            }else{
                $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                form.render();
            }
        });


    });
</script>
</body>

</html>
