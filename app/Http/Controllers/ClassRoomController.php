<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::withCount('students')->paginate(15);
        return Inertia::render('Classes/Index', ['classes' => $classes]);
    }

    public function create()
    {
        return Inertia::render('Classes/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'nullable|string|max:50',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ]);

        ClassRoom::create($data);

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function edit(ClassRoom $classroom)
    {
        return Inertia::render('Classes/Create', ['classroom' => $classroom]);
    }

    public function update(Request $request, ClassRoom $classroom)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'nullable|string|max:50',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ]);

        $classroom->update($data);

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(ClassRoom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classes.index')->with('success', 'Kelas dihapus.');
    }
}
