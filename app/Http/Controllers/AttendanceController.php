<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index(Request $request, $classroomId = null)
    {
        $this->authorize('viewAny', Attendance::class);

        $from = $request->query('from', now()->toDateString());
        $to = $request->query('to', now()->toDateString());

        $classrooms = ClassRoom::with('students')->get();

        $query = Attendance::with('student')
            ->when($classroomId, fn($q) => $q->where('classroom_id', $classroomId))
            ->whereBetween('date', [$from, $to])
            ->orderBy('date','desc');

        // If user is wali_kelas, restrict to their classroom
        if (optional(auth()->user()->role)->name === 'wali_kelas') {
            $userClassId = auth()->user()->classroom_id;
            if ($userClassId) {
                $query->where('classroom_id', $userClassId);
            }
        }

        $attendances = $query->paginate(30);

        return Inertia::render('Attendance/Index', compact('attendances','classrooms'));
    }

    public function storeBulk(Request $request)
    {
        $this->authorize('create', Attendance::class);

        $data = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
            'records' => 'required|array',
            'records.*.student_id' => 'required|exists:students,id',
            'records.*.status' => 'required|in:present,sick,permission,absent',
            'records.*.note' => 'nullable|string',
        ]);

        // enforce wali_kelas can only write for their class
        if (optional(auth()->user()->role)->name === 'wali_kelas') {
            $userClassId = auth()->user()->classroom_id;
            if (!$userClassId || $userClassId != $data['classroom_id']) {
                abort(403, 'Anda tidak memiliki akses untuk mengisi absensi pada kelas ini.');
            }
        }

        foreach ($data['records'] as $rec) {
            Attendance::updateOrCreate(
                ['student_id' => $rec['student_id'], 'date' => $data['date']],
                ['classroom_id' => $data['classroom_id'], 'status' => $rec['status'], 'note' => $rec['note'] ?? null, 'recorded_by' => auth()->id()]
            );
        }

        return back()->with('success', 'Absensi tersimpan.');
    }
}
