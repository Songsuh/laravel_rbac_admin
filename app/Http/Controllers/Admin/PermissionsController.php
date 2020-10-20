<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menus;
use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = new Permission();
        $cateId = $permission->select('cate_id')->groupBy('cate_id')->pluck('cate_id');
        $menus = new Menus();
        $menu = $menus->whereIn('id', $cateId)->get()->toArray();
        $lists = [];
        foreach ($menu as $k=>$v){
            $v['cate_id'] = 0;
            $list = $permission->where('cate_id',$v['id'])->get()->toArray();
            $v['child'] = count($list);
            $lists[] = $v;
            foreach ($list as $kk=>$vv){
                $vv['name'] = "|--".$vv['name'];
                $lists[] = $vv;
            }
        }
        return view('admin.permissions.index',['permissionlist'=>$lists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = new Menus();
        $menulist = $menus::all();
        $menulist = treeMenu($menulist,0);
        $menulist = menuList($menulist);
        return view('admin.permissions.create',['menulist'=>$menulist]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request['name'];
        $permission->cate_id = $request['cate_id'];
        $permission->guard_name = $request['guard_name'];
        $permission->route = $request['route'];
        $permission->method = $request['method'];
        $permission->sort = $request['sort'];
        $result = $permission->save();
        if($result){
            $data['code'] = 1;
            $data['msg'] = '新增成功';
            $data['data'] = [];
        }else{
            $data['code'] = -1;
            $data['msg'] = '新增失败';
            $data['data'] = [];
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menus = new Menus();
        $menulist = $menus::all();
        $menulist = treeMenu($menulist,0);
        $menulist = menuList($menulist);
        $permission = DB::table('permissions')->find($id);
        return view('admin.permissions.edit',['permission'=>$permission,'menulist'=>$menulist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request['name'];
        $permission->cate_id = $request['cate_id'];
        $permission->guard_name = $request['guard_name'];
        $permission->route = $request['route'];
        $permission->sort = $request['sort'];
        $result = $permission->save();
        if($result){
            $data['code'] = 1;
            $data['msg'] = '修改成功';
            $data['data'] = [];
        }else{
            $data['code'] = -1;
            $data['msg'] = '修改失败';
            $data['data'] = [];
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Permission::destroy($id);
        if($result){
            $data['code'] = 1;
            $data['msg'] = '菜单删除成功';
            $data['data'] = [];
        }else{
            $data['code'] = -1;
            $data['msg'] = '菜单删除失败';
            $data['data'] = [];
        }
        return $data;
    }
}
