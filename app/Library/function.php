<?php
/***
 * 公共方法
 */

//后台菜单
function menuList($data = []){
    $arr = [];
    foreach ($data as $k=>$v){
        $child = $v['child'];

        if(!empty($child)){
            $v['child'] = 1;
            $arr[] = $v;
            $arr = array_merge($arr, menulist($child));
        }else{
            $v['child'] = 0;
            $arr[] = $v;
        }
    }
    return $arr;
}
//无限递归 菜单树
function treeMenu($list, $id = 0, $flag = true){
    $tree = [];
    foreach ($list as $k=>$v){
        if($v['pid'] == $id){
            $arr = array();
            $arr = treeMenu($list, $v['id'], $flag);
            $v['child'] = $arr;
            if($flag){
                $v['title'] = $v['name'];
                $v['name'] = flagLeng($v['rank']).$v['name'];
            }
            $tree[] = $v;
        }
    }
    return $tree;
}
//多级级标识
function flagLeng($rank = 0, $flag = '|--'){
    $string = '';
    if($rank>0){
        for ($i=1;$i<=$rank;$i++){
            $string .= $flag;
        }
    }
    return $string;
}
