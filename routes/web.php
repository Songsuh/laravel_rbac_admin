<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/index', 'DemoController@index');
Route::get('/demo', 'DemoController@demo');//生成大乐透 中奖号码
Route::get('/getp/{user}', 'DemoController@getPermission');//取得是否有这个权限规则

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'PostController@index')->name('home');
Route::resource('posts', 'PostController');
Route::resource('users', 'UserController');
Route::resource('permissions', 'PermissionController');
Route::resource('roles', 'RoleController');

//后台admin
Route::namespace('Admin')->prefix('admin')->group(function (){
    Route::get('login', 'LoginController@login');   //登录页面
    Route::post('doLogin', 'LoginController@doLogin');  //登录逻辑
    Route::get('logout', 'LoginController@logout');     //退出登录
//    Route::get('welcome', 'DashboardController@welcome');
});
//后台登录后 路由
Route::namespace('Admin')->prefix('admin')->middleware(['isAdmin','hasPermission'])->group(function (){
    Route::get('index', 'DashboardController@index')->name("dashboard.index");
    Route::get('welcome', 'DashboardController@welcome');
    Route::resource('admins', 'AdminsController');  //管理用户 管理
    Route::resource('menus', 'MenusController');    //菜单管理
    Route::post('changeMenuStatus','MenusController@changeMenuStatus'); //更改菜单状态
    Route::resource('roles', 'RolesController');    //角色管理
    Route::post('changeRoleStatus','RolesController@changeRoleStatus'); //更改角色状态
    //Route::get('/roles/{role}/rolepermission','RolesController@rolePermission')->name('roles.rolepermission'); //更改权限
    Route::resource('permissions', 'PermissionsController');    //权限管理
//    Route::post('changeRoleStatus','RolesController@changeRoleStatus'); //权限状态
});
