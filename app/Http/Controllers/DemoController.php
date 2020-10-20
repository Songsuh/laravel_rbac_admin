<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DemoController extends Controller
{
    //
    public function index(User $user){
//        $role = $user->roles()->pluck('name');
//        dd($role);
        return view('demo.index');
    }
    public function getPermission(User $user){
//        $user->givePermissionTo('edit articles');
//        $user->revokePermissionTo('edit articles');
//        $user->assignRole(['writer', 'admin']);
        $roles = $user->roles()->pluck('name');
        dump($roles);
        echo "<pre>";
        print_r($user->toArray());
        echo "</pre>";
        $permissions = $user->permissions;
        echo "<pre>";
        print_r($permissions);
        echo "</pre>";
    }
    //生成大乐透 中奖号码
    public function demo()
    {
        $a = [1,2,4,5,11,12,13,15,16,17,20,21,23,28,31,32,33,34,35];
        $m = [1,2,4,7,8,10,12];
        $str = [];
        for ($i=1;$i<=10;$i++){
            $sA = [];
            $sN = [];
            $b = [];

            $b = array_rand($a,5);//随机键名
            $n = array_rand($m,2);//随机键名
            foreach ($b as $k=>$v){
                $sA[] = $a[$v];
            }
            foreach ($n as $kk=>$vv){
                $sN[] = $m[$vv];
            }
            $s = implode(',',$sA).' | '.implode(',',$sN);
            $str[] = $s;
        }
        dd($str);
    }
}
