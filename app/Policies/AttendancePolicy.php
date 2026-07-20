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

        // Wali kelas can view attendances for their class (either assigned via classroom_id or as homeroom_teacher)
        if ($role === 'wali_kelas') {
            $userClassId = $user->classroom_id;
            $attendanceClassId = $attendance->classroom_id;
            if ($userClassId && $userClassId === $attendanceClassId) return true;

            // Also allow if user is the homeroom teacher for the classroom
            $homeroomId = optional($attendance->classroom)->homeroom_teacher_id;
            if ($homeroomId && $homeroomId === $user->id) return true;

            return false;
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
