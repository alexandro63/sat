<?php

namespace App\Utils;

use Spatie\Permission\Models\Role;
use App\Models\User;

class Util
{

    public function getRoleData()
    {
        $roles_array = Role::pluck('name', 'id');
        $roles = [];

        $is_admin = $this->is_admin(auth()->user());

        foreach ($roles_array as $key => $value) {
            if (!$is_admin && $value == 'Admin') {
                continue;
            }
            $roles[$key] = $value;
        }

        return $roles;
    }

    public function is_admin($user)
    {
        return $user->hasRole('Admin') ? true : false;
    }

    public function getAdmins()
    {
        $admins = User::role('Admin')->get();

        return $admins;
    }
}
