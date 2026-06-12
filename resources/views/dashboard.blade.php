@extends('app')

@section('content')
<div class="w-full max-w-[1200px] mx-auto pb-10">
    <!-- Header & Stats -->
    <div class="mb-8 pt-2">
        <h1 class="text-[28px] font-bold text-[#6D6257] mb-6">Logbook Revisi Klien</h1>
        
        <div class="flex flex-wrap gap-3 sm:gap-4 md:gap-5">
            <div class="bg-white border border-[#EBE6E0] rounded-lg p-3 sm:p-4 w-32 sm:w-36 shadow-sm">
                <p class="text-[13px] font-bold text-gray-800 mb-1">Total Revisi</p>
                <p class="text-[32px] font-light text-gray-600 leading-none">{{ $allRevisionsCount }}</p>
            </div>
            <div class="bg-white border border-[#EBE6E0] rounded-lg p-3 sm:p-4 w-32 sm:w-36 shadow-sm">
                <p class="text-[13px] font-bold text-gray-800 mb-1">Open</p>
                <p class="text-[32px] font-light text-gray-600 leading-none">{{ $openRevisionsCount }}</p>
            </div>
            <div class="bg-white border border-[#EBE6E0] rounded-lg p-3 sm:p-4 w-32 sm:w-36 shadow-sm">
                <p class="text-[13px] font-bold text-gray-800 mb-1">Close</p>
                <p class="text-[32px] font-light text-gray-600 leading-none">{{ $closeRevisionsCount }}</p>
            </div>
        </div>
    </div>

    <!-- Filters Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('dashboard.logbook', ['status' => 'All']) }}" class="px-7 py-2 rounded-full text-sm font-bold transition shadow-sm {{ request('status', 'All') === 'All' ? 'bg-[#BFA99C] text-gray-800' : 'bg-white text-gray-800 border border-[#DCD3CB] hover:bg-gray-50' }}">All</a>
            <a href="{{ route('dashboard.logbook', ['status' => 'Open']) }}" class="px-7 py-2 rounded-full text-sm font-bold transition shadow-sm {{ request('status') === 'Open' ? 'bg-[#BFA99C] text-gray-800' : 'bg-white text-gray-800 border border-[#DCD3CB] hover:bg-gray-50' }}">Open</a>
            <a href="{{ route('dashboard.logbook', ['status' => 'Close']) }}" class="px-7 py-2 rounded-full text-sm font-bold transition shadow-sm {{ request('status') === 'Close' ? 'bg-[#BFA99C] text-gray-800' : 'bg-white text-gray-800 border border-[#DCD3CB] hover:bg-gray-50' }}">Close</a>
        </div>
        
        <div>
            <button onclick="document.getElementById('revisionModal').classList.remove('hidden')" class="bg-[#BCA99D] hover:bg-[#A99587] text-gray-800 font-bold px-5 py-2.5 rounded-md text-sm transition shadow-sm flex items-center gap-1">
                Create Revision <span class="text-lg font-normal leading-none">+</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white border border-[#EBE6E0] rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="bg-[#F8F5F2]">
                        <th class="py-4 px-5 font-bold text-gray-800 text-sm border-b border-r border-[#DCD3CB] text-center w-36">Tanggal</th>
                        <th class="py-4 px-5 font-bold text-gray-800 text-sm border-b border-r border-[#DCD3CB] text-center">Dokumen</th>
                        <th class="py-4 px-5 font-bold text-gray-800 text-sm border-b border-r border-[#DCD3CB] text-center w-32">Kode Revisi</th>
                        <th class="py-4 px-5 font-bold text-gray-800 text-sm border-b border-r border-[#DCD3CB] text-center">Revisi Klien</th>
                        <th class="py-4 px-5 font-bold text-gray-800 text-sm border-b border-r border-[#DCD3CB] text-center w-32">Personil</th>
                        <th class="py-4 px-5 font-bold text-gray-800 text-sm border-b border-[#DCD3CB] text-center w-36">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revisions as $revision)
                    <tr>
                        <td class="py-4 px-5 text-xs text-gray-700 border-b border-r border-[#DCD3CB] text-center">{{ \Carbon\Carbon::parse($revision->date)->format('Y-m-d') }}</td>
                        <td class="py-4 px-5 text-xs text-gray-700 border-b border-r border-[#DCD3CB]">{{ $revision->document_name }}</td>
                        <td class="py-4 px-5 text-xs text-gray-700 border-b border-r border-[#DCD3CB] text-center">{{ $revision->revision_code }}</td>
                        <td class="py-4 px-5 text-xs text-gray-700 border-b border-r border-[#DCD3CB] leading-relaxed">{{ $revision->description }}</td>
                        <td class="py-4 px-5 text-xs text-gray-700 border-b border-r border-[#DCD3CB] text-center">{{ $revision->personnel_name }}</td>
                        <td class="py-4 px-5 border-b border-[#DCD3CB] text-center">
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
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
        <p class="text-[11px] text-gray-500 font-medium tracking-wide">Menampilkan {{ $revisions->firstItem() ?? 0 }} dari {{ $revisions->total() }} revisi</p>
        <div class="flex gap-1.5">
            {{ $revisions->links('pagination::tailwind') }}
        </div>
    </div>
</div>

    <!-- Modal Form Create Revision -->
    <div id="revisionModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
            <button onclick="document.getElementById('revisionModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h2 class="text-xl font-bold text-[#6D6257] mb-5">Create New Revision</h2>
            <form method="POST" action="{{ route('revisions.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Dokumen</label>
                    <input type="text" name="document_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kode Revisi</label>
                        <input type="text" name="revision_code" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                            <option value="Open">Open</option>
                            <option value="Close">Close</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Revisi Klien (Deskripsi)</label>
                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Personil</label>
                    <input type="text" name="personnel_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-[#BCA99D] hover:bg-[#A99587] text-gray-800 font-bold px-6 py-2 rounded-md transition shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
