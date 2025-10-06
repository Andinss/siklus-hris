<?php

namespace App\Repository;
use DB;
use App\Models\Role;

class RoleRepository
{
    public function get_all()
    {
        return Role::all();
    }

    public function get_list()
    {
        return Role::all()->sortBy('id')->pluck('name', 'id');
    }

    public function get_one($id)
    {
        return Role::FindOrFail($id);
    }

    public function store($data)
    {
        $role = new Role;
        $role->name = $data['name'];
        $role->save();
        return $role;
    }
}