<?php

namespace App\Policies;

use App\Models\CounselingNote;
use App\Models\User;

class CounselingNotePolicy
{
    /**
     * Determine whether the user can view the counseling note.
     */
    public function view(User $user, CounselingNote $note)
    {
        // Non-confidential notes are viewable by any authenticated user
        if (!$note->confidential) {
            return true;
        }

        $role = optional($user->role)->name;

        // Admins and Guru BK can view confidential notes
        if ($role === 'admin' || $role === 'guru_bk') {
            return true;
        }

        // The creator of the note or the counselor of the session can view
        if ($user->id === $note->created_by) {
            return true;
        }

        if ($user->id === $note->session->counselor_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create a note for the session.
     */
    public function create(User $user)
    {
        $role = optional($user->role)->name;
        return in_array($role, ['admin', 'guru_bk']);
    }
}
