<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Student;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $guru = Role::firstOrCreate(['name' => 'guru_bk']);
        $wali = Role::firstOrCreate(['name' => 'wali_kelas']);

        // Users
        User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role_id' => $admin->id,
        ]);

        User::firstOrCreate(['email' => 'guru-bk@example.com'], [
            'name' => 'Guru BK',
            'password' => Hash::make('password'),
            'role_id' => $guru->id,
        ]);

        User::firstOrCreate(['email' => 'walikelas@example.com'], [
            'name' => 'Wali Kelas',
            'password' => Hash::make('password'),
            'role_id' => $wali->id,
        ]);

        // Classroom
        $class = ClassRoom::firstOrCreate(['name' => 'X IPA 1', 'grade' => '10']);

        // Students
        for ($i = 1; $i <= 5; $i++) {
            Student::firstOrCreate(['nis' => 'NIS'.str_pad($i,3,'0',STR_PAD_LEFT)], [
                'name' => 'Siswa '.$i,
                'classroom_id' => $class->id,
                'dob' => now()->subYears(15)->toDateString(),
                'parent_contact' => '0812'.rand(1000000,9999999),
            ]);
        }
    }
}
