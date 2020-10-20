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
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a href="">演示</a>
                <a>
                    <cite>导航元素</cite></a>
            </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
    </a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <div class="layui-input-inline ">
                        <button class="layui-btn layui-btn-xs"  onclick="xadmin.open('新建角色','{{ url('admin/roles/create') }}', 500, 600)" ><i class="layui-icon">&#xe608;</i>新增角色</button>
                    </div>
                    <hr>
                    <blockquote class="layui-elem-quote">每个tr 上有两个属性 cate-id='1' 当前分类id fid='0' 父级id ,顶级分类为 0，有子分类的前面加收缩图标<i class="layui-icon x-show" status='true'>&#xe623;</i></blockquote>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn layui-btn-danger" onclick="delAll()">
                        <i class="layui-icon"></i>批量删除</button>
                </div>
                <div class="layui-card-body ">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th width="20">
                                <input type="checkbox" name="" lay-skin="primary">
                            </th>
                            <th width="70">ID</th>
                            <th>角色名</th>
                            <th width="200">guard名</th>
                            <th width="80">排序</th>
                            <th width="80">状态</th>
                            <th width="250">操作</th>
                        </thead>
                        <tbody class="x-cate">
                        @foreach($rolelist as $v)
                            <tr cate-id='{{ $v->id }}' fid='{{ $v->pid }}' >
                                <td>
                                    <input type="checkbox" name="" lay-skin="primary">
                                </td>
                                <td>{{ $v->id }}</td>
                                <td>
                                    @if($v->child == '1')
                                        <i class="layui-icon x-show" status='true'>&#xe625;</i>
                                    @else
                                        <i class="layui-icon">&#xe67e;</i>
                                    @endif
                                    {{ $v->name }}
                                </td>
                                <td>{{ $v->guard_name }}</td>
                                <td>{{ $v->sort }}</td>
                                <td>
                                    <input type="checkbox" mid="{{$v->id}}" name="status" lay-filter="switchT"  lay-text="开启|停用" @if($v->status == 1) checked  @endif lay-skin="switch">
                                </td>
                                <td class="td-manage">
                                    <button class="layui-btn layui-btn layui-btn-xs"  onclick="xadmin.open('菜单编辑','{{ route('roles.edit',['id'=>$v->id]) }}', 800, 600)" ><i class="layui-icon">&#xe642;</i>编辑</button>
                                    <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,{{$v->id}})" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use(['form'], function(){
        form = layui.form;
        //switch 事件
        form.on('switch(switchT)', function (data) {
            var contexts;
            var status;
            var x = data.elem.checked;//判断开关状态
            var id = $(this).attr('mid');
            if (x==true) {
                status = 1;
                contexts = "你确定要启动么";
            } else {
                status = 0;
                contexts = "你确定要关闭么";
            }
            layer.open({
                content: contexts
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    data.elem.checked = x;
                    form.render();
                    layer.close(index);

                    $.ajax({
                        type: 'POST',
                        dataType:'json',
                        url: '/admin/changeRoleStatus',
                        data: {"id":id,"status":status},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend:function(){
                            layer.msg('正在切换中，请稍候',{icon: 16,time:false,shade:0.8});
                        },
                        error: function(data){
                            console.log(data);
                            layer.msg('数据异常，操作失败！8');
                        },
                        success: function(res,err){
                            if(res.code == 1){
                                layer.msg(res.msg,{icon: 6});
                                // layer.alert(res.msg, {icon: 6},function () {
                                //     // return false;
                                // });
                            }else{
                                layer.msg("操作失败",{icon: 5});
                            }
                        },
                    });
                }
                , btn2: function (index, layero) {
                    //按钮【按钮二】的回调
                    data.elem.checked = !x;
                    form.render();
                    layer.close(index);
                    //return false 开启该代码可禁止点击该按钮关闭
                }
                , cancel: function () {
                    //右上角关闭回调
                    data.elem.checked = !x;
                    form.render();
                    //return false 开启该代码可禁止点击该按钮关闭
                }
            });
            return false;
        });
    });
    /*用户-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            $.ajax({
                type: 'DELETE',
                url: "/admin/roles/"+id,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res,err){
                    if(res.code == 1){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }else{
                        layer.alert("删除失败", {icon: 5},function () {
                            return false;
                        });
                    }

                },
                error: function (error){
                    console.log(error);
                }
            })
        });
    }

    // 分类展开收起的分类的逻辑
    //
    $(function(){
        return false;
        $("tbody.x-cate tr[fid!='0']").hide();
        // 栏目多级显示效果
        $('.x-show').click(function () {
            if($(this).attr('status')=='true'){
                $(this).html('&#xe625;');
                $(this).attr('status','false');
                cateId = $(this).parents('tr').attr('cate-id');
                $("tbody tr[fid="+cateId+"]").show();
            }else{
                cateIds = [];
                $(this).html('&#xe623;');
                $(this).attr('status','true');
                cateId = $(this).parents('tr').attr('cate-id');
                getCateId(cateId);
                for (var i in cateIds) {
                    $("tbody tr[cate-id="+cateIds[i]+"]").hide().find('.x-show').html('&#xe623;').attr('status','true');
                }
            }
        })
    })

    var cateIds = [];
    function getCateId(cateId) {
        $("tbody tr[fid="+cateId+"]").each(function(index, el) {
            id = $(el).attr('cate-id');
            cateIds.push(id);
            getCateId(id);
        });
    }

</script>
</body>
</html>
