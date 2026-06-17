@extends('app')

@section('content')
<div class="w-full pb-10">
    <!-- Top Header & Project Progress -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-start mb-6 pt-2 gap-6">
        <div>
            <h1 class="text-[28px] sm:text-[32px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 tracking-tight mb-2">Welcome, Kayla</h1>
            <p class="text-gray-500 font-medium">Phase {{ $project->type ?? 'Detailed Engineering Design' }} • {{ str_replace('DED ', '', $project->name ?? 'Coal Terminal') }}</p>
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

    <!-- Progress Card Separated -->
    <div class="flex justify-end mb-8">
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 border-2 border-indigo-400/50 rounded-[20px] p-6 shadow-[0_8px_30px_rgba(79,70,229,0.3)] hover:shadow-[0_12px_40px_rgba(79,70,229,0.4)] transition-shadow duration-300 w-full sm:w-80 relative overflow-hidden group hover-glow">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-bl-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-white/90 text-[13px] tracking-wide">Project Completion</h3>
                    <span class="font-bold text-white text-2xl">{{ $project->completion_percentage ?? 56 }}%</span>
                </div>
                <div class="w-full bg-black/20 h-2.5 rounded-full overflow-hidden backdrop-blur-sm">
                    <div class="bg-gradient-to-r from-emerald-400 to-teal-300 h-full rounded-full relative shadow-[0_0_10px_rgba(52,211,153,0.5)]" style="width: {{ $project->completion_percentage ?? 56 }}%">
                        <div class="absolute inset-0 bg-white/30 w-full h-full animate-[shimmer_2s_infinite]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 border-2 border-emerald-300/50 rounded-[20px] p-6 shadow-[0_8px_25px_rgba(16,185,129,0.3)] hover:shadow-[0_15px_35px_rgba(16,185,129,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-36 relative overflow-hidden group hover-glow">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700 blur-2xl"></div>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-inner">
                    <i class="far fa-file-alt text-white text-xl"></i>
                </div>
            </div>
            <div class="relative z-10 mt-2">
                <p class="text-[36px] font-extrabold text-white leading-none mb-1">{{ number_format($totalDocuments) }}</p>
                <p class="text-[10px] font-bold text-emerald-100 tracking-widest uppercase">Total Documents</p>
            </div>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 border-2 border-amber-300/50 rounded-[20px] p-6 shadow-[0_8px_25px_rgba(245,158,11,0.3)] hover:shadow-[0_15px_35px_rgba(245,158,11,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-36 relative overflow-hidden group hover-glow">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700 blur-2xl"></div>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-inner">
                    <i class="far fa-clipboard text-white text-xl"></i>
                </div>
            </div>
            <div class="relative z-10 mt-2">
                <p class="text-[36px] font-extrabold text-white leading-none mb-1">{{ number_format($waitingReview) }}</p>
                <p class="text-[10px] font-bold text-amber-100 tracking-widest uppercase">Awaiting Review</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-gradient-to-br from-rose-500 to-pink-600 border-2 border-rose-300/50 rounded-[20px] p-6 shadow-[0_8px_25px_rgba(244,63,94,0.3)] hover:shadow-[0_15px_35px_rgba(244,63,94,0.4)] transform hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-36 relative overflow-hidden group hover-glow">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700 blur-2xl"></div>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-inner">
                    <i class="far fa-comments text-white text-xl"></i>
                </div>
            </div>
            <div class="relative z-10 mt-2">
                <p class="text-[36px] font-extrabold text-white leading-none mb-1">{{ number_format($openCommentsCount) }}</p>
                <p class="text-[10px] font-bold text-rose-100 tracking-widest uppercase">Open Comments</p>
            </div>
        </div>
    </div>

    <!-- Lower Section -->
    <div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-96">
        <!-- Progress per Disiplin & Comment Widget Area -->
        <div class="flex-1 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Progress per Discipline</h2>
                <a href="{{ route('dashboard.scurve') }}" class="text-[11px] font-bold text-gray-400 hover:text-gray-600 transition-colors flex items-center gap-1 group">
                    View Details <i class="fas fa-arrow-right text-[9px] transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 auto-rows-max h-fit">
                @forelse($disciplines as $disc)
                <div class="bg-white border-2 border-gray-200 rounded-[20px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] transition-all duration-300 group hover-glow">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-bold text-gray-700 text-[13px] tracking-wide">{{ $disc->discipline }}</h3>
                        <span class="text-gray-800 font-bold bg-gray-100 px-2 py-0.5 rounded-md text-xs">{{ $disc->percentage }}%</span>
                    </div>
                    <p class="text-[11px] text-gray-400 font-bold mb-4 flex items-center gap-1"><i class="far fa-file-alt"></i> {{ $disc->total_docs }} Documents</p>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden border border-gray-200 shadow-inner">
                        <div class="bg-gradient-to-r from-indigo-400 to-blue-500 h-full rounded-full transition-all duration-1000 ease-out shadow-[0_0_8px_rgba(99,102,241,0.5)]" style="width: {{ $disc->percentage }}%;"></div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-sm text-gray-500 py-4 text-center bg-white rounded-[20px] border border-dashed border-gray-300">No sprint progress data per discipline yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Comment Register Widget -->
        <div class="w-full lg:w-[350px]">
            <div class="bg-white rounded-[24px] border-2 border-gray-200 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden h-full flex flex-col hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] transition-all duration-300 hover-glow">
                <!-- Widget Header -->
                <div class="px-6 py-5 flex justify-between items-center border-b-2 border-gray-200 bg-gradient-to-r from-white to-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center">
                            <i class="fas fa-comment-dots text-indigo-400"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 text-[14px]">Comment Register</h3>
                    </div>
                    <a href="{{ route('dashboard.comments') }}" class="text-[10px] font-bold text-indigo-400 hover:text-indigo-600 flex items-center gap-1 group transition-colors">
                        View All <i class="fas fa-chevron-right text-[8px] transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Comments List -->
                <div class="p-6 flex flex-col gap-4 overflow-y-auto flex-1 custom-scrollbar">
                    @foreach($comments as $comment)
                    <div class="bg-white border-2 border-gray-200 rounded-2xl p-4 hover:shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 group hover-glow">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-[11px] font-bold text-gray-700 bg-gray-100 px-2 py-1 rounded-md">{{ $comment->document_code }}</h4>
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('comments.updateStatus', $comment->id) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $comment->status == 'OPEN' ? 'CLOSE' : 'OPEN' }}">
                                    <button type="submit" class="hover:opacity-80 transition transform hover:scale-105" title="Toggle Status">
                                        @if($comment->status == 'OPEN')
                                        <span class="bg-rose-50 text-rose-500 text-[9px] font-bold px-2.5 py-1 rounded-full border border-rose-200 shadow-sm">OPEN</span>
                                        @else
                                        <span class="bg-emerald-50 text-emerald-600 text-[9px] font-bold px-2.5 py-1 rounded-full border border-emerald-200 shadow-sm">CLOSE</span>
                                        @endif
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="inline opacity-0 group-hover:opacity-100 transition-opacity duration-300 delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 hover:bg-red-50 p-1 rounded transition" title="Delete Comment">
                                        <i class="far fa-trash-alt text-[11px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-[12px] text-gray-600 mb-4 leading-relaxed pl-1">
                            {{ $comment->text }}
                        </p>
                        <div class="flex justify-between items-center pl-1">
                            <div class="flex items-center gap-2.5">
                                <div class="w-6 h-6 rounded-full {{ $comment->status == 'OPEN' ? 'bg-indigo-100 text-indigo-600' : 'bg-emerald-100 text-emerald-600' }} flex items-center justify-center text-[9px] font-bold shadow-sm">{{ $comment->author_initials }}</div>
                                <span class="text-[11px] font-semibold text-gray-700">{{ $comment->author_name }}</span>
                            </div>
                            <span class="text-[10px] font-semibold text-gray-400">{{ \Carbon\Carbon::parse($comment->date)->format('d F Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Widget Footer (Add Comment) -->
                <div class="p-5 border-t-2 border-gray-200 bg-gradient-to-b from-white to-gray-50">
                    <form method="POST" action="{{ route('comments.store') }}" class="flex flex-col gap-2 relative">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="document_code" placeholder="Doc Code" class="w-24 border border-gray-200 rounded-xl px-3 py-2.5 text-[11px] focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-transparent transition-all shadow-sm" required>
                            <div class="flex-1 relative">
                                <input type="text" name="text" placeholder="Add a comment..." class="w-full border border-gray-200 rounded-xl pl-3 pr-10 py-2.5 text-[11px] focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-transparent transition-all shadow-sm" required>
                                <button type="submit" class="absolute right-1.5 top-1/2 transform -translate-y-1/2 w-7 h-7 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg flex items-center justify-center transition-colors shadow-sm">
                                    <i class="fas fa-paper-plane text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
