@extends('app')

@section('content')
<div class="w-full pb-10">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-start mb-6 pt-2 gap-6">
        <div>
            <h1 class="text-[28px] sm:text-[32px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 tracking-tight mb-2">Comment Register</h1>
            <p class="text-gray-500 font-medium">Manage and view all comments across your project documents.</p>
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

    <!-- Stat Cards Area -->
    <div class="flex flex-wrap justify-end gap-4 mb-8">
        <!-- Stat Cards -->
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 border-2 border-indigo-300/50 rounded-3xl p-5 w-36 shadow-[0_8px_25px_rgba(79,70,229,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(79,70,229,0.4)] transition-all duration-300 group relative overflow-hidden hover-glow">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-inner relative z-10">
                <i class="fas fa-comments text-white text-lg"></i>
            </div>
            <p class="text-[32px] font-bold text-white leading-none mb-1 relative z-10">{{ $totalCommentsCount ?? 0 }}</p>
            <p class="text-xs font-bold text-indigo-100 uppercase tracking-wider relative z-10">Total</p>
        </div>
        
        <div class="bg-gradient-to-br from-amber-400 to-orange-500 border-2 border-amber-300/50 rounded-3xl p-5 w-36 shadow-[0_8px_25px_rgba(245,158,11,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(245,158,11,0.4)] transition-all duration-300 group relative overflow-hidden hover-glow">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-inner relative z-10">
                <i class="far fa-comment-dots text-white text-lg"></i>
            </div>
            <p class="text-[32px] font-bold text-white leading-none mb-1 relative z-10">{{ $openCommentsCount ?? 0 }}</p>
            <p class="text-xs font-bold text-amber-100 uppercase tracking-wider relative z-10">Open</p>
        </div>
        
        <div class="bg-gradient-to-br from-emerald-400 to-teal-500 border-2 border-emerald-300/50 rounded-3xl p-5 w-36 shadow-[0_8px_25px_rgba(16,185,129,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(16,185,129,0.4)] transition-all duration-300 group relative overflow-hidden hover-glow">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-inner relative z-10">
                <i class="far fa-check-circle text-white text-lg"></i>
            </div>
            <p class="text-[32px] font-bold text-white leading-none mb-1 relative z-10">{{ $closedCommentsCount ?? 0 }}</p>
            <p class="text-xs font-bold text-emerald-100 uppercase tracking-wider relative z-10">Close</p>
        </div>
    </div>

    <!-- Actions Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-end mb-8 gap-4">
        <div>
            <button onclick="document.getElementById('commentModal').classList.remove('hidden')" class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold px-6 py-3 rounded-2xl shadow-[0_8px_20px_rgba(79,70,229,0.3)] hover:shadow-[0_12px_25px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3 group">
                <div class="bg-white/20 rounded-full w-6 h-6 flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <i class="fas fa-plus text-sm"></i>
                </div>
                Add Comment
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white border-2 border-gray-200 rounded-[20px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] overflow-hidden hover-glow mb-8">
        <!-- Table Header Bar -->
        <div class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 px-6 py-4 border-b-2 border-gray-200">
            <h3 class="font-bold text-indigo-900 text-[14px]">All Comments</h3>
        </div>
        
        <div class="p-6 pb-2">
            <!-- Top Actions Bar -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-indigo-900 text-[15px] font-bold tracking-wide">Comments Data</h2>
                
                <form method="GET" action="{{ route('dashboard.comments') }}" class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search comments..." class="border border-gray-200 rounded-full px-4 pl-10 py-2.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-transparent transition-all shadow-sm" oninput="clearTimeout(this.timer); this.timer = setTimeout(() => { this.form.submit(); }, 600);" {{ request('search') ? 'autofocus onfocus=this.setSelectionRange(this.value.length,this.value.length)' : '' }}>
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 border-b-2 border-gray-200">
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-36">Date</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-40">Document Code</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center">Comment</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-32">Author</th>
                        <th class="py-5 px-6 font-bold text-gray-700 text-sm text-center w-36">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-gray-100">
                    @forelse($commentsList as $comment)
                    <tr class="hover:bg-[#FCFAFC] transition-all duration-300">
                        <td class="py-4 px-6 text-xs font-semibold text-gray-600 text-center">{{ \Carbon\Carbon::parse($comment->date)->format('Y-m-d') }}</td>
                        <td class="py-4 px-6 text-xs font-bold text-indigo-600 text-center">{{ $comment->document_code }}</td>
                        <td class="py-4 px-6 text-xs text-gray-600 leading-relaxed max-w-sm truncate whitespace-normal" title="{{ $comment->text }}">{{ $comment->text }}</td>
                        <td class="py-4 px-6 text-xs font-semibold text-gray-800 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-[10px] font-bold">
                                    {{ $comment->author_initials }}
                                </div>
                                <span>{{ $comment->author_name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form method="POST" action="{{ route('comments.updateStatus', $comment->id) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ strtoupper($comment->status) == 'OPEN' ? 'CLOSE' : 'OPEN' }}">
                                    <button type="submit" title="Toggle Status" class="inline-block {{ strtoupper($comment->status) == 'OPEN' ? 'bg-amber-100 text-amber-700 border-amber-300 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-700 border-emerald-300 hover:bg-emerald-200' }} px-5 py-1.5 rounded text-xs font-bold shadow-sm border transition-colors">
                                        {{ strtoupper($comment->status) }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Delete"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500 font-medium">No comments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 mt-2 custom-pagination">
                {{ $commentsList->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form Create Comment -->
    <div id="commentModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 w-full max-w-lg p-6 relative">
            <button onclick="document.getElementById('commentModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h2 class="text-xl font-bold text-gray-800 mb-5">Add New Comment</h2>
            <form method="POST" action="{{ route('comments.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Document Code</label>
                    <input type="text" name="document_code" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="e.g. 1234-DRW-567" required>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Author Name</label>
                        <input type="text" name="author_name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" required>
                            <option value="OPEN">OPEN</option>
                            <option value="CLOSE">CLOSE</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Comment Text</label>
                    <textarea name="text" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="Enter comment..." required></textarea>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold px-8 py-2.5 rounded-xl shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_8px_20px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition duration-300">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
