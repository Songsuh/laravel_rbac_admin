<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            @foreach($menulist as $k=>$v)
            <li>
                <a href="javascript:;"
                @if(empty($v['child']))
                    @if($v['route'])
                        onclick="xadmin.add_tab('{{ $v['title'] }}','{{ route($v['route']) }}')"
                    @else
                        onclick="xadmin.add_tab('{{ $v['title'] }}',)"
                    @endif
                @endif
                >
                    <i class="iconfont left-nav-li" lay-tips="权限RBAC">&#xe726;</i>
                    <cite>{{$v['title']}}</cite>
                    @if(!empty($v['child']))
                    <i class="iconfont nav_right">&#xe697;</i>
                    @endif
                </a>
                @if(!empty($v['child']))
                    <ul class="sub-menu">
                        @foreach($v['child'] as $kk=>$vv)
                        <li>
                            @if($vv['route'])
                            <a onclick="xadmin.add_tab('{{ $vv['title'] }}','{{ route($vv['route']) }}')">
                            @else
                            <a onclick="xadmin.add_tab('{{ $vv['title'] }}')">
                            @endif
                                <i class="iconfont">&#xe6a7;</i>
                                <cite>{{ $vv['title'] }}</cite>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
