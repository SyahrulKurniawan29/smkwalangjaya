<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\CounselingNote;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Policies\CounselingNotePolicy;
use App\Policies\AttendancePolicy;
use App\Policies\ClassRoomPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        CounselingNote::class => CounselingNotePolicy::class,
        Attendance::class => AttendancePolicy::class,
        ClassRoom::class => ClassRoomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Additional gates can be registered here if necessary.
    }
}
