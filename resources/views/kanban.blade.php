@extends('app')

@section('content')
<div class="max-w-[1200px] w-full mx-auto pb-10">
    <!-- Header -->
    <div class="mb-8 text-center pt-2">
        <h1 class="text-[28px] font-bold text-[#6D6257]">Kanban Board</h1>
    </div>

    @php
        $todoTasks = $tasks->where('status', 'To Do');
        $inProgressTasks = $tasks->where('status', 'In Progress');
        $doneTasks = $tasks->where('status', 'Done');
        $waitingTasks = $tasks->where('status', 'Waiting Client');
    @endphp

    <!-- Kanban Horizontal Container -->
    <div class="flex flex-row overflow-x-auto gap-6 pb-6 custom-scrollbar min-h-[400px]">
        
        <!-- To Do Column -->
        <div class="bg-[#BFA99C] w-[360px] rounded-md p-4 shadow-sm flex flex-col">
            <div class="flex items-center justify-center gap-2 mb-4 mt-2">
                <h2 class="text-xl font-bold text-[#6D6257]">To Do</h2>
                <span class="text-sm font-bold text-[#6D6257]">{{ $todoTasks->count() }}</span>
            </div>
            
            <div class="flex flex-col gap-3 flex-1 px-1">
                @foreach($todoTasks as $task)
                <div class="bg-white rounded-sm px-4 py-2.5 shadow-sm group">
                    <div class="text-[13px] text-gray-800 font-bold mb-2">{{ $task->title }}</div>
                    <div class="flex justify-between items-center text-[#6D6257] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="In Progress">
                            <button type="submit" class="hover:text-gray-800 transition" title="Move to In Progress"><i class="far fa-arrow-alt-circle-right text-[18px]"></i></button>
                        </form>
                        <form method="POST" action="{{ route('kanban.destroy', $task->id) }}" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-red-600 transition" title="Delete"><i class="far fa-trash-alt text-[16px]"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
                <div class="bg-white rounded-sm px-4 py-2.5 shadow-sm mt-auto mb-1">
                    <form method="POST" action="{{ route('kanban.store') }}" class="flex items-center">
                        @csrf
                        <input type="text" name="title" placeholder="+ New Task" class="w-full text-[13px] font-bold text-gray-800 focus:outline-none placeholder-gray-400" required>
                    </form>
                </div>
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="bg-[#BFA99C] w-[360px] rounded-md p-4 shadow-sm flex flex-col">
            <div class="flex items-center justify-center gap-2 mb-4 mt-2">
                <h2 class="text-xl font-bold text-[#6D6257]">In Progress</h2>
                <span class="text-sm font-bold text-[#6D6257]">{{ $inProgressTasks->count() }}</span>
            </div>
            
            <div class="flex flex-col gap-3 flex-1 px-1">
                @foreach($inProgressTasks as $task)
                <div class="bg-white rounded-sm px-4 py-2.5 shadow-sm group">
                    <div class="text-[13px] text-gray-800 font-bold mb-2">{{ $task->title }}</div>
                    <div class="flex justify-between items-center text-[#6D6257] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="To Do">
                                <button type="submit" class="hover:text-gray-800 transition" title="Move to To Do"><i class="far fa-arrow-alt-circle-left text-[18px]"></i></button>
                            </form>
                            <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Done">
                                <button type="submit" class="hover:text-gray-800 transition" title="Move to Done"><i class="far fa-arrow-alt-circle-right text-[18px]"></i></button>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('kanban.destroy', $task->id) }}" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-red-600 transition" title="Delete"><i class="far fa-trash-alt text-[16px]"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Done Column -->
        <div class="bg-[#BFA99C] w-[360px] rounded-md p-4 shadow-sm flex flex-col">
            <div class="flex items-center justify-center gap-2 mb-4 mt-2">
                <h2 class="text-xl font-bold text-[#6D6257]">Done</h2>
                <span class="text-sm font-bold text-[#6D6257]">{{ $doneTasks->count() }}</span>
            </div>
            
            <div class="flex flex-col gap-3 flex-1 px-1">
                @foreach($doneTasks as $task)
                <div class="bg-white rounded-sm px-4 py-2.5 shadow-sm group">
                    <div class="text-[13px] text-gray-800 font-bold mb-2">{{ $task->title }}</div>
                    <div class="flex justify-between items-center text-[#6D6257] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="In Progress">
                                <button type="submit" class="hover:text-gray-800 transition" title="Move to In Progress"><i class="far fa-arrow-alt-circle-left text-[18px]"></i></button>
                            </form>
                            <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Waiting Client">
                                <button type="submit" class="hover:text-gray-800 transition" title="Move to Waiting Client"><i class="far fa-arrow-alt-circle-right text-[18px]"></i></button>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('kanban.destroy', $task->id) }}" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-red-600 transition" title="Delete"><i class="far fa-trash-alt text-[16px]"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Waiting Client Column -->
        <div class="bg-[#BFA99C] w-[360px] rounded-md p-4 shadow-sm flex flex-col">
            <div class="flex items-center justify-center gap-2 mb-4 mt-2">
                <h2 class="text-xl font-bold text-[#6D6257]">Waiting Client</h2>
                <span class="text-sm font-bold text-[#6D6257]">{{ $waitingTasks->count() }}</span>
            </div>
            
            <div class="flex flex-col gap-3 flex-1 px-1">
                @foreach($waitingTasks as $task)
                <div class="bg-white rounded-sm px-4 py-2.5 shadow-sm group">
                    <div class="text-[13px] text-gray-800 font-bold mb-2">{{ $task->title }}</div>
                    <div class="flex justify-between items-center text-[#6D6257] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <form method="POST" action="{{ route('kanban.updateStatus', $task->id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Done">
                            <button type="submit" class="hover:text-gray-800 transition" title="Move to Done"><i class="far fa-arrow-alt-circle-left text-[18px]"></i></button>
                        </form>
                        <form method="POST" action="{{ route('kanban.destroy', $task->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-red-600 transition" title="Delete"><i class="far fa-trash-alt text-[16px]"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
    </div>
</div>
@endsection
