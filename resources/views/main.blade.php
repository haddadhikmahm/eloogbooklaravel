@extends('app')

@section('content')
<div class="w-full max-w-[1200px] mx-auto pb-10">
    <!-- Top Header & Project Progress -->
    <div class="flex justify-between items-start mb-8 pt-2">
        <div>
            <h1 class="text-[36px] font-bold text-[#3D3A37] leading-tight mb-1 tracking-tight">Welcome, Kayla</h1>
            <p class="text-[13px] text-gray-500 font-medium">Fase {{ $project->type ?? 'Detailed Engineering Design' }} • {{ str_replace('DED ', '', $project->name ?? 'Coal Terminal') }}</p>
        </div>
        
        <div class="bg-white border border-[#E2DDD8] rounded-xl p-5 shadow-sm w-80">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold text-gray-800 text-[13px]">Penyelesaian Proyek</h3>
                <span class="font-bold text-gray-800 text-lg">{{ $project->completion_percentage ?? 56 }}%</span>
            </div>
            <div class="w-full bg-[#EBE6E0] h-2.5 rounded-full overflow-hidden">
                <div class="bg-[#867B6F] h-full rounded-full w-[{{ $project->completion_percentage ?? 56 }}%]"></div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <!-- Card 1 -->
        <div class="bg-white border border-[#E2DDD8] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-28">
            <div class="flex justify-between items-start">
                <i class="far fa-file-alt text-[#D39B8F] text-xl"></i>
            </div>
            <div>
                <p class="text-[28px] font-bold text-[#6D6257] leading-none mb-1">{{ number_format($totalDocuments) }}</p>
                <p class="text-[9px] font-bold text-gray-400 tracking-widest uppercase">TOTAL DOKUMEN</p>
            </div>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-white border border-[#E2DDD8] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-28">
            <div class="flex justify-between items-start">
                <i class="far fa-clipboard text-[#D39B8F] text-xl"></i>
            </div>
            <div>
                <p class="text-[28px] font-bold text-[#6D6257] leading-none mb-1">{{ number_format($waitingReview) }}</p>
                <p class="text-[9px] font-bold text-gray-400 tracking-widest uppercase">MENUNGGU TINJAUAN</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white border border-[#E2DDD8] rounded-2xl p-5 shadow-sm flex flex-col justify-between h-28">
            <div class="flex justify-between items-start">
                <i class="far fa-comments text-[#D39B8F] text-xl"></i>
            </div>
            <div>
                <p class="text-[28px] font-bold text-[#6D6257] leading-none mb-1">{{ number_format($openCommentsCount) }}</p>
                <p class="text-[9px] font-bold text-gray-400 tracking-widest uppercase">KOMENTAR TERBUKA</p>
            </div>
        </div>
    </div>

    <!-- Lower Section -->
    <div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-96">
        <!-- Progress per Disiplin & Comment Widget Area -->
        <div class="flex-1 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-[#3D3A37]">Progress per Disiplin</h2>
                <a href="{{ route('dashboard.scurve') }}" class="text-[11px] font-bold text-gray-500 hover:text-gray-800 transition">Lihat Detail</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 auto-rows-max h-fit">
                @forelse($disciplines as $disc)
                <div class="bg-white border border-[#E2DDD8] rounded-xl p-5 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold text-[#3D3A37] text-[13px]">{{ $disc->discipline }} <span class="text-gray-600 ml-1">{{ $disc->percentage }}%</span></h3>
                    </div>
                    <p class="text-[11px] text-gray-400 font-bold mb-3">{{ $disc->total_docs }} Dokumen</p>
                    <div class="w-full bg-[#EBE6E0] h-1.5 rounded-full overflow-hidden">
                        <div class="bg-[#867B6F] h-full rounded-full" style="width: {{ $disc->percentage }}%;"></div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-sm text-gray-500 py-4">Belum ada data progres sprint per disiplin.</div>
                @endforelse
            </div>
        </div>

        <!-- Comment Register Widget -->
        <div class="w-full lg:w-80">
            <div class="bg-white rounded-xl border border-[#E2DDD8] shadow-[0_4px_20px_rgba(0,0,0,0.05)] overflow-hidden h-full flex flex-col">
                <!-- Widget Header -->
                <div class="px-5 py-4 flex justify-between items-center border-b border-[#E2DDD8]">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-comment-dots text-[#6D6257]"></i>
                        <h3 class="font-bold text-[#3D3A37] text-[13px]">Comment Register</h3>
                    </div>
                    <a href="#" class="text-[10px] font-bold text-gray-500 hover:text-gray-800 flex items-center gap-1">
                        Semua <i class="fas fa-chevron-right text-[8px]"></i>
                    </a>
                </div>

                <!-- Comments List -->
                <div class="p-5 flex flex-col gap-4 overflow-y-auto flex-1">
                    @foreach($comments as $comment)
                    <div class="bg-[#F8F5F2] border border-[#E2DDD8] rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2 group">
                            <h4 class="text-[11px] font-bold text-gray-600">{{ $comment->document_code }}</h4>
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('comments.updateStatus', $comment->id) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $comment->status == 'OPEN' ? 'CLOSE' : 'OPEN' }}">
                                    <button type="submit" class="hover:opacity-80 transition" title="Toggle Status">
                                        @if($comment->status == 'OPEN')
                                        <span class="bg-[#FFE0E0] text-[#D32F2F] text-[9px] font-bold px-2 py-0.5 rounded border border-red-200">OPEN</span>
                                        @else
                                        <span class="bg-[#E6F4EA] text-[#1E8E3E] text-[9px] font-bold px-2 py-0.5 rounded border border-green-200">CLOSE</span>
                                        @endif
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="inline opacity-0 group-hover:opacity-100 transition-opacity delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Delete Comment">
                                        <i class="far fa-trash-alt text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-[11px] text-gray-800 mb-3 leading-relaxed">
                            {{ $comment->text }}
                        </p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full {{ $comment->status == 'OPEN' ? 'bg-[#E8DFD5] text-[#867B6F]' : 'bg-[#D4E2D4] text-[#4A7C4A]' }} flex items-center justify-center text-[8px] font-bold">{{ $comment->author_initials }}</div>
                                <span class="text-[10px] font-semibold text-gray-700">{{ $comment->author_name }}</span>
                            </div>
                            <span class="text-[9px] font-semibold text-gray-400">{{ \Carbon\Carbon::parse($comment->date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Widget Footer (Add Comment) -->
                <div class="border-t border-[#E2DDD8] p-3 bg-[#FCFBFA]">
                    <form method="POST" action="{{ route('comments.store') }}" class="flex flex-col gap-2">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="document_code" placeholder="Doc Code..." class="w-1/3 border border-[#E2DDD8] rounded px-2 py-1.5 text-[10px] focus:outline-none focus:ring-1 focus:ring-[#A6998A]" required>
                            <input type="text" name="text" placeholder="Add a comment..." class="flex-1 border border-[#E2DDD8] rounded px-2 py-1.5 text-[10px] focus:outline-none focus:ring-1 focus:ring-[#A6998A]" required>
                            <button type="submit" class="bg-[#A6998A] hover:bg-[#8C7D6D] text-white px-2.5 py-1.5 rounded transition">
                                <i class="fas fa-paper-plane text-[10px]"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
