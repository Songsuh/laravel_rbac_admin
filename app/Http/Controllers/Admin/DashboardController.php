<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Menus;
use App\Model\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admins')->user();
        $menus = new Menus();
        $menulist = $menus::all()->toArray();
        $menulist = treeMenu($menulist,0, true);
        //如果不是超管 过滤左侧菜单
        if($user->id != 1){
            $role_id = $user->role_id;
            $role_has_permissions = DB::table('role_has_permissions')->where('role_id',$role_id)->get()->toArray();
            $permission_ids = array_column($role_has_permissions, 'permission_id');
            $permission = new Permission();
            $cate_id = $permission->select('cate_id')->whereIn('id',$permission_ids)->groupBy('cate_id')->get()->toArray();
            $cate_ids = array_column($cate_id, 'cate_id');
            foreach ($menulist as $k=>$v){
                if(!empty($v['child'])){
                    foreach ($v['child'] as $kk=>$vv){
                        if(!in_array($vv['id'], $cate_ids)){
                            unset($menulist[$k]['child'][$kk]);
                        }
                    }
                }else{
                    if(!in_array($v['id'], $cate_ids)){
                        unset($menulist[$k]);
                    }
                }
            }
        }
        return view('admin.dashboard.index',['menulist'=>$menulist,'admin'=>$user]);
    }
    public function welcome()
    {
        return view('admin.dashboard.welcome');
    }
}
