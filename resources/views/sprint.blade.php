@extends('app')

@section('content')
<div class="w-full max-w-[1200px] mx-auto pb-10">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8 pt-2">
        <div>
            <h1 class="text-[28px] font-bold text-[#6D6257] mb-1 tracking-tight">Active Sprint</h1>
            <p class="text-[13px] text-gray-500 font-semibold tracking-wide flex items-center gap-2">
                <i class="far fa-calendar-alt text-[#CBB964]"></i> Current Sprint Period
            </p>
        </div>
    </div>

    <!-- Goal Block -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-[#CDBFB4] rounded-[20px] p-6 shadow-sm flex flex-col items-center justify-center">
            <span class="text-xs text-gray-500 font-bold mb-1 tracking-wider">DONE</span>
            <span class="text-[32px] font-bold text-gray-700 leading-none">{{ $allBacklogs->where('status', 'Done')->sum('amount') }}</span>
        </div>
        <div class="bg-[#CDBFB4] rounded-[20px] p-6 shadow-sm flex flex-col items-center justify-center">
            <span class="text-xs text-gray-500 font-bold mb-1 tracking-wider">PROGRESS</span>
            <span class="text-[32px] font-bold text-gray-700 leading-none">{{ $allBacklogs->where('status', 'Progress')->sum('amount') }}</span>
        </div>
        <div class="bg-[#CDBFB4] rounded-[20px] p-6 shadow-sm flex flex-col items-center justify-center">
            <span class="text-xs text-gray-500 font-bold mb-1 tracking-wider">REVIEW</span>
            <span class="text-[32px] font-bold text-gray-700 leading-none">{{ $allBacklogs->where('status', 'Review')->sum('amount') }}</span>
        </div>
        <div class="bg-[#CDBFB4] rounded-[20px] p-6 shadow-sm flex flex-col items-center justify-center">
            <span class="text-xs text-gray-500 font-bold mb-1 tracking-wider">TO DO</span>
            <span class="text-[32px] font-bold text-gray-700 leading-none">{{ $allBacklogs->where('status', 'To Do')->sum('amount') }}</span>
        </div>
    </div>

    <!-- Backlog Section -->
    <div class="mb-4">
        <h2 class="text-[26px] font-bold text-[#6D6257] mb-6">Backlog</h2>
        
        <div class="bg-white border border-[#DCD3CB] rounded-lg shadow-sm">
            <!-- Table Header Bar -->
            <div class="bg-[#E6DFD9] px-6 py-3 border-b border-[#DCD3CB]">
                <h3 class="font-bold text-gray-800 text-sm">Sprint Backlog</h3>
            </div>
            
            <div class="p-6 pb-2">
                <!-- Top Actions Bar -->
                <div class="flex justify-between items-center mb-4">
                    <button onclick="document.getElementById('sprintModal').classList.remove('hidden')" class="bg-[#BCA99D] hover:bg-[#A99587] text-gray-800 font-bold px-4 py-1.5 rounded-md text-xs transition shadow-sm flex items-center gap-1">
                        Create Backlog <span class="text-sm font-normal leading-none">+</span>
                    </button>
                    <form method="GET" action="{{ route('dashboard.sprint') }}" class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="border border-[#DCD3CB] rounded px-3 pl-8 py-1.5 text-xs w-48 focus:outline-none focus:ring-1 focus:ring-[#BCA99D]">
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-center border-collapse border border-[#DCD3CB] whitespace-nowrap min-w-[700px]">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 font-bold text-gray-800 text-[13px] border border-[#DCD3CB] w-[35%]">Drawings Title</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-[13px] border border-[#DCD3CB]">Disiplin</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-[13px] border border-[#DCD3CB]">Nama</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-[13px] border border-[#DCD3CB]">Jumlah</th>
                                <th class="py-3 px-4 font-bold text-gray-800 text-[13px] border border-[#DCD3CB] w-32">Status</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($backlogs as $backlog)
                        <tr>
                            <td class="py-4 px-5 text-sm text-gray-700 border-b border-[#DCD3CB]">{{ $backlog->drawings_title }}</td>
                            <td class="py-4 px-5 text-sm text-gray-700 border-b border-[#DCD3CB] text-center">{{ $backlog->discipline }}</td>
                            <td class="py-4 px-5 text-sm text-gray-700 border-b border-[#DCD3CB] text-center">{{ $backlog->personnel_name }}</td>
                            <td class="py-4 px-5 text-sm text-gray-700 border-b border-[#DCD3CB] text-center">{{ $backlog->amount }}</td>
                            <td class="py-4 px-2 border-b border-[#DCD3CB] text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form method="POST" action="{{ route('sprints.updateStatus', $backlog->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="inline-block px-2 py-1.5 rounded-md text-xs font-bold shadow-sm cursor-pointer outline-none border-none
                                            {{ $backlog->status == 'Done' ? 'bg-[#1B9934] text-white' : '' }}
                                            {{ $backlog->status == 'Progress' ? 'bg-[#008DDF] text-white' : '' }}
                                            {{ $backlog->status == 'Review' ? 'bg-[#FFA600] text-white' : '' }}
                                            {{ $backlog->status == 'To Do' ? 'bg-[#C3B5A8] text-white' : '' }}">
                                            <option value="To Do" {{ $backlog->status == 'To Do' ? 'selected' : '' }} class="bg-white text-gray-800">To Do</option>
                                            <option value="Progress" {{ $backlog->status == 'Progress' ? 'selected' : '' }} class="bg-white text-gray-800">Progress</option>
                                            <option value="Review" {{ $backlog->status == 'Review' ? 'selected' : '' }} class="bg-white text-gray-800">Review</option>
                                            <option value="Done" {{ $backlog->status == 'Done' ? 'selected' : '' }} class="bg-white text-gray-800">Done</option>
                                        </select>
                                    </form>
                                    <form method="POST" action="{{ route('sprints.destroy', $backlog->id) }}" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Delete"><i class="far fa-trash-alt text-[14px]"></i></button>
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
            <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center text-gray-500 gap-4">
                <p class="text-[11px] font-medium tracking-wide">Menampilkan {{ $backlogs->firstItem() ?? 0 }} dari {{ $backlogs->total() }} poin</p>
                <div class="flex gap-2">
                    {{ $backlogs->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Form Create Backlog -->
    <div id="sprintModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
            <button onclick="document.getElementById('sprintModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h2 class="text-xl font-bold text-[#6D6257] mb-5">Create New Sprint Backlog</h2>
            <form method="POST" action="{{ route('sprints.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Drawings Title</label>
                    <input type="text" name="drawings_title" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Discipline</label>
                        <select name="discipline" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                            <option value="Arsitektur">Arsitektur</option>
                            <option value="Sipil">Sipil</option>
                            <option value="Struktur">Struktur</option>
                            <option value="Mekanikal & Plumbing">Mekanikal & Plumbing</option>
                            <option value="Elektrikal">Elektrikal</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Amount</label>
                        <input type="number" name="amount" min="1" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Personnel Name</label>
                        <input type="text" name="personnel_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                            <option value="To Do">To Do</option>
                            <option value="Progress">Progress</option>
                            <option value="Review">Review</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-[#BCA99D] hover:bg-[#A99587] text-gray-800 font-bold px-6 py-2 rounded-md transition shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
