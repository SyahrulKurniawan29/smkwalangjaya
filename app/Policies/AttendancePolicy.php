<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    /** Determine whether the user can view any attendance records. */
    public function viewAny(User $user)
    {
        $role = optional($user->role)->name;
        return in_array($role, ['admin', 'wali_kelas', 'guru_bk']);
    }

    /** Determine whether the user can view a specific attendance. */
    public function view(User $user, Attendance $attendance)
    {
        $role = optional($user->role)->name;
        if ($role === 'admin') return true;
        if ($role === 'wali_kelas') {
            // Wali kelas can view attendances for their class
            return $user->id === optional($attendance->classroom)->homeroom_teacher_id || $attendance->classroom_id === optional($user->classroom)->id;
        }
        if ($role === 'guru_bk') return true; // BK can view for counseling context
        return false;
    }

    /** Determine whether the user can create attendance records. */
    public function create(User $user)
    {
        $role = optional($user->role)->name;
        return in_array($role, ['admin', 'wali_kelas']);
    }

    /** Determine whether the user can update attendance records. */
    public function update(User $user, Attendance $attendance)
    {
        $role = optional($user->role)->name;
        return in_array($role, ['admin', 'wali_kelas']);
    }

    /** Determine whether the user can delete attendance records. */
    public function delete(User $user, Attendance $attendance)
    {
        $role = optional($user->role)->name;
        return $role === 'admin';
    }
}
