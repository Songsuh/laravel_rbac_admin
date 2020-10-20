<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    //
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'password',
    ];

    // 用户和角色的模型关联关系
    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }

    public function hasPermission($permission_id,$role_id)
    {
        $res = DB::table('role_has_permissions')->where(['permission_id'=>$permission_id,'role_id'=>$role_id])->first();
        if($res) return true;
        return false;
    }
}
