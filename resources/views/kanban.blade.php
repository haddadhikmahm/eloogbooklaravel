@extends('app')

@section('content')
<div class="max-w-[1200px] w-full mx-auto pb-10">
    <!-- Top Header & Project Identity Card -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-start mb-6 pt-2 gap-6">
        <div>
            <h1 class="text-[28px] sm:text-[32px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 tracking-tight mb-2">Kanban Board</h1>
        </div>
        
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

    @if($activeSprint)
    @php
        $sprintTasks = $activeSprint->tasks;
        $totalTasks = $sprintTasks->count();
        $doneTasks = $sprintTasks->where('status', 'Done')->count();
        $progressPercent = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
        
        $startDate = $activeSprint->start_date ? $activeSprint->start_date->format('d M') : '';
        $endDate = $activeSprint->end_date ? $activeSprint->end_date->format('d M Y') : '';
        $daysRemaining = $activeSprint->end_date ? now()->diffInDays($activeSprint->end_date, false) : 0;
        $daysText = $daysRemaining > 0 ? $daysRemaining . ' days left' : 'Ended';
        
        // Custom short name logic for sprint badge
        $nameParts = explode(' ', $activeSprint->name);
        $sprintLabel = count($nameParts) > 1 ? $nameParts[0] : 'Sprint';
        $sprintNum = count($nameParts) > 1 ? $nameParts[1] : $activeSprint->name;
    @endphp
    <!-- Dark Sprint Header -->
    <div class="bg-[#242424] text-white rounded-t-[16px] p-6 mb-0 font-sans border border-[#333] border-b-0 shadow-lg">
        <div class="flex justify-between items-start mb-6">
            <div class="flex items-start gap-4">
                <div class="bg-[#E6F4EA] text-[#1E8E3E] text-xs font-bold px-3 py-2 rounded-lg mt-1 text-center min-w-[70px]">
                    {{ $sprintLabel }}<br>
                    <span class="text-[14px]">{{ $sprintNum }}</span>
                </div>
                <div>
                    <h2 class="text-[20px] font-bold text-white leading-tight">
                        {{ $activeSprint->goal ?: $activeSprint->name }}
                    </h2>
                    <p class="text-[#999] text-[13px] mt-1">{{ $startDate }} - {{ $endDate }} &bull; {{ $daysText }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.sprint') }}" class="bg-[#333] hover:bg-[#444] text-[#DDD] border border-[#444] text-[13px] font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                    <i class="fas fa-list-ul"></i> Backlog
                </a>
                <button class="bg-[#333] hover:bg-[#444] text-[#DDD] border border-[#444] text-[13px] font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                    <i class="far fa-play-circle"></i> Start Sprint
                </button>
                <form method="POST" action="{{ route('sprints.manage.destroy', $activeSprint->id) }}" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-[#333] hover:bg-red-500 hover:border-red-600 text-[#DDD] hover:text-white border border-[#444] w-9 h-9 rounded-lg flex items-center justify-center transition-colors" title="Delete Active Sprint">
                        <i class="far fa-trash-alt text-[12px]"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex items-center gap-4 text-[#999] text-[13px] mb-6">
            <span class="w-28 font-medium">Sprint progress</span>
            <div class="flex-1 bg-[#333] h-1.5 rounded-full overflow-hidden">
                <div class="bg-[#1E8E3E] h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
            </div>
            <span class="font-bold text-white w-10 text-right">{{ $progressPercent }}%</span>
            <span class="w-32 text-right">{{ $doneTasks }} / {{ $totalTasks }} tasks done</span>
        </div>

        <div class="flex justify-between items-center border-t border-[#333] pt-5">
            <div class="flex items-center gap-3 overflow-x-auto pb-1 custom-scrollbar">
                <i class="fas fa-filter text-[#666] ml-1 mr-1"></i>
                <button class="bg-[#E6F4EA] text-[#1E8E3E] font-bold text-[12px] px-4 py-1.5 rounded-full whitespace-nowrap">All</button>
                <button class="bg-transparent border border-[#555] text-[#CCC] hover:text-white font-medium text-[12px] px-4 py-1.5 rounded-full transition whitespace-nowrap">Me</button>
                <button class="bg-transparent border border-[#555] text-[#CCC] hover:text-white font-medium text-[12px] px-4 py-1.5 rounded-full transition whitespace-nowrap">Design</button>
                <button class="bg-transparent border border-[#555] text-[#CCC] hover:text-white font-medium text-[12px] px-4 py-1.5 rounded-full transition whitespace-nowrap">Frontend</button>
                <button class="bg-transparent border border-[#555] text-[#CCC] hover:text-white font-medium text-[12px] px-4 py-1.5 rounded-full transition whitespace-nowrap">Backend</button>
            </div>
            <span class="text-[#777] text-[12px] whitespace-nowrap ml-4">Filter by this sprint</span>
        </div>
    </div>
    @endif

    <!-- Kanban Horizontal Container -->
    <div class="flex flex-row overflow-x-auto gap-4 pb-6 custom-scrollbar min-h-[500px] items-start bg-[#141414] {{ $activeSprint ? 'rounded-b-[16px] border border-t-0 border-[#333] pt-6 px-6 shadow-lg' : 'rounded-[16px] p-6 shadow-lg' }}">
        
        @foreach($kanbanBoards as $index => $board)
        @php
            $boardTasks = $tasks->where('status', $board->name);
            $dotColor = ['To Do'=>'bg-[#888]', 'In Progress'=>'bg-[#3B82F6]', 'Review'=>'bg-[#F59E0B]', 'Done'=>'bg-[#10B981]'][$board->name] ?? 'bg-[#888]';
        @endphp
        <!-- Board Column -->
        <div class="w-[320px] min-w-[320px] flex flex-col shrink-0">
            <div class="flex items-center justify-between mb-4 mt-1 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full {{ $dotColor }}"></div>
                    <h2 class="text-[15px] font-bold text-white">{{ $board->name }}</h2>
                    <span class="text-[11px] font-bold bg-[#333] text-[#AAA] px-2 py-0.5 rounded-full ml-1">{{ $boardTasks->count() }}</span>
                </div>
                <button class="text-[#888] hover:text-[#CCC]"><i class="fas fa-plus text-[14px]"></i></button>
            </div>
            
            <div class="flex flex-col gap-3 flex-1">
                @foreach($boardTasks as $task)
                <div class="bg-[#2A2A2A] border border-[#333] rounded-[12px] p-4 shadow-sm hover:border-[#555] transition-all duration-200 group flex flex-col gap-3">
                    <div class="text-[14px] text-white font-semibold leading-snug">{{ $task->title }}</div>
                    
                    <div class="flex justify-between items-end mt-1">
                        <div class="flex items-center gap-2">
                            @if($task->tag)
                            <span class="bg-[#F5E6E6] text-[#A05252] text-[10px] font-bold px-2 py-0.5 rounded">{{ $task->tag }}</span>
                            @endif
                        </div>
                        @if($task->assignee)
                        <div class="w-7 h-7 rounded-full bg-[#18534f] text-[#E6F4EA] flex items-center justify-center text-[10px] font-bold border border-[#1E8E3E]" title="{{ $task->assignee }}">
                            {{ strtoupper(substr($task->assignee, 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between mt-1 border-t border-[#3A3A3A] pt-2">
                        <div class="text-[#777] text-[11px] font-mono flex items-center gap-1.5">
                            <i class="fas fa-link text-[10px]"></i> {{ $task->sprint ? explode(' ', $task->sprint->name)[0] . ' ' . (explode(' ', $task->sprint->name)[1]??'') : 'Sprint' }} &bull; {{ $task->task_code }}
                        </div>
                    
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        @if($index > 0)
                        <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="{{ $kanbanBoards[$index - 1]->name }}">
                            <button type="submit" class="text-[#888] hover:text-white transition" title="Move Left"><i class="fas fa-chevron-left text-[12px]"></i></button>
                        </form>
                        @endif
                        
                        @if($index < count($kanbanBoards) - 1)
                        <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="{{ $kanbanBoards[$index + 1]->name }}">
                            <button type="submit" class="text-[#888] hover:text-white transition" title="Move Right"><i class="fas fa-chevron-right text-[12px]"></i></button>
                        </form>
                        @endif
                        
                        <form method="POST" action="{{ route('kanban.destroy', $task->id) }}" class="inline delete-form ml-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#888] hover:text-[#EF4444] transition" title="Delete"><i class="far fa-trash-alt text-[12px]"></i></button>
                        </form>
                    </div>
                    </div>
                </div>
                @endforeach
                
                <!-- New Task Form -->
                <div class="bg-[#2A2A2A] border border-[#333] rounded-[12px] px-4 py-3 shadow-sm mt-1 transition duration-200 focus-within:border-[#555]">
                    <form method="POST" action="{{ route('kanban.store') }}" class="flex items-center">
                        @csrf
                        <input type="hidden" name="status" value="{{ $board->name }}">
                        <input type="text" name="title" placeholder="New Tasks" class="w-full text-[13px] font-bold text-white bg-transparent focus:outline-none placeholder-[#666]" required>
                    </form>
                </div>
            </div>

            <!-- Board Controls (Move & Delete) -->
            <div class="flex justify-between items-center mt-3 px-1 text-[#888]">
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('kanban-boards.move', $board->id) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="direction" value="left">
                        <button type="submit" class="hover:text-[#CCC] transition" title="Move Board Left"><i class="far fa-arrow-alt-circle-left text-[16px]"></i></button>
                    </form>
                    <form method="POST" action="{{ route('kanban-boards.move', $board->id) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="direction" value="right">
                        <button type="submit" class="hover:text-[#CCC] transition" title="Move Board Right"><i class="far fa-arrow-alt-circle-right text-[16px]"></i></button>
                    </form>
                </div>
                <form method="POST" action="{{ route('kanban-boards.destroy', $board->id) }}" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hover:text-[#EF4444] transition" title="Delete Board"><i class="far fa-trash-alt text-[16px]"></i></button>
                </form>
            </div>
        </div>
        @endforeach
        
    </div>

    <!-- Create New Board Button -->
    <div class="flex justify-center mt-8 pb-4">
        <button onclick="document.getElementById('boardModal').classList.remove('hidden')" class="bg-[#141414] border-2 border-dashed border-[#333] hover:border-[#555] hover:bg-[#1A1A1A] hover:scale-[1.02] text-[#888] hover:text-[#CCC] font-bold px-10 py-8 rounded-3xl transition-all duration-300 shadow-sm w-full max-w-[400px] flex flex-col items-center justify-center gap-3 group">
            <div class="bg-[#242424] w-12 h-12 rounded-full flex items-center justify-center group-hover:bg-[#333] transition border border-[#333]">
                <i class="fas fa-plus text-xl text-[#666] group-hover:text-white"></i>
            </div>
            <span class="text-[15px]">Create a new board</span>
        </button>
    </div>
</div>

<!-- Add Board Modal -->
<div id="boardModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-indigo-50">
            <h3 class="font-bold text-gray-800">Add New Board</h3>
            <button onclick="document.getElementById('boardModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('kanban-boards.store') }}" class="p-6 flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Board Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500" required placeholder="e.g. In Review">
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="document.getElementById('boardModal').classList.add('hidden')" class="px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition duration-200">Cancel</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:shadow-lg hover:-translate-y-0.5 rounded-xl transition duration-200 shadow-md">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
