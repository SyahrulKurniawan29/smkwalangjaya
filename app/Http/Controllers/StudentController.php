<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $class_id = $request->query('class_id');
        $query = Student::with('classroom');
        if ($class_id) $query->where('classroom_id', $class_id);
        $students = $query->paginate(15);
        $classes = ClassRoom::all();
        return Inertia::render('Students/Index', ['students' => $students, 'classes' => $classes]);
    }

    public function create()
    {
        $classes = ClassRoom::all();
        return Inertia::render('Students/Create', ['classes' => $classes]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis' => 'required|string|unique:students,nis',
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'dob' => 'nullable|date',
            'parent_contact' => 'nullable|string|max:100',
        ]);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::all();
        return Inertia::render('Students/Create', ['student' => $student, 'classes' => $classes]);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'dob' => 'nullable|date',
            'parent_contact' => 'nullable|string|max:100',
        ]);

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Siswa berhasil diupdate.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Siswa dihapus.');
    }
}
