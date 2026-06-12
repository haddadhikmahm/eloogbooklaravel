@extends('app')

@section('content')
<div class="w-full max-w-[1200px] mx-auto pb-10">
    <!-- Header Area -->
    <div class="flex justify-between items-start mb-8 pt-2">
        <div class="flex-1">
            <h1 class="text-[28px] font-bold text-[#6D6257] mb-6">Team & Discipline</h1>
            <!-- Filters Area -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mr-0 lg:mr-8">
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('dashboard.team', ['discipline' => 'All Personnel']) }}" class="{{ request('discipline', 'All Personnel') == 'All Personnel' ? 'bg-[#BFA99C] text-white' : 'bg-white border border-[#DCD3CB] text-gray-600 hover:bg-gray-50' }} px-5 py-2 rounded-md text-[13px] font-bold shadow-sm transition">All Personnel</a>
                    <a href="{{ route('dashboard.team', ['discipline' => 'Sipil']) }}" class="{{ request('discipline') == 'Sipil' ? 'bg-[#BFA99C] text-white' : 'bg-white border border-[#DCD3CB] text-gray-600 hover:bg-gray-50' }} px-5 py-2 rounded-md text-[13px] font-bold shadow-sm transition">Sipil</a>
                    <a href="{{ route('dashboard.team', ['discipline' => 'Struktur']) }}" class="{{ request('discipline') == 'Struktur' ? 'bg-[#BFA99C] text-white' : 'bg-white border border-[#DCD3CB] text-gray-600 hover:bg-gray-50' }} px-5 py-2 rounded-md text-[13px] font-bold shadow-sm transition">Struktur</a>
                    <a href="{{ route('dashboard.team', ['discipline' => 'Arsitektur']) }}" class="{{ request('discipline') == 'Arsitektur' ? 'bg-[#BFA99C] text-white' : 'bg-white border border-[#DCD3CB] text-gray-600 hover:bg-gray-50' }} px-5 py-2 rounded-md text-[13px] font-bold shadow-sm transition">Arsitektur</a>
                    <a href="{{ route('dashboard.team', ['discipline' => 'Mekanikal']) }}" class="{{ request('discipline') == 'Mekanikal' ? 'bg-[#BFA99C] text-white' : 'bg-white border border-[#DCD3CB] text-gray-600 hover:bg-gray-50' }} px-5 py-2 rounded-md text-[13px] font-bold shadow-sm transition">Mekanikal</a>
                    <a href="{{ route('dashboard.team', ['discipline' => 'Elektrikal']) }}" class="{{ request('discipline') == 'Elektrikal' ? 'bg-[#BFA99C] text-white' : 'bg-white border border-[#DCD3CB] text-gray-600 hover:bg-gray-50' }} px-5 py-2 rounded-md text-[13px] font-bold shadow-sm transition">Elektrikal</a>
                </div>
                <div>
                    <button onclick="document.getElementById('teamModal').classList.remove('hidden')" class="bg-[#BCA99D] hover:bg-[#A99587] text-white font-bold px-5 py-2.5 rounded-md text-sm transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-plus"></i> Add Member
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Active Project Card -->
        <div class="bg-white border border-[#E2DDD8] rounded-xl p-5 shadow-sm w-[340px] flex gap-4 items-center">
            <div class="w-14 h-14 bg-gray-100 rounded border border-[#DCD3CB] flex items-center justify-center">
                <!-- Placeholder for map/image -->
                <i class="fas fa-map-marked-alt text-gray-400 text-xl"></i>
            </div>
            <div>
                <span class="bg-[#BFA99C] text-white text-[9px] font-bold px-2 py-0.5 rounded tracking-wide">ACTIVE</span>
                <h3 class="font-bold text-gray-800 text-[13px] mt-1">{{ $project->code }} - {{ $project->name }}</h3>
                <p class="text-[11px] text-gray-500 mt-1">{{ $project->type }}</p>
                <div class="flex gap-4 mt-2">
                    <div class="flex items-center gap-1 text-[11px] text-gray-500 font-semibold">
                        <i class="fas fa-layer-group text-[#BFA99C]"></i> {{ $project->disciplines_count }} Disiplin
                    </div>
                    <div class="flex items-center gap-1 text-[11px] text-gray-500 font-semibold">
                        <i class="fas fa-users text-[#BFA99C]"></i> {{ $project->personnel_count }} Personil
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Table -->
    <div class="bg-white border border-[#DCD3CB] rounded-lg overflow-x-auto shadow-sm">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
            <thead>
                <tr class="bg-[#F8F5F2]">
                    <th class="py-3 px-5 text-xs font-bold text-gray-500 border-b border-[#DCD3CB] w-12 text-center">
                        <input type="checkbox" class="rounded border-gray-300 text-[#BFA99C] focus:ring-[#BFA99C]">
                    </th>
                    <th class="py-3 px-5 text-xs font-bold text-gray-500 border-b border-[#DCD3CB]">Nama & Email</th>
                    <th class="py-3 px-5 text-xs font-bold text-gray-500 border-b border-[#DCD3CB]">Disiplin</th>
                    <th class="py-3 px-5 text-xs font-bold text-gray-500 border-b border-[#DCD3CB]">Role</th>
                    <th class="py-3 px-5 text-xs font-bold text-gray-500 border-b border-[#DCD3CB]">Access Level</th>
                    <th class="py-3 px-5 text-xs font-bold text-gray-500 border-b border-[#DCD3CB] text-center">Active Doc.</th>
                    <th class="py-3 px-5 text-xs font-bold text-gray-500 border-b border-[#DCD3CB] w-12 text-center"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 px-5 border-b border-[#DCD3CB] text-center">
                        <input type="checkbox" class="rounded border-gray-300 text-[#BFA99C] focus:ring-[#BFA99C]">
                    </td>
                    <td class="py-4 px-5 border-b border-[#DCD3CB]">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full text-white flex items-center justify-center text-[11px] font-bold" style="background-color: {{ $member->color_hex }}">
                                {{ $member->initials }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500">{{ $member->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-5 border-b border-[#DCD3CB] text-[13px] text-gray-700 font-medium">
                        {{ $member->discipline }}
                    </td>
                    <td class="py-4 px-5 border-b border-[#DCD3CB] text-[13px] text-gray-700 font-medium">
                        {{ $member->role }}
                    </td>
                    <td class="py-4 px-5 border-b border-[#DCD3CB]">
                        @if($member->access_level == 'Full Access')
                        <span class="inline-block bg-[#E8F5E9] text-[#2E7D32] border border-[#A5D6A7] px-3 py-1 rounded text-[11px] font-bold shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i> Full Access
                        </span>
                        @elseif($member->access_level == 'Edit & Upload')
                        <span class="inline-block bg-[#E3F2FD] text-[#1565C0] border border-[#90CAF9] px-3 py-1 rounded text-[11px] font-bold shadow-sm">
                            <i class="fas fa-pen mr-1"></i> Edit & Upload
                        </span>
                        @else
                        <span class="inline-block bg-[#FFF3E0] text-[#E65100] border border-[#FFCC80] px-3 py-1 rounded text-[11px] font-bold shadow-sm">
                            <i class="far fa-eye mr-1"></i> View Only
                        </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 border-b border-[#DCD3CB] text-center text-[13px] text-gray-700 font-bold">
                        {{ $member->active_documents }}
                    </td>
                    <td class="py-4 px-5 border-b border-[#DCD3CB] text-center">
                        <form method="POST" action="{{ route('team.destroy', $member->id) }}" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Add Member Modal -->
<div id="teamModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-[#F8F5F2]">
            <h3 class="font-bold text-gray-800">Add Team Member</h3>
            <button onclick="document.getElementById('teamModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('team.store') }}" class="p-6 flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Discipline</label>
                <select name="discipline" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                    <option value="Sipil">Sipil</option>
                    <option value="Struktur">Struktur</option>
                    <option value="Arsitektur">Arsitektur</option>
                    <option value="Mekanikal">Mekanikal</option>
                    <option value="Elektrikal">Elektrikal</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Role</label>
                <input type="text" name="role" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required placeholder="e.g. Lead Engineer">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Access Level</label>
                <select name="access_level" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required>
                    <option value="Full Access">Full Access</option>
                    <option value="Edit & Upload">Edit & Upload</option>
                    <option value="View Only">View Only</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="document.getElementById('teamModal').classList.add('hidden')" class="px-4 py-2 text-sm font-bold text-gray-600 hover:bg-gray-100 rounded transition">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#BFA99C] hover:bg-[#A69186] rounded transition">Save Member</button>
            </div>
        </form>
    </div>
</div>

@endsection
