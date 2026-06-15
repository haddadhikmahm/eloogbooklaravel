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

        <div class="flex items-start gap-4 max-w-lg text-left bg-white/50 p-3 rounded-2xl border border-gray-100 shadow-sm">
            <!-- Icon Box -->
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-gray-50/80 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-inner">
                <i class="fas fa-map-marked-alt text-xl sm:text-2xl text-[#8E9EAC]"></i>
            </div>
            
            <!-- Info Section -->
            <div class="flex flex-col flex-1">
                <div class="mb-1.5 flex items-center justify-between">
                    <span class="bg-[#C2A595] text-white text-[9px] font-bold px-2 py-0.5 rounded shadow-sm tracking-wide">ACTIVE</span>
                </div>
                <h1 class="text-[16px] sm:text-[18px] font-extrabold text-[#112338] leading-tight mb-1 truncate" title="{{ $project->code ? $project->code . ' - ' : '' }}{{ $project->name }}">
                    {{ $project->code ? $project->code . ' - ' : '' }}{{ $project->name }}
                </h1>
                <p class="text-[#72839A] text-[13px] sm:text-[14px] font-medium mb-2 truncate">
                    {{ $project->type ?: 'Detailed Engineering Design' }}
                </p>
                
                <div class="flex items-center gap-4 text-[#72839A] text-[12px] font-bold">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-layer-group text-[#AAB8C7] text-xs"></i>
                        <span>{{ $project->disciplines_count }} Disiplin</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user-friends text-[#AAB8C7] text-xs"></i>
                        <span>{{ $project->personnel_count }} Personil</span>
                    </div>
                </div>
            </div>
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
    </div>

    <!-- Sprint Management Section -->
    <div class="mb-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-[26px] font-bold text-gray-800">Sprints</h2>
            <button onclick="document.getElementById('createSprintModal').classList.remove('hidden')" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-4 py-2.5 rounded-xl text-[13px] flex items-center gap-2 shadow-sm transition-all hover:shadow">
                <i class="fas fa-plus"></i> Create New Sprint
            </button>
        </div>

        <div class="flex flex-col gap-6">
            @foreach($sprints as $sprint)
            @php
                $sprintTasks = $sprint->tasks;
                $totalPoints = $sprintTasks->sum('points');
                $donePoints = $sprintTasks->where('status', 'Done')->sum('points');
                $progressPercent = $totalPoints > 0 ? round(($donePoints / $totalPoints) * 100) : 0;
                $startDate = $sprint->start_date ? $sprint->start_date->format('d M') : '';
                $endDate = $sprint->end_date ? $sprint->end_date->format('d M Y') : '';
            @endphp
            <div class="bg-[#242424] border border-[#333] rounded-[16px] overflow-hidden shadow-lg font-sans">
                <div class="p-5 border-b border-[#333]">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <button class="text-gray-400 hover:text-gray-200"><i class="fas fa-chevron-down"></i></button>
                            <div>
                                <h3 class="text-white text-[15px] font-semibold flex items-center gap-2">
                                    {{ $sprint->name }} @if($sprint->goal) — {{ $sprint->goal }} @endif
                                    <span class="bg-[#E6F4EA] text-[#1E8E3E] text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-1">{{ $sprint->status }}</span>
                                </h3>
                                <p class="text-[#888] text-[12px] mt-1 tracking-wide">{{ $startDate }} - {{ $endDate }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="openAddTaskModal({{ $sprint->id }}, '{{ $sprint->name }}')" class="bg-[#333] hover:bg-[#444] text-[#DDD] border border-[#444] text-[12px] font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-plus"></i> Add task to backlog
                            </button>
                            <a href="{{ route('dashboard.kanban') }}" class="bg-[#333] hover:bg-[#444] text-[#DDD] border border-[#444] text-[12px] font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-columns"></i> View in Kanban
                            </a>
                            <button class="bg-[#333] hover:bg-[#444] text-[#DDD] border border-[#444] w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fas fa-ellipsis-h text-[12px]"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 mt-5 mb-1 pl-7">
                        <span class="text-[#888] text-[12px] font-medium min-w-[70px]">{{ $sprintTasks->where('status', 'Done')->count() }} / {{ $sprintTasks->count() }} done</span>
                        <div class="flex-1 bg-[#333] h-1.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                        </div>
                        <span class="text-emerald-500 text-[12px] font-bold w-8">{{ $progressPercent }}%</span>
                        <span class="text-[#888] text-[12px] italic text-right min-w-[70px]">
                            {{ $donePoints }}/{{ $totalPoints }} Pts
                        </span>
                    </div>
                </div>
                
                <div class="bg-[#1E1E1E]">
                    @foreach($sprintTasks as $task)
                    <div class="flex items-center justify-between px-5 py-2.5 border-b border-[#2A2A2A] hover:bg-[#2A2A2A] transition-colors group">
                        <div class="flex items-center gap-4 pl-2">
                            <div class="w-2 h-2 rounded-full {{ ['To Do'=>'bg-[#555]', 'Progress'=>'bg-blue-500', 'Review'=>'bg-amber-500', 'Done'=>'bg-emerald-500'][$task->status] ?? 'bg-[#555]' }}"></div>
                            <span class="text-[#DDD] text-[13px] font-medium">{{ $task->title }}</span>
                        </div>
                        <div class="flex items-center gap-3 opacity-90 group-hover:opacity-100 transition-opacity">
                            @if($task->tag)
                            <span class="bg-[#333] text-[#E5A8A8] text-[10px] uppercase font-bold px-2 py-0.5 rounded border border-[#444]">{{ $task->tag }}</span>
                            @endif
                            @if($task->assignee)
                            <div class="w-6 h-6 rounded-full bg-[#18534f] text-emerald-100 flex items-center justify-center text-[10px] font-bold border border-emerald-800" title="{{ $task->assignee }}">
                                {{ strtoupper(substr($task->assignee, 0, 2)) }}
                            </div>
                            @endif
                            <span class="text-[#666] text-[11px] font-mono min-w-[40px] text-right">{{ $task->task_code }}</span>
                        </div>
                    </div>
                    @endforeach
                    @if($sprintTasks->isEmpty())
                    <div class="px-5 py-4 text-center text-[#666] text-[13px]">
                        No tasks in this sprint. Click "Add task to backlog" to create one.
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            
            @if($sprints->isEmpty())
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl p-10 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                    <i class="fas fa-layer-group text-2xl text-indigo-400"></i>
                </div>
                <h3 class="text-gray-800 font-bold mb-1">No Sprints Found</h3>
                <p class="text-gray-500 text-sm mb-5 max-w-sm">Create a sprint to group your tasks and track progress towards your goals.</p>
                <button onclick="document.getElementById('createSprintModal').classList.remove('hidden')" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-bold px-6 py-2.5 rounded-xl text-sm transition-colors">
                    Create First Sprint
                </button>
            </div>
            @endif
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
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px]">Discipline</th>
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px]">Name</th>
                                <th class="py-4 px-4 font-bold text-gray-600 text-[13px]">Amount</th>
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
                            <option value="Civil">Civil</option>
                            <option value="Structural">Structural</option>
                            <option value="Architectural">Architectural</option>
                            <option value="Mechanical">Mechanical</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Quantity Surveyor & Estimating">Quantity Surveyor & Estimating</option>
                            <option value="Project Control">Project Control</option>
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
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-8 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.4)] transform hover:-translate-y-0.5">Save</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Modal Form Create Sprint -->
    <div id="createSprintModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-2 border-gray-200 w-full max-w-lg overflow-hidden transform transition-all">
            <div class="px-8 py-6 border-b-2 border-gray-200 flex justify-between items-center bg-gradient-to-r from-indigo-50/50 to-blue-50/50">
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Create New Sprint</h2>
                <button onclick="document.getElementById('createSprintModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 bg-white hover:bg-gray-50 rounded-full w-8 h-8 flex items-center justify-center transition-colors shadow-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('sprints.manage.store') }}" class="flex flex-col gap-5 p-8">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Sprint Name</label>
                    <input type="text" name="name" placeholder="e.g. Sprint 2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Goal (Optional)</label>
                    <input type="text" name="goal" placeholder="e.g. Revisi Dokumen DED" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                </div>
                <div class="flex gap-5">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Start Date</label>
                        <input type="date" name="start_date" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">End Date</label>
                        <input type="date" name="end_date" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm appearance-none bg-white cursor-pointer" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Akan Datang">Akan Datang</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('createSprintModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">Cancel</button>
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-8 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.4)] transform hover:-translate-y-0.5">Create Sprint</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form Create Sprint Task -->
    <div id="createSprintTaskModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-2 border-gray-200 w-full max-w-lg overflow-hidden transform transition-all">
            <div class="px-8 py-6 border-b-2 border-gray-200 flex justify-between items-center bg-gradient-to-r from-indigo-50/50 to-blue-50/50">
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Add Task to <span id="sprintTaskTargetName" class="text-indigo-600">Sprint</span></h2>
                <button onclick="document.getElementById('createSprintTaskModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 bg-white hover:bg-gray-50 rounded-full w-8 h-8 flex items-center justify-center transition-colors shadow-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="createSprintTaskForm" method="POST" action="" class="flex flex-col gap-5 p-8">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Task Title</label>
                    <input type="text" name="title" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" required>
                </div>
                <div class="flex gap-5">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Tag</label>
                        <input type="text" name="tag" placeholder="e.g. Backend" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Assignee Name</label>
                        <input type="text" name="assignee" placeholder="e.g. AR" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Status</label>
                        <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm appearance-none bg-white cursor-pointer" required>
                            <option value="To Do">To Do</option>
                            <option value="Progress">Progress</option>
                            <option value="Review">Review</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Points</label>
                        <input type="number" name="points" min="1" placeholder="e.g. 5" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('createSprintTaskModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">Cancel</button>
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-8 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.4)] transform hover:-translate-y-0.5">Add Task</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openAddTaskModal(sprintId, sprintName) {
            document.getElementById('sprintTaskTargetName').innerText = sprintName;
            document.getElementById('createSprintTaskForm').action = `/sprints/manage/${sprintId}/tasks`;
            document.getElementById('createSprintTaskModal').classList.remove('hidden');
        }
    </script>
</div>
@endsection
