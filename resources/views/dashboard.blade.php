@extends('app')

@section('content')
<div class="w-full pb-10">
    <!-- Header & Stats -->
    <div class="mb-10 pt-4 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6">
        <div>
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 tracking-tight mb-2">Logbook Revisi</h1>
            <p class="text-gray-500 font-medium">Kelola dan pantau semua status revisi klien dengan mudah.</p>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <!-- Stat Cards -->
            <div class="bg-gradient-to-br from-indigo-500 to-blue-600 border-2 border-indigo-300/50 rounded-3xl p-5 w-36 shadow-[0_8px_25px_rgba(79,70,229,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(79,70,229,0.4)] transition-all duration-300 group relative overflow-hidden hover-glow">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-inner relative z-10">
                    <i class="fas fa-layer-group text-white text-lg"></i>
                </div>
                <p class="text-[32px] font-bold text-white leading-none mb-1 relative z-10">{{ $allRevisionsCount }}</p>
                <p class="text-xs font-bold text-indigo-100 uppercase tracking-wider relative z-10">Total</p>
            </div>
            
            <div class="bg-gradient-to-br from-emerald-400 to-teal-500 border-2 border-emerald-300/50 rounded-3xl p-5 w-36 shadow-[0_8px_25px_rgba(16,185,129,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(16,185,129,0.4)] transition-all duration-300 group relative overflow-hidden hover-glow">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-inner relative z-10">
                    <i class="far fa-folder-open text-white text-lg"></i>
                </div>
                <p class="text-[32px] font-bold text-white leading-none mb-1 relative z-10">{{ $openRevisionsCount }}</p>
                <p class="text-xs font-bold text-emerald-100 uppercase tracking-wider relative z-10">Open</p>
            </div>
            
            <div class="bg-gradient-to-br from-rose-400 to-red-500 border-2 border-rose-300/50 rounded-3xl p-5 w-36 shadow-[0_8px_25px_rgba(244,63,94,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(244,63,94,0.4)] transition-all duration-300 group relative overflow-hidden hover-glow">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-inner relative z-10">
                    <i class="far fa-check-circle text-white text-lg"></i>
                </div>
                <p class="text-[32px] font-bold text-white leading-none mb-1 relative z-10">{{ $closeRevisionsCount }}</p>
                <p class="text-xs font-bold text-rose-100 uppercase tracking-wider relative z-10">Close</p>
            </div>
        </div>
    </div>

    <!-- Filters Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <!-- Toolbar Pill -->
        <div class="bg-white/80 backdrop-blur-lg border-2 border-gray-200 p-1.5 rounded-full inline-flex shadow-[0_4px_15px_rgba(0,0,0,0.05)] gap-1">
            <a href="{{ route('dashboard.logbook', ['status' => 'All']) }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ request('status', 'All') === 'All' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'text-gray-600 hover:bg-white hover:text-indigo-600' }}">All</a>
            <a href="{{ route('dashboard.logbook', ['status' => 'Open']) }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ request('status') === 'Open' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'text-gray-600 hover:bg-white hover:text-indigo-600' }}">Open</a>
            <a href="{{ route('dashboard.logbook', ['status' => 'Close']) }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ request('status') === 'Close' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'text-gray-600 hover:bg-white hover:text-indigo-600' }}">Close</a>
        </div>
        
        <div>
            <button onclick="document.getElementById('revisionModal').classList.remove('hidden')" class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold px-6 py-3 rounded-2xl shadow-[0_8px_20px_rgba(79,70,229,0.3)] hover:shadow-[0_12px_25px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3 group">
                <div class="bg-white/20 rounded-full w-6 h-6 flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <i class="fas fa-plus text-sm"></i>
                </div>
                Create Revision
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white border-2 border-gray-200 rounded-[20px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] overflow-hidden hover-glow mb-8">
        <!-- Table Header Bar -->
        <div class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 px-6 py-4 border-b-2 border-gray-200">
            <h3 class="font-bold text-indigo-900 text-[14px]">Daftar Revisi Klien</h3>
        </div>
        
        <div class="p-6 pb-2">
            <!-- Top Actions Bar -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-indigo-900 text-[15px] font-bold tracking-wide">Data Logbook</h2>
                
                <form method="GET" action="{{ route('dashboard.logbook') }}" class="relative group">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search revisions..." class="border border-gray-200 rounded-full px-4 pl-10 py-2.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-transparent transition-all shadow-sm" oninput="clearTimeout(this.timer); this.timer = setTimeout(() => { this.form.submit(); }, 600);" {{ request('search') ? 'autofocus onfocus=this.setSelectionRange(this.value.length,this.value.length)' : '' }}>
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 border-b-2 border-gray-200">
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-36">Tanggal</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center">Dokumen</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-32">Kode Revisi</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center">Revisi Klien</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-32">Personil</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-36">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-gray-100">
                    @foreach($revisions as $revision)
                    <tr class="hover:bg-[#FCFAFC] transition-all duration-300">
                        <td class="py-4 px-6 text-xs font-semibold text-gray-600 text-center">{{ \Carbon\Carbon::parse($revision->date)->format('Y-m-d') }}</td>
                        <td class="py-4 px-6 text-xs font-semibold text-gray-800">{{ $revision->document_name }}</td>
                        <td class="py-4 px-6 text-xs font-semibold text-gray-600 text-center">{{ $revision->revision_code }}</td>
                        <td class="py-4 px-6 text-xs text-gray-600 leading-relaxed max-w-xs truncate" title="{{ $revision->description }}">{{ $revision->description }}</td>
                        <td class="py-4 px-6 text-xs font-semibold text-gray-800 text-center">{{ $revision->personnel_name }}</td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form method="POST" action="{{ route('revisions.updateStatus', $revision->id) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ strtolower($revision->status) == 'open' ? 'Close' : 'Open' }}">
                                    <button type="submit" title="Toggle Status" class="inline-block {{ strtolower($revision->status) == 'open' ? 'bg-[#FCE3A1] text-[#916E18] border-[#F3D78A]' : 'bg-[#7AEC96] text-[#145525] border-[#68D983]' }} px-5 py-1.5 rounded text-xs font-bold shadow-sm border hover:opacity-80 transition">
                                        {{ ucfirst($revision->status) }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('revisions.destroy', $revision->id) }}" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Delete"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 mt-2 custom-pagination">
                {{ $revisions->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form Create Revision -->
    <div id="revisionModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 w-full max-w-lg p-6 relative">
            <button onclick="document.getElementById('revisionModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h2 class="text-xl font-bold text-gray-800 mb-5">Create New Revision</h2>
            <form method="POST" action="{{ route('revisions.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Dokumen</label>
                    <input type="text" name="document_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" required>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kode Revisi</label>
                        <input type="text" name="revision_code" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" required>
                            <option value="Open">Open</option>
                            <option value="Close">Close</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Revisi Klien (Deskripsi)</label>
                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" required></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Personil</label>
                    <input type="text" name="personnel_name" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" required>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold px-8 py-2.5 rounded-xl shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_8px_20px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition duration-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
