<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //登录页面
    public function login()
    {
        $user = Auth::guard('admins')->check();
        if ($user) {
            return redirect('admin/index');
        }
        return view('admin.login');
    }
    //登录验证
    public function doLogin(Request $request)
    {
        $input = $request->except('_token');
//        var_dump($input);die;
        $ruler = [
            'username' => 'required|between:4,18',
            'password' => 'required|between:3,18',
        ];
        $msg = [
            'username.required' => '用户名必须填写！',
            'username.between' => '用户名长度4-18位！',
            'password.required' => '密码必须填写！',
            'password.between' => '密码长度4-18位！',
        ];
        $validator = Validator::make($input, $ruler, $msg);
        if($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }
//        $user = DB::table('admin')->where('name',$input['username'])->first();
//        if(!$user) return redirect('admin/login')
//            ->withErrors('用户名或密码错误！');
        if(Auth::guard('admins')->attempt(['name'=>$input['username'],'password'=>$input['password']])){
            return redirect('admin/index');
        }else{
            return redirect('admin/login')
                ->withErrors('用户名或密码错误！！');
        }
    }
    //退出登录
    public function logout()
    {
        Auth::guard('admins')->logout();
        return redirect('admin/login');
    }
}
