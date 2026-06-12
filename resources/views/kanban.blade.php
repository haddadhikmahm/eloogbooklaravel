@extends('app')

@section('content')
<div class="max-w-[1200px] w-full mx-auto pb-10">
    <!-- Header -->
    <div class="mb-8 text-center pt-2">
        <h1 class="text-[28px] font-bold text-[#6D6257]">Kanban Board</h1>
    </div>

    <!-- Kanban Horizontal Container -->
    <div class="flex flex-row overflow-x-auto gap-6 pb-6 custom-scrollbar min-h-[400px] items-start">
        
        @foreach($kanbanBoards as $index => $board)
        @php
            $boardTasks = $tasks->where('status', $board->name);
        @endphp
        <!-- Board Column -->
        <div class="bg-gradient-to-b from-[#F3EFEA] to-[#EAE4DD] border border-white w-[360px] min-w-[360px] rounded-3xl p-5 shadow-sm flex flex-col shrink-0">
            <div class="flex items-center justify-center gap-3 mb-5 mt-1">
                <h2 class="text-xl font-bold text-gray-700">{{ $board->name }}</h2>
                <span class="text-xs font-bold bg-white text-gray-500 px-2 py-0.5 rounded-full shadow-sm">{{ $boardTasks->count() }}</span>
            </div>
            
            <div class="flex flex-col gap-3 flex-1 px-1">
                @foreach($boardTasks as $task)
                <div class="bg-white/95 backdrop-blur-sm border border-white/50 rounded-2xl px-5 py-4 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-300 group">
                    <div class="text-[13px] text-gray-800 font-bold mb-2">{{ $task->title }}</div>
                    <div class="flex justify-between items-center text-[#6D6257] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <div class="flex gap-2">
                            @if($index > 0)
                            <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $kanbanBoards[$index - 1]->name }}">
                                <button type="submit" class="hover:text-gray-800 transition" title="Move Left"><i class="far fa-arrow-alt-circle-left text-[18px]"></i></button>
                            </form>
                            @endif
                            
                            @if($index < count($kanbanBoards) - 1)
                            <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $kanbanBoards[$index + 1]->name }}">
                                <button type="submit" class="hover:text-gray-800 transition" title="Move Right"><i class="far fa-arrow-alt-circle-right text-[18px]"></i></button>
                            </form>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('kanban.destroy', $task->id) }}" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-red-600 transition" title="Delete"><i class="far fa-trash-alt text-[16px]"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
                
                <!-- New Task Form -->
                <div class="bg-white/90 border border-white/50 rounded-xl px-4 py-2.5 shadow-sm mt-auto mb-1 transition duration-200 hover:shadow-md focus-within:shadow-md">
                    <form method="POST" action="{{ route('kanban.store') }}" class="flex items-center">
                        @csrf
                        <input type="hidden" name="status" value="{{ $board->name }}">
                        <input type="text" name="title" placeholder="New Tasks" class="w-full text-[13px] font-bold text-gray-800 focus:outline-none placeholder-gray-400" required>
                    </form>
                </div>
            </div>

            <!-- Board Controls (Move & Delete) -->
            <div class="flex justify-between items-center mt-3 px-1 text-[#6D6257]">
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('kanban-boards.move', $board->id) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="direction" value="left">
                        <button type="submit" class="hover:text-gray-800 transition" title="Move Board Left"><i class="far fa-arrow-alt-circle-left text-[20px]"></i></button>
                    </form>
                    <form method="POST" action="{{ route('kanban-boards.move', $board->id) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="direction" value="right">
                        <button type="submit" class="hover:text-gray-800 transition" title="Move Board Right"><i class="far fa-arrow-alt-circle-right text-[20px]"></i></button>
                    </form>
                </div>
                <form method="POST" action="{{ route('kanban-boards.destroy', $board->id) }}" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hover:text-red-600 transition" title="Delete Board"><i class="far fa-trash-alt text-[20px]"></i></button>
                </form>
            </div>
        </div>
        @endforeach
        
    </div>

    <!-- Create New Board Button -->
    <div class="flex justify-center mt-8">
        <button onclick="document.getElementById('boardModal').classList.remove('hidden')" class="bg-gradient-to-br from-white to-[#FAF8F5] hover:scale-[1.02] text-[#867B6F] font-bold px-10 py-8 rounded-3xl transition-all duration-300 shadow-sm hover:shadow-xl w-full max-w-[400px] border border-white flex flex-col items-center justify-center gap-3 group">
            <div class="bg-[#F3EFEA] w-12 h-12 rounded-full flex items-center justify-center group-hover:bg-[#EAE4DD] transition">
                <i class="fas fa-plus text-xl text-[#BFA99C]"></i>
            </div>
            <span class="text-[15px] text-gray-600">Create a new board</span>
        </button>
    </div>
</div>

<!-- Add Board Modal -->
<div id="boardModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-[#F8F5F2]">
            <h3 class="font-bold text-gray-800">Add New Board</h3>
            <button onclick="document.getElementById('boardModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('kanban-boards.store') }}" class="p-6 flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Board Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#BCA99D]" required placeholder="e.g. In Review">
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="document.getElementById('boardModal').classList.add('hidden')" class="px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition duration-200">Cancel</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-[#BCA99D] to-[#A99587] hover:shadow-lg hover:-translate-y-0.5 rounded-xl transition duration-200 shadow-md">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
