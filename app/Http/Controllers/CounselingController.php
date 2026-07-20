<?php

namespace App\Http\Controllers;

use App\Models\CounselingSession;
use App\Models\CounselingNote;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CounselingController extends Controller
{
    public function index(Request $request)
    {
        $sessions = CounselingSession::with('notes','student')->paginate(20);
        return Inertia::render('Counseling/Index', ['sessions' => $sessions]);
    }

    public function create()
    {
        $students = Student::all();
        return Inertia::render('Counseling/Create', ['students' => $students]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'scheduled_at' => 'required|date',
            'session_type' => 'required|in:individual,group',
            'privacy_level' => 'required|in:private,restricted,public',
        ]);

        $data['counselor_id'] = auth()->id();

        $session = CounselingSession::create($data);

        if ($request->filled('note_text')) {
            CounselingNote::create([
                'session_id' => $session->id,
                'note_text' => $request->input('note_text'),
                'created_by' => auth()->id(),
                'confidential' => $request->boolean('confidential', true),
            ]);
        }

        return redirect()->route('counseling.index')->with('success', 'Sesi konseling dibuat.');
    }

    public function show(CounselingSession $counseling)
    {
        $counseling->load('notes','student');
        return Inertia::render('Counseling/Show', ['session' => $counseling]);
    }
}
