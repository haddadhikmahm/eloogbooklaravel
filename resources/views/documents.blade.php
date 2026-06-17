@extends('app')

@section('content')
<div class="w-full mx-auto pb-10">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-start mb-6 pt-2 gap-6">
        <h1 class="text-[28px] font-bold text-gray-800">Supporting Documents</h1>
        
        <!-- Project Identity Card -->
        <div class="flex items-start gap-4 w-full lg:w-auto bg-white/50 lg:bg-transparent p-4 lg:p-0 rounded-2xl lg:rounded-none shadow-sm lg:shadow-none border border-gray-100 lg:border-none">
            <!-- Icon Box -->
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                <i class="fas fa-map-marked-alt text-xl sm:text-2xl text-[#8E9EAC]"></i>
            </div>
            
            <!-- Info Section -->
            <div class="flex flex-col">
                <div class="mb-1.5 flex items-center gap-2">
                    <span class="bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm tracking-wide">ACTIVE</span>
                </div>
                <h2 class="text-[16px] sm:text-[18px] font-extrabold text-[#112338] leading-tight mb-1">
                    {{ $project->code ? $project->code . ' - ' : '' }}{{ $project->name }}
                </h2>
                <p class="text-[#72839A] text-[12px] sm:text-[13px] font-medium mb-2">
                    {{ $project->type ?? 'Detailed Engineering Design' }}
                </p>
                
                <div class="flex items-center gap-4 text-[#72839A] text-[11px] font-bold">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-layer-group text-[#AAB8C7]"></i>
                        <span>{{ $project->disciplines_count ?? 0 }} Disciplines</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user-friends text-[#AAB8C7]"></i>
                        <span>{{ $project->personnel_count ?? 0 }} Personnel</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Row -->
    <div class="flex justify-end mt-10 mb-10">
        <button type="button" onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-2.5 px-8 rounded-xl shadow-sm flex items-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-md">
            <i class="fas fa-file-upload text-lg"></i> Upload Document
        </button>
    </div>

    <!-- Active Filter -->
    <div class="mb-6 flex flex-col md:flex-row items-start justify-between gap-4">
        @if(request('category'))
        <div class="flex items-center gap-3 bg-indigo-50 border border-indigo-100 p-4 rounded-xl">
            <i class="fas fa-filter text-indigo-500"></i>
            <span class="text-sm font-semibold text-indigo-900">Showing folder: <span class="font-bold">{{ request('category') }}</span></span>
            <a href="{{ route('dashboard.documents') }}" class="ml-2 text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-white px-3 py-1.5 rounded-lg shadow-sm transition">
                View All
            </a>
        </div>
        @endif
    </div>

    <!-- Folders Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5 md:gap-6 mb-12">
        @forelse($categories as $index => $cat)
            <a href="{{ route('dashboard.documents', ['category' => $cat->category]) }}" class="bg-gradient-to-br from-slate-800 via-indigo-950 to-slate-900 border border-indigo-800/50 rounded-[24px] p-6 shadow-lg hover:shadow-indigo-900/30 hover:shadow-xl transform hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between h-36 cursor-pointer group relative overflow-hidden">
                <!-- Decorative glow effect -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl group-hover:bg-indigo-400/30 transition-all duration-500"></div>
                <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-blue-500/10 rounded-full blur-xl group-hover:bg-blue-400/20 transition-all duration-500"></div>
                
                <div class="relative z-10 flex justify-between items-start">
                    <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-white/10 group-hover:scale-110 transition-all duration-300 backdrop-blur-sm">
                        <i class="fas fa-folder text-[22px] text-indigo-300 group-hover:text-white transition-colors"></i>
                    </div>
                    @if($cat->count > 0)
                    <span class="text-[10px] font-bold text-white bg-indigo-500/80 border border-indigo-400/50 px-2.5 py-1 rounded-lg shadow-sm backdrop-blur-md">{{ $cat->count }}</span>
                    @endif
                </div>
                <h3 class="relative z-10 font-extrabold text-white text-[16px] mt-4 truncate tracking-wide group-hover:text-indigo-100 transition-colors" title="{{ $cat->category }}">{{ $cat->category }}</h3>
            </a>
        @empty
            <div class="col-span-full text-center py-8 text-gray-400">
                <i class="fas fa-folder-open text-4xl mb-3 opacity-20"></i>
                <p>No document folders/categories yet.</p>
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
                <h3 class="font-bold text-indigo-900 text-[14px]">File List</h3>
            </div>
            
            <div class="p-6 pb-2">
                <!-- Top Actions Bar -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-indigo-900 text-[15px] font-bold tracking-wide">Recent Files</h2>
                    
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
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900">Document Title</th>
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900">Category</th>
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900 text-center">Size</th>
                                <th class="py-5 px-6 text-xs font-bold text-indigo-900 text-center w-24">Action</th>
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

<!-- Upload Document Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-[1000px] max-h-[95vh] flex flex-col overflow-hidden transform scale-100">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-indigo-900 font-extrabold flex items-center gap-3 text-[18px]">
                <div class="bg-indigo-100 w-10 h-10 rounded-full flex items-center justify-center"><i class="fas fa-file-upload text-indigo-600"></i></div>
                <span>Upload Document</span>
            </h2>
            <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 w-10 h-10 flex items-center justify-center rounded-full hover:bg-red-50 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 custom-scrollbar">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-8 md:gap-12 w-full">
                @csrf
                
                <!-- Left: Drag and Drop -->
                <div class="flex-1 w-full">
                    <div class="border-2 border-dashed border-indigo-200 bg-indigo-50/30 rounded-2xl h-[300px] md:h-[450px] flex flex-col items-center justify-center relative cursor-pointer hover:bg-indigo-50 transition-colors group" onclick="document.getElementById('fileInputReal').click()">
                        <input type="file" name="document" class="absolute w-px h-px opacity-0 overflow-hidden top-1/2 left-1/2" required id="fileInputReal" onchange="if(this.files.length > 0) { document.getElementById('filenameDisplay').innerText = this.files[0].name; document.getElementById('filenameDisplay').classList.remove('hidden'); }">
                        
                        <div class="w-16 h-20 bg-indigo-600 rounded-xl mb-6 flex items-center justify-center relative shadow-md group-hover:scale-110 transition-transform">
                            <i class="fas fa-arrow-up text-white text-2xl"></i>
                            <!-- Document fold corner -->
                            <div class="absolute top-0 right-0 w-6 h-6 bg-indigo-50/30 rounded-bl-xl group-hover:bg-indigo-50 transition-colors"></div>
                        </div>
                        <h3 class="font-bold text-[#111] mb-2 text-[16px] md:text-[18px] text-center px-4">Click to Browse Files</h3>
                        <div class="flex items-center gap-3 w-48 mb-4">
                            <div class="flex-1 h-[1px] bg-indigo-200"></div>
                            <span class="text-xs text-[#999] font-medium">OR</span>
                            <div class="flex-1 h-[1px] bg-indigo-200"></div>
                        </div>
                        <button type="button" class="bg-white text-indigo-600 border-2 border-indigo-600 font-bold py-2 px-8 rounded-xl text-[14px] shadow-sm pointer-events-none group-hover:bg-indigo-600 group-hover:text-white transition-colors">Browse files</button>
                        <div id="filenameDisplay" class="mt-6 text-[14px] font-bold text-indigo-600 hidden bg-white px-4 py-2 rounded-lg shadow-sm border border-indigo-200 truncate max-w-[80%]"></div>
                    </div>
                </div>

                <!-- Right: Metadata -->
                <div class="flex-1 flex flex-col w-full">
                    <div class="space-y-5 flex-1">
                        <div>
                            <label class="block text-[13px] font-extrabold text-gray-700 mb-2">Document Title</label>
                            <input type="text" name="title" placeholder="File Title" class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all bg-gray-50 focus:bg-white" required>
                        </div>

                        <div>
                            <label class="block text-[13px] font-extrabold text-gray-700 mb-2">Location (Folder)</label>
                            <select name="category" id="categorySelect" class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all bg-gray-50 focus:bg-white appearance-none cursor-pointer" required>
                                @php $hasDefault = false; @endphp
                                @foreach($categories as $cat)
                                    @php if($cat->category == request('category', 'Supporting Documents')) $hasDefault = true; @endphp
                                    <option value="{{ $cat->category }}" {{ request('category', 'Supporting Documents') == $cat->category ? 'selected' : '' }}>{{ $cat->category }}</option>
                                @endforeach
                                @if(!$hasDefault && request('category'))
                                    <option value="{{ request('category') }}" selected>{{ request('category') }}</option>
                                @elseif(!$hasDefault)
                                    <option value="Supporting Documents" selected>Supporting Documents</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label class="block text-[13px] font-extrabold text-gray-700 mb-2">Description</label>
                            <textarea name="description" placeholder="Describe your document's content and purpose." rows="3" class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all bg-gray-50 focus:bg-white"></textarea>
                        </div>

                        <div>
                            <label class="block text-[13px] font-extrabold text-gray-700 mb-2">Keywords/Tags</label>
                            <input type="text" name="tags" placeholder="e.g. report, annual, financial" class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 transition-all bg-gray-50 focus:bg-white">
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 pt-6 border-t border-gray-100">
                        <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors mr-3">Cancel</button>
                        <button type="submit" id="uploadBtnState" class="bg-indigo-600 text-white font-extrabold py-2.5 px-8 rounded-xl text-[14px] transition-all hover:bg-indigo-700 hover:shadow-lg transform hover:-translate-y-0.5">Upload File</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
