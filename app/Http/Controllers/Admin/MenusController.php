<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = new Menus();
        $menulist = $menus::all();
        $menulist = treeMenu($menulist,0);
        $menulist = menuList($menulist);
//        dd($menulist);
        return view('admin.menus.index',['menulist'=>$menulist]);
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
        return view('admin.menus.create',['menulist'=>$menulist]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menus = new Menus();
        $menus->name = $request['name'];
        $menus->pid = $request['pid'];
        $menus->route = $request['route'];
        $menus->status = $request['status'];
        $parentMenu = DB::table('menus')->where('id', $request['pid'])->first();
        if($parentMenu){
            $menus->rank = $parentMenu->rank+1;
        }else{
            $menus->rank = 0;
        }
        $result = $menus->save();
        if($result){
            $data['code'] = 1;
            $data['msg'] = '菜单添加成功';
            $data['data'] = [];
        }else{
            $data['code'] = -1;
            $data['msg'] = '菜单添加失败';
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
        $menu = DB::table('menus')->find($id);
        return view('admin.menus.edit',['menu'=>$menu,'menulist'=>$menulist]);
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
        $menu = Menus::find($id);
        $menu->name = $request['name'];
        $menu->pid = $request['pid'];
        $menu->route = $request['route'];
        $menu->status = $request['status'];
        $parentMenu = DB::table('menus')->where('id', $request['pid'])->first();
        if($parentMenu){
            $menu->rank = $parentMenu->rank+1;
        }else{
            $menu->rank = 0;
        }
        $result = $menu->save();
        if($result){
            $data['code'] = 1;
            $data['msg'] = '菜单修改成功';
            $data['data'] = [];
        }else{
            $data['code'] = -1;
            $data['msg'] = '菜单修改失败';
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
        $result = Menus::destroy($id);
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

    /**
     * 修改状态
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function changeMenuStatus(Request $request)
    {
        $menu = Menus::find($request['id']);
        $menu->status = $request['status'];
        $result = $menu->save();
        if($result){
            $data['code'] = 1;
            $data['msg'] = '状态修改成功';
            $data['data'] = [];
        }else{
            $data['code'] = -1;
            $data['msg'] = '状态修改失败';
            $data['data'] = [];
        }
        return $data;
    }
}
