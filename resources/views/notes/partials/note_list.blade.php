@foreach ($notes as $note)
    <div class="bg-white border border-[#514cafff] p-6 rounded-lg shadow-sm hover:shadow-md transition">
        <p class="text-gray-900 mb-3 whitespace-pre-wrap">{{ $note->content }}</p>
        <small class="text-gray-500 block mb-4">Created: {{ $note->created_at->format('d M Y, h:i A') }}</small>

        <div class="flex gap-6">
            <a href="{{ route('notes.edit', $note->id) }}" class="text-[#514cafff] font-medium hover:underline">Edit</a>

            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Delete this note?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-[#514cafff] text-white px-4 py-1 rounded hover:bg-indigo-700 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
@endforeach

{{-- Pagination Links --}}
<div class="mt-6 flex justify-center">
    {!! $notes->links() !!}
</div>
