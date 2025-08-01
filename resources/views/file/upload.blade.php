@extends('dashboard')

@section('content')
    <div class="max-w-3xl mx-auto p-6">

        {{-- Back Button --}}
        <a href="{{ route('notes.index') }}"          class="text-white px-6 py-4 flex justify-between items-center shadow-md"
            style="background-color: #514caf !important;">
            ← Back to Notes
        </a>

        <h2 class="text-2xl font-bold mb-4">Upload CSV File</h2>

        {{-- Show errors --}}
        @if ($errors->any())
            <div class="text-red-600 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Upload Form --}}
        <form method="POST" action="{{ route('file.upload.submit') }}" enctype="multipart/form-data" class="mb-6">
            @csrf
            <input type="file" name="csv_file" accept=".csv" class="border border-gray-300 rounded px-4 py-2 mb-4">
            <br>
            <button type="submit" class="bg-[#514cafff] text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                Upload CSV
            </button>
        </form>

        {{-- Display CSV data --}}
        @if(isset($data))
            <div class="bg-white p-4 rounded shadow overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    @foreach($data as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td class="border border-gray-300 px-3 py-2">{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>
@endsection
