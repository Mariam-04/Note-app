<?php

namespace App\Http\Controllers;
use App\Models\Picture;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NoteRequest;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{

    // public function index(Request $request)
    // {
    //     $search = $request->input('search');

    //     $notes = Note::getUserNotes(Auth::id(), $search, 5);

    //     if ($request->ajax()) {
    //         $html = view('notes.partials.note-list', compact('notes'))->render();
    //         return response()->json(['html' => $html]);
    //     }

    //     return view('notes.index', compact('notes', 'search'));
    // }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $notes = Note::getUserNotes(Auth::id(), $search, 5);

        if ($request->ajax()) {
            $html = view('notes.partials.note-list', compact('notes'))->render();
            return response()->json(['html' => $html]);
        }

        return view('notes.index', compact('notes', 'search'));
    }


    public function create()
    {
        return view('notes.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'content' => 'required|string|max:1000',
    //     ]);

    //     $sanitizedContent = htmlspecialchars($request->input('content'));
    //     Note::create([
    //         'user_id' => Auth::id(),
    //         'content' => $sanitizedContent,
    //     ]);


    //     // Note::createNote(Auth::id(), $request->content);

    //     return redirect()->route('notes.index')->with('success', 'Note added!');
    // }

// public function store(Request $request)
// {
//     $request->validate([
//         'content' => 'required|string|max:1000',
//         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     $picId = null;

//     if ($request->hasFile('image')) {
//         $image = $request->file('image');
//         $filename = time() . '_' . $image->getClientOriginalName();
//         $path = $image->storeAs('uploads', $filename, 'public');

//         $picture = Picture::create([
//             'filename' => $filename,
//             'path' => 'storage/' . $path,
//         ]);
//         $picId = $picture->id;
//     }

//     Note::create([
//         'user_id' => Auth::id(),
//         'content' => htmlspecialchars($request->input('content')),
//         'pic_id' => $picId,
//     ]);

//     return redirect()->route('notes.index')->with('success', 'Note added!');
// }



public function store(NoteRequest $request)
{
    $picId = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '_' . $image->getClientOriginalName();
        $path = $image->storeAs('uploads', $filename, 'public');

        $picture = Picture::create([
            'filename' => $filename,
            'path' => 'storage/' . $path,
        ]);

        $picId = $picture->id;
    }

    Note::create([
        'user_id' => Auth::id(),
        'content' => htmlspecialchars($request->input('content')),
        'pic_id' => $picId,
    ]);

    return redirect()->route('notes.index')->with('success', 'Note added!');
}


    public function edit(Note $note)
    {
        $this->authorize('update', $note);
        return view('notes.edit', compact('note'));
    }


public function update(NoteRequest $request, Note $note)
{
    $this->authorize('update', $note);

    $content = htmlspecialchars($request->input('content'));
    $picId = $note->pic_id;

    if ($request->has('delete_image') && $note->picture) {
        Storage::disk('public')->delete(str_replace('storage/', '', $note->picture->path));

        $note->picture->delete();

        $picId = null;
    }

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '_' . $image->getClientOriginalName();
        $path = $image->storeAs('uploads', $filename, 'public');

        $picture = Picture::create([
            'path' => 'storage/' . $path,
        ]);

        $picId = $picture->id;
    }

    $note->updateNote($content, $picId);

    return redirect()->route('notes.index')->with('success', 'Note updated!');
}




// public function update(NoteRequest $request, Note $note)
// {
//     $this->authorize('update', $note);

//     $content = htmlspecialchars($request->input('content'));
//     $picId = $note->pic_id;

//     if ($request->hasFile('image')) {
//         $image = $request->file('image');
//         $filename = time() . '_' . $image->getClientOriginalName();
//         $path = $image->storeAs('uploads', $filename, 'public');

//         $picture = Picture::create([
//             'path' => 'storage/' . $path,
//         ]);

//         $picId = $picture->id;
//     }

//     $note->updateNote($content, $picId);

//     return redirect()->route('notes.index')->with('success', 'Note updated!');
// }


//     public function update(NoteRequest $request, Note $note)
// {
//     $this->authorize('update', $note);

//     $note->updateNote($request->input('content'));

//     $note->content = htmlspecialchars($request->input('content'));

//     if ($request->hasFile('image')) {
//         $image = $request->file('image');
//         $filename = time() . '_' . $image->getClientOriginalName();
//         $path = $image->storeAs('uploads', $filename, 'public');

//         $picture = Picture::create([
//             'path' => 'storage/' . $path,
//         ]);

//         $note->pic_id = $picture->id;
//     }

//     $note->save();

//     return redirect()->route('notes.index')->with('success', 'Note updated!');
// }


    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->deleteNote();

        return redirect()->back()->with('success', 'Note deleted.');
    }

    public function searchNotes(Request $request)
    {
        $query = $request->input('query');
        $notes = Note::searchNotes($query);
        $data = [];
        foreach($notes as $note) {
            $data[] = [
                'content' => $note->content,
                'id' => $note->id,
                'image' => asset($note->picture->path),
                'created_at' => $note->created_at,
            ];
        }

        return response()->json(['notes' => $data]);
    }

    public function picture()
{
    return $this->belongsTo(Picture::class, 'pic_id');
}

}
