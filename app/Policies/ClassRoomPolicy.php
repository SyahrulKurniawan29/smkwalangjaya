<?php

namespace App\Policies;

use App\Models\ClassRoom;
use App\Models\User;

class ClassRoomPolicy
{
    public function viewAny(User $user)
    {
        $role = optional($user->role)->name;
        return in_array($role, ['admin', 'wali_kelas', 'guru_bk']);
    }

    public function view(User $user, ClassRoom $classroom)
    {
        return $this->viewAny($user);
    }

    public function create(User $user)
    {
        $role = optional($user->role)->name;
        return in_array($role, ['admin']);
    }

    public function update(User $user, ClassRoom $classroom)
    {
        $role = optional($user->role)->name;
        return in_array($role, ['admin']);
    }

    public function delete(User $user, ClassRoom $classroom)
    {
        $role = optional($user->role)->name;
        return $role === 'admin';
    }
}
