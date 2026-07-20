<?php

use PHPUnit\Framework\TestCase;
use App\Policies\AttendancePolicy;
use App\Models\User;
use App\Models\Attendance;

class AttendancePolicyTest extends TestCase
{
    public function test_wali_kelas_can_view_same_class_attendance()
    {
        $policy = new AttendancePolicy();

        $user = new User();
        $user->id = 10;
        $user->role_id = 3; // assume wali_kelas
        // set role name via relation mock
        $role = new \stdClass();
        $role->name = 'wali_kelas';
        $user->setRelation('role', $role);

        $user->classroom_id = 5;

        $attendance = new Attendance();
        $attendance->classroom_id = 5;

        $this->assertTrue($policy->view($user, $attendance));
    }

    public function test_wali_kelas_cannot_view_other_class_attendance()
    {
        $policy = new AttendancePolicy();

        $user = new User();
        $user->id = 11;
        $role = new \stdClass();
        $role->name = 'wali_kelas';
        $user->setRelation('role', $role);
        $user->classroom_id = 6;

        $attendance = new Attendance();
        $attendance->classroom_id = 7;

        $this->assertFalse($policy->view($user, $attendance));
    }
}
