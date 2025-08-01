@extends('dashboard')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">Add New Note</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <textarea name="content" rows="5" class="w-full p-2 border border-gray-300 rounded" placeholder="Write your note..." required></textarea>
        <input type="file" name="image">

        <div class="mt-4 flex justify-between">
            <a href="{{ route('notes.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">← Cancel</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save Note</button>
        </div>
    </form>
</div>
@endsection
