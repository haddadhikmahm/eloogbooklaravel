@extends('app')

@section('content')
<div class="w-full pb-10">
    <!-- Header Area -->
    <!-- Header Area -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-start mb-6 pt-2 gap-6">
        <h1 class="text-[28px] sm:text-[32px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 tracking-tight">Team & Discipline</h1>
        
        <!-- Project Identity Card -->
        <div class="flex items-start gap-4 w-full lg:w-auto bg-white/50 lg:bg-transparent p-4 lg:p-0 rounded-2xl lg:rounded-none shadow-sm lg:shadow-none border border-gray-100 lg:border-none">
            <!-- Icon Box -->
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                <i class="fas fa-map-marked-alt text-xl sm:text-2xl text-[#8E9EAC]"></i>
            </div>
            
            <!-- Info Section -->
            <div class="flex flex-col">
                <div class="mb-1.5 flex items-center gap-2">
                    <span class="bg-[#C2A595] text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm tracking-wide">ACTIVE</span>
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
                        <span>{{ $project->disciplines_count ?? 0 }} Disiplin</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user-friends text-[#AAB8C7]"></i>
                        <span>{{ $project->personnel_count ?? 0 }} Personil</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Area -->
    <div class="flex flex-wrap items-center gap-3 mb-8">
            <a href="{{ route('dashboard.team', ['discipline' => 'All Personnel']) }}" class="{{ request('discipline', 'All Personnel') == 'All Personnel' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">All Personnel</a>
            <a href="{{ route('dashboard.team', ['discipline' => 'Civil']) }}" class="{{ request('discipline') == 'Civil' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">Civil</a>
            <a href="{{ route('dashboard.team', ['discipline' => 'Structural']) }}" class="{{ request('discipline') == 'Structural' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">Structural</a>
            <a href="{{ route('dashboard.team', ['discipline' => 'Architectural']) }}" class="{{ request('discipline') == 'Architectural' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">Architectural</a>
            <a href="{{ route('dashboard.team', ['discipline' => 'Mechanical']) }}" class="{{ request('discipline') == 'Mechanical' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">Mechanical</a>
            <a href="{{ route('dashboard.team', ['discipline' => 'Electrical']) }}" class="{{ request('discipline') == 'Electrical' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">Electrical</a>
            <a href="{{ route('dashboard.team', ['discipline' => 'Quantity Surveyor & Estimating']) }}" class="{{ request('discipline') == 'Quantity Surveyor & Estimating' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">Quantity Surveyor & Estimating</a>
            <a href="{{ route('dashboard.team', ['discipline' => 'Project Control']) }}" class="{{ request('discipline') == 'Project Control' ? 'bg-gradient-to-r from-indigo-600 to-blue-500 text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-[12px] sm:text-[13px] font-bold shadow-sm transition-all duration-300 whitespace-nowrap">Project Control</a>
    </div>

    <!-- Team Table -->
    <div class="bg-white border-2 border-gray-200 rounded-[20px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] overflow-hidden hover-glow mb-8">
            <!-- Table Header Bar -->
            <div class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 px-6 py-4 border-b-2 border-gray-200">
                <h3 class="font-bold text-indigo-900 text-[14px]">Team Members List</h3>
            </div>
            
            <div class="p-6 pb-2">
                <!-- Top Actions Bar -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="document.getElementById('teamModal').classList.remove('hidden')" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.4)] transform hover:-translate-y-0.5 flex items-center gap-2">
                            Add Member <span class="text-lg font-normal leading-none mb-0.5">+</span>
                        </button>
                        <div id="bulkActionContainer" class="hidden">
                            <button type="button" onclick="confirmBulkDelete()" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow-md flex items-center gap-2 transition-all">
                                <i class="far fa-trash-alt"></i> Delete (<span id="selectedCount">0</span>)
                            </button>
                        </div>
                    </div>
                    
                    <form method="GET" action="{{ route('dashboard.team') }}" class="relative group">
                        @if(request('discipline'))
                            <input type="hidden" name="discipline" value="{{ request('discipline') }}">
                        @endif
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search members..." class="border border-gray-200 rounded-full px-4 pl-10 py-2.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-transparent transition-all shadow-sm" oninput="clearTimeout(this.timer); this.timer = setTimeout(() => { this.form.submit(); }, 600);" {{ request('search') ? 'autofocus onfocus=this.setSelectionRange(this.value.length,this.value.length)' : '' }}>
                    </form>
                </div>

                <form id="bulkDeleteForm" method="POST" action="{{ route('team.bulkDestroy') }}" class="hidden">
                    @csrf
                </form>
                <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 border-b-2 border-gray-200">
                        <th class="py-5 px-6 text-xs font-bold text-gray-500 w-12 text-center">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-500 focus:ring-indigo-500 cursor-pointer">
                        </th>
                        <th class="py-5 px-6 text-xs font-bold text-indigo-900">Name & Email</th>
                        <th class="py-5 px-6 text-xs font-bold text-indigo-900">Discipline</th>
                        <th class="py-5 px-6 text-xs font-bold text-indigo-900">Role</th>
                        <th class="py-5 px-6 text-xs font-bold text-indigo-900">Access Level</th>
                        <th class="py-5 px-6 text-xs font-bold text-indigo-900 text-center">Active Doc.</th>
                        <th class="py-5 px-6 text-xs font-bold text-indigo-900 w-12 text-center"></th>
                    </tr>
                </thead>
            <tbody class="divide-y-2 divide-gray-100">
                @foreach($members as $member)
                <tr class="hover:bg-indigo-50/50 transition-all duration-300">
                    <td class="py-5 px-6 text-center">
                        <input type="checkbox" name="members[]" value="{{ $member->id }}" form="bulkDeleteForm" class="member-checkbox rounded border-gray-300 text-indigo-500 focus:ring-indigo-500 cursor-pointer">
                    </td>
                    <td class="py-5 px-6">
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
                    <td class="py-5 px-6 text-[13px] text-gray-700 font-medium">
                        {{ $member->discipline }}
                    </td>
                    <td class="py-5 px-6 text-[13px] text-gray-700 font-medium">
                        {{ $member->role }}
                    </td>
                    <td class="py-5 px-6">
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
                    <td class="py-5 px-6 text-center text-[13px] text-gray-700 font-bold">
                        {{ $member->active_documents }}
                    </td>
                    <td class="py-5 px-6 text-center">
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
            
            <!-- Pagination -->
            <div class="px-6 py-4 mt-2 custom-pagination">
                {{ $members->links() }}
            </div>
        </div>

</div>

<!-- Add Member Modal -->
<div id="teamModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-2 border-gray-200 w-full max-w-lg overflow-hidden">
        <div class="px-8 py-6 border-b-2 border-gray-200 flex justify-between items-center bg-gradient-to-r from-indigo-50/50 to-blue-50/50">
            <h3 class="font-bold text-gray-800 text-xl tracking-tight">Add Team Member</h3>
            <button onclick="document.getElementById('teamModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 bg-white hover:bg-gray-50 rounded-full w-8 h-8 flex items-center justify-center transition-colors shadow-sm"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('team.store') }}" class="p-8 flex flex-col gap-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Full Name</label>
                <input type="text" name="name" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Discipline</label>
                <select name="discipline" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm appearance-none bg-white cursor-pointer" required>
                    <option value="Civil">Civil</option>
                    <option value="Structural">Structural</option>
                    <option value="Architectural">Architectural</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Electrical">Electrical</option>
                    <option value="Quantity Surveyor & Estimating">Quantity Surveyor & Estimating</option>
                    <option value="Project Control">Project Control</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Role</label>
                <input type="text" name="role" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required placeholder="e.g. Lead Engineer">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Access Level</label>
                <select name="access_level" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm appearance-none bg-white cursor-pointer" required>
                    <option value="Full Access">Full Access</option>
                    <option value="Edit & Upload">Edit & Upload</option>
                    <option value="View Only">View Only</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-3 mt-4 pt-4 border-t-2 border-gray-200">
                <button type="button" onclick="document.getElementById('teamModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">Cancel</button>
                <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-8 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.4)] transform hover:-translate-y-0.5">Save Member</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.member-checkbox');
    const bulkActionContainer = document.getElementById('bulkActionContainer');
    const selectedCount = document.getElementById('selectedCount');

    function updateBulkAction() {
        const checkedBoxes = document.querySelectorAll('.member-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCount.textContent = count;
        
        if (count > 0) {
            bulkActionContainer.classList.remove('hidden');
        } else {
            bulkActionContainer.classList.add('hidden');
        }

        selectAll.checked = count > 0 && count === checkboxes.length;
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            updateBulkAction();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkAction);
    });

    function confirmBulkDelete() {
        Swal.fire({
            title: 'Delete Selected Members?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#9CA3AF',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulkDeleteForm').submit();
            }
        });
    }
</script>
@endsection
