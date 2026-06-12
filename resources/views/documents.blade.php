@extends('app')

@section('content')
<div class="w-full max-w-[1200px] mx-auto pb-10">
    <!-- Header -->
    <div class="flex justify-between items-center mb-10 pt-2">
        <h1 class="text-[28px] font-bold text-[#6D6257]">Supporting Documents</h1>
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <input type="file" name="document" id="documentInput" class="hidden" onchange="document.getElementById('uploadForm').submit()">
            <button type="button" onclick="document.getElementById('documentInput').click()" class="bg-[#A6998A] hover:bg-[#8C7D6D] text-white font-bold py-2.5 px-6 rounded-md shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-upload text-sm"></i> Upload
            </button>
        </form>
    </div>

    <!-- Folders Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
        <!-- Folder 1 -->
        <div class="bg-[#DFD8D0] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-32 relative group">
            <div class="flex justify-between items-start">
                <i class="fas fa-folder text-[32px] text-[#A6998A]"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-[15px] mt-4">Kontrak & Legal</h3>
        </div>

        <!-- Folder 2 -->
        <div class="bg-[#DFD8D0] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-32 relative group">
            <div class="flex justify-between items-start">
                <i class="fas fa-folder text-[32px] text-[#A6998A]"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-[15px] mt-4">SOP</h3>
        </div>

        <!-- Folder 3 -->
        <div class="bg-[#DFD8D0] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-32 relative group">
            <div class="flex justify-between items-start">
                <i class="fas fa-folder text-[32px] text-[#A6998A]"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-[15px] mt-4">Notulensi</h3>
        </div>
    </div>

    <!-- File Terbaru List -->
    <div>
        <h2 class="text-[#96897E] text-[15px] font-bold mb-4 tracking-wide">File Terbaru</h2>
        
        <div class="bg-white border border-[#E2DDD8] rounded-2xl overflow-hidden shadow-sm flex flex-col">
            
            @foreach($documents as $doc)
            <div class="flex items-center justify-between p-5 border-b border-[#E2DDD8] hover:bg-gray-50 transition cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="bg-black text-white w-9 h-10 rounded flex items-center justify-center text-[10px] font-bold">{{ $doc->file_type }}</div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-0.5">{{ $doc->title }}</h4>
                        <p class="text-xs text-gray-500 font-medium">{{ $doc->file_type }} . {{ $doc->file_size }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <button class="text-gray-600 hover:text-gray-900 transition mr-4">
                        <i class="fas fa-download text-lg"></i>
                    </button>
                    <form method="POST" action="{{ route('documents.destroy', $doc->id) }}" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Delete">
                            <i class="far fa-trash-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
