<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    // 用户和角色的模型关联关系
    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    // 角色和权限的模型关联关系
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
