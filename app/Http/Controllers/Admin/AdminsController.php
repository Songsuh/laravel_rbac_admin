<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminsController extends Controller
{
    /**
     * 管理员列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $admin = new Admin();
        $admins = DB::table('admins')
            ->leftJoin("roles",'admins.role_id','=','roles.id')
            ->select('admins.*','roles.name as rolename')
            ->get();
        return view('admin.admin_user.index',['list'=>$admins]);
    }

    /**
     * 新增管理员页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = new Roles();
        $rolelist = $roles::all();
        $rolelist = treeMenu($rolelist,0);
        $rolelist = menuList($rolelist);

        return view('admin.admin_user.create',['rolelist'=>$rolelist]);
    }

    /**
     * 新增管理员保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 查看单个管理员详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑管理员资料页面
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

        $admin_user = DB::table('admins')->find($id);
        return view('admin.admin_user.edit',['rolelist'=>$rolelist,'admin_user'=>$admin_user]);
    }

    /**
     * 保存编辑
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除管理用户
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
