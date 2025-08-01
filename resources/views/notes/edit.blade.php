@extends('dashboard')

@section('content')
<div class="container mx-auto max-w-md mt-10">
    <h2 class="text-2xl font-bold mb-4">Edit Note</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Note Content --}}
        <textarea name="content" rows="6" class="w-full p-2 border border-gray-300 rounded" required>{{ old('content', $note->content) }}</textarea>

        {{-- Existing Image Preview --}}
        @if ($note->picture && $note->picture->path)
            <div class="mt-4">
                <p class="font-semibold mb-2">Current Image:</p>
                <img src="{{ asset($note->picture->path) }}" alt="Note Image" class="w-40 h-auto rounded shadow">
            </div>
        @endif

        {{-- Upload New Image --}}
        <div class="mt-4">
            <label class="block text-sm font-medium mb-1">Upload New Image:</label>
            <input type="file" name="image" class="w-full p-2 border border-gray-300 rounded">
        </div>

    {{--  Delete Image --}}

        @if ($note->picture)
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="delete_image" class="form-checkbox">
                    <span class="ml-2 text-sm">Delete current image</span>
                </label>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="mt-6 flex justify-between">
            <a href="{{ route('notes.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">← Back</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
        </div>
    </form>
</div>
@endsection
