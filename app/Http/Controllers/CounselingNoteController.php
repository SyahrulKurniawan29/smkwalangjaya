<?php

namespace App\Http\Controllers;

use App\Models\CounselingNote;
use App\Models\CounselingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CounselingNoteController extends Controller
{
    public function store(Request $request, CounselingSession $session)
    {
        $this->authorize('create', CounselingNote::class);

        $data = $request->validate([
            'note_text' => 'required|string',
            'confidential' => 'boolean',
            'attachment' => 'nullable|file|max:5120' // 5MB
        ]);

        $note = CounselingNote::create([
            'session_id' => $session->id,
            'note_text' => $data['note_text'],
            'created_by' => auth()->id(),
            'confidential' => $data['confidential'] ?? true,
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            // Save attachment reference in a simple attachments table if exists
            if (method_exists($note, 'attachments')) {
                $note->attachments()->create(['file_path' => $path, 'uploaded_by' => auth()->id()]);
            }
        }

        return redirect()->route('counseling.show', $session->id)->with('success', 'Catatan tersimpan.');
    }
}
