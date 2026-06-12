@extends('app')

@section('content')
<div class="w-full mx-auto pb-10">
    <!-- Header -->
    <div class="flex justify-between items-center mb-10 pt-2">
        <h1 class="text-[28px] font-bold text-gray-800">Supporting Documents</h1>
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <input type="file" name="document" id="documentInput" class="hidden" onchange="document.getElementById('uploadForm').submit()">
            <button type="button" onclick="document.getElementById('documentInput').click()" class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold py-2.5 px-6 rounded-xl shadow-[0_4px_15px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(79,70,229,0.6)] flex items-center gap-2 transition duration-200">
                <i class="fas fa-upload text-sm"></i> Upload
            </button>
        </form>
    </div>

    <!-- Folders Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 md:gap-6 mb-12">
        <!-- Folder 1 -->
        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 border-2 border-indigo-200 rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-36 relative group cursor-pointer hover-glow">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-inner">
                    <i class="fas fa-folder text-xl text-indigo-500"></i>
                </div>
            </div>
            <h3 class="font-bold text-gray-700 text-[15px] mt-4 group-hover:text-indigo-700 transition-colors">Kontrak & Legal</h3>
        </div>

        <!-- Folder 2 -->
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-36 relative group cursor-pointer hover-glow">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-inner">
                    <i class="fas fa-folder text-xl text-emerald-500"></i>
                </div>
            </div>
            <h3 class="font-bold text-gray-700 text-[15px] mt-4 group-hover:text-emerald-700 transition-colors">SOP</h3>
        </div>

        <!-- Folder 3 -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 border-2 border-amber-200 rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-36 relative group cursor-pointer hover-glow">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-inner">
                    <i class="fas fa-folder text-xl text-amber-500"></i>
                </div>
            </div>
            <h3 class="font-bold text-gray-700 text-[15px] mt-4 group-hover:text-amber-700 transition-colors">Notulensi</h3>
        </div>
    </div>

    <!-- File Terbaru List -->
    <div>
        <h2 class="text-indigo-900 text-[15px] font-bold mb-4 tracking-wide">File Terbaru</h2>
        
        <div class="bg-white border-2 border-gray-200 rounded-[24px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden mb-8 p-1 hover-glow">
            <div class="bg-white rounded-[20px] overflow-hidden divide-y divide-gray-100">
            @foreach($documents as $doc)
            <div class="flex items-center justify-between p-5 hover:bg-indigo-50/30 hover:scale-[1.002] transition-all duration-300 cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-br from-indigo-500 to-blue-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-[10px] font-bold shadow-md">{{ $doc->file_type }}</div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-0.5 group-hover:text-indigo-600 transition-colors">{{ $doc->title }}</h4>
                        <p class="text-xs text-gray-500 font-medium">{{ $doc->file_type }} . {{ $doc->file_size }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <button class="text-gray-400 hover:text-indigo-600 transition-colors mr-4 bg-white hover:bg-indigo-50 w-8 h-8 rounded-full flex items-center justify-center">
                        <i class="fas fa-download text-[15px]"></i>
                    </button>
                    <form method="POST" action="{{ route('documents.destroy', $doc->id) }}" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-rose-500 transition-colors bg-white hover:bg-rose-50 w-8 h-8 rounded-full flex items-center justify-center" title="Delete">
                            <i class="far fa-trash-alt text-[15px]"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
