<?php

namespace App\Observers;

use App\Models\Note;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NoteObserver
{
    /**
     * Handle the Note "created" event.
     */
    public function created(Note $note): void
    {
        Log::info("Note created [ID: {$note->id}] by user [ID: {$note->user_id}]");
    }

    /**
     * Handle the Note "updated" event.
     */
    public function updated(Note $note): void
    {
        //
    }

    /**
     * Handle the Note "deleted" event.
     */
    public function deleted(Note $note): void
    {
        if ($note->picture && $note->picture->path) {
            $relativePath = str_replace('storage/', '', $note->picture->path);

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
                Log::info("Deleted image for note ID {$note->id} at path {$note->picture->path}");
            }
        }
        
    }
    /**
     * Handle the Note "restored" event.
     */
    public function restored(Note $note): void
    {
        //
    }

    /**
     * Handle the Note "force deleted" event.
     */
    public function forceDeleted(Note $note): void
    {
        //
    }
}
