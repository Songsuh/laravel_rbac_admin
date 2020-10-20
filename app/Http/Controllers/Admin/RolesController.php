<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menus;
use App\Model\Permission;
use App\Model\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = new Roles();
        $rolelist = $roles::all();
        $rolelist = treeMenu($rolelist,0);
        $rolelist = menuList($rolelist);
//        dd($rolelist);
        return view('admin.roles.index',['rolelist'=>$rolelist]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = new Roles();
        $rolelist = $roles::all();
        $rolelist = treeMenu($rolelist,0);
        $rolelist = menuList($rolelist);
        //权限
        $permission = new Permission();
        $cateId = $permission->select('cate_id')->groupBy('cate_id')->pluck('cate_id');
        $menus = new Menus();
        $menu = $menus->whereIn('id', $cateId)->get()->toArray();
        $lists = [];
        foreach ($menu as $k=>$v){
            $list = $permission->where('cate_id',$v['id'])->get()->toArray();
            $lists[$v['name']] = $list;
        }
        return view('admin.roles.create',['rolelist'=>$rolelist,'lists'=>$lists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = new Roles();
        $roles->name = $request['name'];
        $roles->pid = $request['pid'];
        $roles->guard_name = $request['guard_name'];
        $roles->status = $request['status'];
        $parentRole = DB::table('roles')->where('id', $request['pid'])->first();
        if($parentRole){
            $roles->rank = $parentRole->rank+1;
        }else{
            $roles->rank = 0;
        }
        $result = $roles->save();
        $id = $roles->id;
        //更新权限
        if($request->has('pr_id')){
            $per_ids = $request['pr_id'];
            $datas = [];
            foreach ($per_ids as $k=>$v){
                $data['permission_id'] = $v;
                $data['role_id'] = $id;
                $datas[] = $data;
            }
            DB::table('role_has_permissions')->insert($datas);
        }

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
        $roles = new Roles();
        $rolelist = $roles::all();
        $rolelist = treeMenu($rolelist,0);
        $rolelist = menuList($rolelist);
        $role = DB::table('roles')->find($id);
        //权限
        $permission = new Permission();
        $cateId = $permission->select('cate_id')->groupBy('cate_id')->pluck('cate_id');
        $menus = new Menus();
        $menu = $menus->whereIn('id', $cateId)->get()->toArray();
        $lists = [];
        foreach ($menu as $k=>$v){
            $list = $permission->where('cate_id',$v['id'])->get()->toArray();
            $lists[$v['name']] = $list;
        }
        $permissionRole = DB::table('role_has_permissions')->where('role_id',$id)->get()->toArray();
        $permission_ids = array_column($permissionRole,'permission_id');
        return view('admin.roles.edit',['role'=>$role,'rolelist'=>$rolelist,'lists'=>$lists,'permission_ids'=>$permission_ids]);
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
        //删除权限
        DB::table('role_has_permissions')->where('role_id',$id)->delete();
        //角色信息
        $role = Roles::find($id);
        $role->name = $request['name'];
        $role->pid = $request['pid'];
        $role->guard_name = $request['guard_name'];
        $role->status = $request['status'];
        $parentRole = DB::table('roles')->where('id', $request['pid'])->first();
        if($parentRole){
            $role->rank = $parentRole->rank+1;
        }else{
            $role->rank = 0;
        }
        //更新权限
        if($request->has('pr_id')){
            $per_ids = $request['pr_id'];
            $datas = [];
            foreach ($per_ids as $k=>$v){
                $data['permission_id'] = $v;
                $data['role_id'] = $id;
                $datas[] = $data;
            }
            DB::table('role_has_permissions')->insert($datas);
        }

        //保存角色信息
        $result = $role->save();
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
        //
//        dd($id);
        $result = Roles::destroy($id);
        if($result){
            $data['code'] = 1;
            $data['msg'] = '删除成功';
            $data['data'] = [];
        }else{
            $data['code'] = -1;
            $data['msg'] = '删除失败';
            $data['data'] = [];
        }
        return $data;
    }

    /**
     * 修改状态
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function changeRoleStatus(Request $request)
    {
        $role = Roles::find($request['id']);
        $role->status = $request['status'];
        $result = $role->save();
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
     * 查看角色权限
     * @param Request $request
     * @param $id
     */
    public function rolePermission(Request $request,$id)
    {
        $permission = new Permission();
        $cateId = $permission->select('cate_id')->groupBy('cate_id')->pluck('cate_id');
        $menus = new Menus();
        $menu = $menus->whereIn('id', $cateId)->get()->toArray();
        $lists = [];
        foreach ($menu as $k=>$v){
            $list = $permission->where('cate_id',$v['id'])->get()->toArray();
            $lists[$v['name']] = $list;
        }
        return view('admin.roles.rolepermission',['lists'=>$lists]);
    }

    /**
     * 更新权限
     * @param Request $request
     */
    public function saveRolePermission(Request $request)
    {
        dd($request);
    }
}
