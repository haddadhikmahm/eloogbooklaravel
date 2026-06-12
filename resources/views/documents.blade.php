@extends('app')

@section('content')
<div class="w-full mx-auto pb-10">
    <!-- Header -->
    <div class="flex justify-between items-center mb-10 pt-2">
        <h1 class="text-[28px] font-bold text-gray-800">Supporting Documents</h1>
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <input type="hidden" name="category" value="{{ request('category', 'Supporting Documents') }}">
            <input type="file" name="document" id="documentInput" class="hidden" onchange="window.document.getElementById('uploadForm').submit()">
            <button type="button" onclick="window.document.getElementById('documentInput').click()" class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold py-2.5 px-6 rounded-xl shadow-[0_4px_15px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(79,70,229,0.6)] flex items-center gap-2 transition duration-200">
                <i class="fas fa-upload text-sm"></i> Upload
            </button>
        </form>
    </div>

    <!-- Active Filter -->
    <div class="mb-6 flex flex-col md:flex-row items-start justify-between gap-4">
        @if(request('category'))
        <div class="flex items-center gap-3 bg-indigo-50 border border-indigo-100 p-4 rounded-xl">
            <i class="fas fa-filter text-indigo-500"></i>
            <span class="text-sm font-semibold text-indigo-900">Menampilkan folder: <span class="font-bold">{{ request('category') }}</span></span>
            <a href="{{ route('dashboard.documents') }}" class="ml-2 text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-white px-3 py-1.5 rounded-lg shadow-sm transition">
                Lihat Semua
            </a>
        </div>
        @endif
    </div>

    <!-- Folders Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 md:gap-6 mb-12">
        @php
            $folderThemes = [
                ['bg' => 'from-indigo-50 to-blue-50', 'border' => 'border-indigo-200', 'iconBg' => 'bg-indigo-100', 'iconHover' => 'group-hover:bg-indigo-200', 'icon' => 'text-indigo-500', 'textHover' => 'group-hover:text-indigo-700'],
                ['bg' => 'from-emerald-50 to-teal-50', 'border' => 'border-emerald-200', 'iconBg' => 'bg-emerald-100', 'iconHover' => 'group-hover:bg-emerald-200', 'icon' => 'text-emerald-500', 'textHover' => 'group-hover:text-emerald-700'],
                ['bg' => 'from-amber-50 to-orange-50', 'border' => 'border-amber-200', 'iconBg' => 'bg-amber-100', 'iconHover' => 'group-hover:bg-amber-200', 'icon' => 'text-amber-500', 'textHover' => 'group-hover:text-amber-700'],
                ['bg' => 'from-purple-50 to-fuchsia-50', 'border' => 'border-purple-200', 'iconBg' => 'bg-purple-100', 'iconHover' => 'group-hover:bg-purple-200', 'icon' => 'text-purple-500', 'textHover' => 'group-hover:text-purple-700'],
            ];
        @endphp

        @forelse($categories as $index => $cat)
            @php $theme = $folderThemes[$index % 4]; @endphp
            <a href="{{ route('dashboard.documents', ['category' => $cat->category]) }}" class="bg-gradient-to-br {{ $theme['bg'] }} border-2 {{ $theme['border'] }} rounded-[24px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-36 relative group cursor-pointer hover-glow">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl {{ $theme['iconBg'] }} flex items-center justify-center {{ $theme['iconHover'] }} group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-inner">
                        <i class="fas fa-folder text-xl {{ $theme['icon'] }}"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 bg-white/50 px-2 py-1 rounded-lg">{{ $cat->count }} Files</span>
                </div>
                <h3 class="font-bold text-gray-700 text-[15px] mt-4 {{ $theme['textHover'] }} transition-colors truncate" title="{{ $cat->category }}">{{ $cat->category }}</h3>
            </a>
        @empty
            <div class="col-span-full text-center py-8 text-gray-400">
                <i class="fas fa-folder-open text-4xl mb-3 opacity-20"></i>
                <p>Belum ada folder/kategori dokumen.</p>
            </div>
        @endforelse
    </div>

    <!-- File Terbaru List -->
    <div>
        @php
            $formatColors = [
                'PDF' => 'from-red-500 to-rose-600',
                'DOC' => 'from-blue-500 to-indigo-600',
                'DOCX' => 'from-blue-500 to-indigo-600',
                'XLS' => 'from-emerald-500 to-teal-600',
                'XLSX' => 'from-emerald-500 to-teal-600',
                'PPT' => 'from-amber-500 to-orange-600',
                'PPTX' => 'from-amber-500 to-orange-600',
                'JPG' => 'from-purple-500 to-fuchsia-600',
                'JPEG' => 'from-purple-500 to-fuchsia-600',
                'PNG' => 'from-purple-500 to-fuchsia-600',
                'ZIP' => 'from-gray-500 to-slate-600',
                'RAR' => 'from-gray-500 to-slate-600',
            ];
        @endphp
        
        <div class="bg-white border-2 border-gray-200 rounded-[20px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] overflow-hidden hover-glow mb-8">
            <!-- Table Header Bar -->
            <div class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 px-6 py-4 border-b-2 border-gray-200">
                <h3 class="font-bold text-indigo-900 text-[14px]">Daftar File</h3>
            </div>
            
            <div class="p-6 pb-2">
                <!-- Top Actions Bar -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-indigo-900 text-[15px] font-bold tracking-wide">File Terbaru</h2>
                    
                    <form method="GET" action="{{ route('dashboard.documents') }}" class="relative group">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search files..." class="border border-gray-200 rounded-full px-4 pl-10 py-2.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-transparent transition-all shadow-sm" oninput="clearTimeout(this.timer); this.timer = setTimeout(() => { this.form.submit(); }, 600);" {{ request('search') ? 'autofocus onfocus=this.setSelectionRange(this.value.length,this.value.length)' : '' }}>
                    </form>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 border-b-2 border-gray-200">
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900 w-16 text-center">Format</th>
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900">Judul Dokumen</th>
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900">Kategori</th>
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900 text-center">Ukuran</th>
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-gray-100">
                            @foreach($documents as $doc)
                            @php
                                $bgClass = $formatColors[strtoupper($doc->file_type)] ?? 'from-indigo-500 to-blue-600';
                            @endphp
                            <tr class="hover:bg-indigo-50/50 transition-all duration-300">
                                <td class="py-4 px-6 text-center">
                                    <div class="bg-gradient-to-br {{ $bgClass }} text-white w-10 h-10 rounded-xl flex items-center justify-center text-[10px] font-bold shadow-md mx-auto">{{ $doc->file_type }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <h4 class="text-sm font-bold text-gray-800">{{ $doc->title }}</h4>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-600 font-medium">
                                    {{ $doc->category }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600 font-medium">
                                    {{ $doc->file_size }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('documents.download', $doc->id) }}" class="text-gray-400 hover:text-indigo-600 transition-colors bg-white hover:bg-indigo-50 border border-gray-100 w-8 h-8 rounded-full flex items-center justify-center shadow-sm">
                                            <i class="fas fa-download text-[13px]"></i>
                                        </a>
                                        <form method="POST" action="{{ route('documents.destroy', $doc->id) }}" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-rose-500 transition-colors bg-white hover:bg-rose-50 border border-gray-100 w-8 h-8 rounded-full flex items-center justify-center shadow-sm" title="Delete">
                                                <i class="far fa-trash-alt text-[13px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        
            <!-- Pagination -->
            <div class="px-6 py-4 mt-2 custom-pagination">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
