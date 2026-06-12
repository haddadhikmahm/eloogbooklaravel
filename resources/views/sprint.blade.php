@extends('app')

@section('content')
<div class="w-full pb-10">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8 pt-2">
        <div>
            <h1 class="text-[32px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 mb-1 tracking-tight">Active Sprint</h1>
            <p class="text-[13px] text-gray-500 font-semibold tracking-wide flex items-center gap-2">
                <i class="far fa-calendar-alt text-indigo-500"></i> Current Sprint Period
            </p>
        </div>
    </div>

    <!-- Goal Block -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-10">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 border-2 border-emerald-300/50 rounded-[24px] p-6 shadow-[0_8px_25px_rgba(16,185,129,0.3)] hover:shadow-[0_15px_35px_rgba(16,185,129,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center relative overflow-hidden group hover-glow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>
            <span class="text-[11px] text-emerald-100 font-bold mb-1.5 tracking-widest relative z-10">DONE</span>
            <span class="text-[36px] font-extrabold text-white leading-none relative z-10">{{ $allBacklogs->where('status', 'Done')->sum('amount') }}</span>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 border-2 border-blue-300/50 rounded-[24px] p-6 shadow-[0_8px_25px_rgba(59,130,246,0.3)] hover:shadow-[0_15px_35px_rgba(59,130,246,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center relative overflow-hidden group hover-glow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>
            <span class="text-[11px] text-blue-100 font-bold mb-1.5 tracking-widest relative z-10">PROGRESS</span>
            <span class="text-[36px] font-extrabold text-white leading-none relative z-10">{{ $allBacklogs->where('status', 'Progress')->sum('amount') }}</span>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 border-2 border-amber-300/50 rounded-[24px] p-6 shadow-[0_8px_25px_rgba(245,158,11,0.3)] hover:shadow-[0_15px_35px_rgba(245,158,11,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center relative overflow-hidden group hover-glow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>
            <span class="text-[11px] text-amber-100 font-bold mb-1.5 tracking-widest relative z-10">REVIEW</span>
            <span class="text-[36px] font-extrabold text-white leading-none relative z-10">{{ $allBacklogs->where('status', 'Review')->sum('amount') }}</span>
        </div>
        <div class="bg-gradient-to-br from-slate-500 to-gray-600 border-2 border-slate-400/50 rounded-[24px] p-6 shadow-[0_8px_25px_rgba(100,116,139,0.3)] hover:shadow-[0_15px_35px_rgba(100,116,139,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center relative overflow-hidden group hover-glow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>
            <span class="text-[11px] text-slate-200 font-bold mb-1.5 tracking-widest relative z-10">TO DO</span>
            <span class="text-[36px] font-extrabold text-white leading-none relative z-10">{{ $allBacklogs->where('status', 'To Do')->sum('amount') }}</span>
        </div>
    </div>

    <!-- Backlog Section -->
    <div class="mb-4">
        <h2 class="text-[26px] font-bold text-gray-800 mb-6">Backlog</h2>
        
        <div class="bg-white border-2 border-gray-200 rounded-[20px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] overflow-hidden hover-glow">
            <!-- Table Header Bar -->
            <div class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 px-6 py-4 border-b-2 border-gray-200">
                <h3 class="font-bold text-indigo-900 text-[14px]">Sprint Backlog</h3>
            </div>
            
            <div class="p-6 pb-2">
                <!-- Top Actions Bar -->
                <div class="flex justify-between items-center mb-6">
                    <button onclick="document.getElementById('sprintModal').classList.remove('hidden')" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.4)] transform hover:-translate-y-0.5 flex items-center gap-2">
                        Create Backlog <span class="text-lg font-normal leading-none mb-0.5">+</span>
                    </button>
                    <form method="GET" action="{{ route('dashboard.sprint') }}" class="relative group">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="border border-gray-200 rounded-full px-4 pl-10 py-2.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-transparent transition-all shadow-sm" oninput="clearTimeout(this.timer); this.timer = setTimeout(() => { this.form.submit(); }, 600);" {{ request('search') ? 'autofocus onfocus=this.setSelectionRange(this.value.length,this.value.length)' : '' }}>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-center border-collapse whitespace-nowrap min-w-[700px]">
                        <thead>
                            <tr class="bg-gray-50/50 border-b-2 border-gray-200">
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px] w-[35%] text-left rounded-tl-xl">Drawings Title</th>
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px]">Disiplin</th>
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px]">Nama</th>
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px]">Jumlah</th>
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px] w-32 rounded-tr-xl">Status</th>
                            </tr>
                        </thead>
                    <tbody class="divide-y-2 divide-gray-100">
                        @foreach($backlogs as $backlog)
                        <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                            <td class="py-4 px-5 text-sm text-gray-800 text-left font-medium">{{ $backlog->drawings_title }}</td>
                            <td class="py-4 px-5 text-sm text-gray-600 text-center">{{ $backlog->discipline }}</td>
                            <td class="py-4 px-5 text-sm text-gray-600 text-center">
                                <span class="bg-indigo-50 px-3 py-1 rounded-full text-xs font-semibold text-indigo-900 border border-indigo-200">{{ $backlog->personnel_name }}</span>
                            </td>
                            <td class="py-4 px-5 text-sm text-gray-600 text-center font-semibold">{{ $backlog->amount }}</td>
                            <td class="py-4 px-2 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <form method="POST" action="{{ route('sprints.updateStatus', $backlog->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="inline-block px-3 py-1.5 rounded-full text-xs font-bold shadow-sm cursor-pointer outline-none border-none transition-transform hover:scale-105 appearance-none text-center
                                            {{ $backlog->status == 'Done' ? 'bg-[#E6F4EA] text-[#1E8E3E] ring-1 ring-[#1E8E3E]/20' : '' }}
                                            {{ $backlog->status == 'Progress' ? 'bg-[#E3F2FD] text-[#1976D2] ring-1 ring-[#1976D2]/20' : '' }}
                                            {{ $backlog->status == 'Review' ? 'bg-[#FFF3E0] text-[#E65100] ring-1 ring-[#E65100]/20' : '' }}
                                            {{ $backlog->status == 'To Do' ? 'bg-[#F5F5F5] text-[#616161] ring-1 ring-[#616161]/20' : '' }}">
                                            <option value="To Do" {{ $backlog->status == 'To Do' ? 'selected' : '' }} class="bg-white text-gray-800">To Do</option>
                                            <option value="Progress" {{ $backlog->status == 'Progress' ? 'selected' : '' }} class="bg-white text-gray-800">Progress</option>
                                            <option value="Review" {{ $backlog->status == 'Review' ? 'selected' : '' }} class="bg-white text-gray-800">Review</option>
                                            <option value="Done" {{ $backlog->status == 'Done' ? 'selected' : '' }} class="bg-white text-gray-800">Done</option>
                                        </select>
                                    </form>
                                    <form method="POST" action="{{ route('sprints.destroy', $backlog->id) }}" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 hover:bg-red-50 w-8 h-8 rounded-full flex items-center justify-center transition-colors" title="Delete"><i class="far fa-trash-alt text-[14px]"></i></button>
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
                {{ $backlogs->links() }}
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Form Create Backlog -->
    <div id="sprintModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-2 border-gray-200 w-full max-w-lg overflow-hidden transform transition-all">
            <div class="px-8 py-6 border-b-2 border-gray-200 flex justify-between items-center bg-gradient-to-r from-indigo-50/50 to-blue-50/50">
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Create New Sprint Backlog</h2>
                <button onclick="document.getElementById('sprintModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 bg-white hover:bg-gray-50 rounded-full w-8 h-8 flex items-center justify-center transition-colors shadow-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('sprints.store') }}" class="flex flex-col gap-5 p-8">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Drawings Title</label>
                    <input type="text" name="drawings_title" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required>
                </div>
                <div class="flex gap-5">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Discipline</label>
                        <select name="discipline" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm appearance-none bg-white cursor-pointer" required>
                            <option value="Arsitektur">Arsitektur</option>
                            <option value="Sipil">Sipil</option>
                            <option value="Struktur">Struktur</option>
                            <option value="Mekanikal & Plumbing">Mekanikal & Plumbing</option>
                            <option value="Elektrikal">Elektrikal</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Amount</label>
                        <input type="number" name="amount" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Personnel Name</label>
                        <input type="text" name="personnel_name" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Status</label>
                        <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm appearance-none bg-white cursor-pointer" required>
                            <option value="To Do">To Do</option>
                            <option value="Progress">Progress</option>
                            <option value="Review">Review</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('sprintModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">Cancel</button>
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-8 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.4)] transform hover:-translate-y-0.5">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
