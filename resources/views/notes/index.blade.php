@extends('dashboard')

@section('content')
<div class="text-white px-6 py-4 flex justify-between items-center shadow-md"
     style="background-color: #514caf !important;">
    <h2 class="text-xl font-bold">Your Notes</h2>
    <div class="flex items-center gap-4">
        <a href="{{ route('notes.create') }}" 
         class="text-white px-6 py-4 flex justify-between items-center shadow-md"
            style="background-color: #514caf !important;">
            + Add Note
        </a>
        <a href="{{ route('file.upload') }}"
                 class="text-white px-6 py-4 flex justify-between items-center shadow-md"
            style="background-color: #514caf !important;">File
        </a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="text-white font-medium hover:underline">
            Logout
        </a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

    <div class="max-w-3xl mx-auto mt-4 px-4">
        <input
            type="text"
            id="note-search"
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
            placeholder="Search notes..."
        >
    </div>
    
    <div class="mt-10 flex justify-center">
        <div class="w-full max-w-3xl space-y-6 px-4" id="notes-list">
            @forelse($notes as $note)
                <div class="bg-white border border-[#514cafff] p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <p class="text-gray-900 mb-3 whitespace-pre-wrap">{{ $note->content }}</p>
                    <small class="text-gray-500 block mb-4">Created: {{ $note->created_at->format('d M Y, h:i A') }}</small>

                @if ($note->pic_id && $note->picture && $note->picture->path)
                    <img src="{{ asset($note->picture->path) }}" alt="Note Image" class="max-w-full mb-3 rounded shadow">
                @endif


                    <div class="flex gap-6">
                        <a href="{{ route('notes.edit', $note) }}"
                        class="text-[#514cafff] font-medium hover:underline">Edit</a>

                        <form action="{{ route('notes.destroy', $note) }}" method="POST"
                            onsubmit="return confirm('Delete this note?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-[#514cafff] text-white px-4 py-1 rounded hover:bg-indigo-700 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No notes found.</p>
            @endforelse
            <div class="mt-6 flex justify-center">
                {{ $notes->withQueryString()->links() }}
            </div>

        </div>
    </div>
        <meta name="csrf-token" content="{{ csrf_token() }}"> 

<script>
    const searchInput = document.getElementById('note-search');
    const notesList = document.getElementById('notes-list');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let totalAlphabets = 0;
    let t=true;
    const originalNotesHTML = notesList.innerHTML;
    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length <= 2) {
            if (query.length > totalAlphabets) {
                totalAlphabets++;
                t=false
            } else if(t!=true) {
                notesList.innerHTML = originalNotesHTML;
                totalAlphabets--;
                t=true;
            }
            return;
        }

        fetch(`/notes/search-notes?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                notesList.innerHTML = '';

                if (data.notes.length === 0) {
                    notesList.innerHTML = '<p class="text-gray-500">No notes found.</p>';
                    return;
                }

                data.notes.forEach(note => {
                    
                    notesList.innerHTML += `
                        <div class="bg-white border border-[#514cafff] p-6 rounded-lg shadow-sm hover:shadow-md transition">
                            <p class="text-gray-900 mb-3 whitespace-pre-wrap">${note.content}</p>
                            <img src="${ note.image }" alt="Note Image" class="max-w-full mb-3 rounded shadow">
                            <small class="text-gray-500 block mb-4">Created: ${new Date(note.created_at).toLocaleString()}</small>

                            <div class="flex gap-6">
                                <a href="/notes/${note.id}/edit"
                                   class="text-[#514cafff] font-medium hover:underline">Edit</a>

                                <form method="POST" action="/notes/${note.id}" onsubmit="return confirm('Delete this note?');">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="bg-[#514cafff] text-white px-4 py-1 rounded hover:bg-indigo-700 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    `;
                });
            });
    });
</script>

    <style>
        input[name="search"]::placeholder {
            color: #999;
        }

        #notes-list > div {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

        {{-- Toast Notification --}}
    @if(session('success'))
        <div id="toast-popup" class="fixed bottom-5 left-5 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-slide-in-left">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-popup');
                if (toast) {
                    toast.classList.add('opacity-0', 'transition-opacity');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>

        <style>
            @keyframes slide-in-left {
                0% { transform: translateX(-100%); opacity: 0; }
                100% { transform: translateX(0); opacity: 1; }
            }

            .animate-slide-in-left {
                animation: slide-in-left 0.5s ease-out;
            }
        </style>
    @endif


@endsection
