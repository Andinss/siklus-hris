<?php

namespace App\Repository;
use DB;
use App\Models\UserRole;

class UserRoleRepository
{
    public function store($user_id, $role_id)
    {
        $user_role = new UserRole;
        $user_role->user_id = $user_id;
        $user_role->role_id = $role_id;
        $user_role->save();
        return $user_role;
    }
}