<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fbfaf9;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent; 
        }
        ::-webkit-scrollbar-thumb {
            background: #d6ccc2; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #bcaaa4; 
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    <div class="flex flex-col w-full h-full">
        <!-- Top Navbar -->
        <header class="h-16 bg-[#867B6F] flex items-center justify-between shrink-0 shadow-sm relative z-30">
            <!-- Left Area (Logo) - Matches Sidebar Width -->
            <div class="w-64 flex items-center px-6 h-full hidden md:flex border-r border-white/10">
                <img src="{{ asset('image.png') }}" alt="Logo BITA" class="h-10 object-contain">
            </div>
            
            <!-- Mobile Menu Button & Logo -->
            <div class="flex md:hidden items-center px-4 h-full">
                <button id="mobile-menu-btn" class="text-white mr-4 p-2 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <img src="{{ asset('image.png') }}" alt="Logo BITA" class="h-8 object-contain">
            </div>
            
            <!-- Right Area -->
            <div class="flex-1 flex items-center justify-between px-4 md:px-6 h-full">
                <div class="flex items-center gap-4 md:gap-6 w-full max-w-2xl">
                    <div class="hidden sm:block bg-[#F8F5F2] text-gray-700 px-4 py-1.5 rounded text-sm font-medium whitespace-nowrap shadow-sm">
                        {{ \App\Models\Project::first()->type ?? 'Detailed Engineering Design' }}
                    </div>
                    <form method="GET" action="{{ route('dashboard.kanban') }}" class="relative w-full max-w-xs md:max-w-none hidden sm:block">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks.." class="w-full pl-9 pr-4 py-2 rounded bg-[#F8F5F2] text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#CBB964] shadow-inner placeholder-gray-400">
                    </form>
                </div>

                <!-- Notification & Profile -->
                <div class="flex items-center gap-4 border-l border-gray-200 pl-4 md:pl-5 ml-auto">
                        <div class="text-gray-400 relative">
                            <i class="far fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-3 focus:outline-none">
                                <div class="hidden md:block text-right">
                                    <p class="text-[13px] font-bold text-gray-800">{{ auth()->user()->name ?? 'Guest User' }}</p>
                                    <p class="text-[10px] text-gray-500">{{ auth()->user()->email ?? 'guest@eloogbook.com' }}</p>
                                </div>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Guest User') }}&background=AF8C64&color=fff&bold=true" alt="Profile" class="w-8 h-8 md:w-9 md:h-9 rounded-full object-cover shadow-sm">
                                <i class="fas fa-chevron-down text-gray-400 text-xs ml-1 hidden md:block"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100 hidden group-hover:block z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50 transition">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </header>

        <!-- Main Layout -->
        <div class="flex flex-1 overflow-hidden relative">
            
            <!-- Mobile Overlay -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden transition-opacity opacity-0"></div>

            <!-- Sidebar -->
            <aside id="sidebar" class="absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-300 ease-in-out w-64 bg-[#F8F5F2] flex flex-col shrink-0 border-r border-[#E2DDD8] z-20 h-full">
                <div class="flex-1 overflow-y-auto py-5 custom-scrollbar">
                    
                    <!-- PROJECT Section -->
                    <div class="mb-6">
                        <p class="px-5 text-[11px] font-bold text-gray-500 tracking-wider mb-2">PROJECT</p>
                        <div class="px-5">
                            <div class="bg-[#D3C9BE] rounded shadow-sm border border-[#C5B9AE] overflow-hidden">
                                <button type="button" onclick="document.getElementById('projectDropdown').classList.toggle('hidden')" class="w-full flex items-center justify-between px-3 py-2 hover:bg-[#C5B9AE] transition cursor-pointer">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-gray-600"></div>
                                        <span class="text-xs font-semibold text-gray-800 truncate" style="max-width: 140px;" title="{{ \App\Models\Project::first()->name ?? 'No Project' }}">
                                            {{ \App\Models\Project::first()->name ?? 'No Project' }}
                                        </span>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-600 text-xs"></i>
                                </button>
                                <div id="projectDropdown" class="hidden bg-[#F8F5F2] border-t border-[#C5B9AE]">
                                    @foreach(\App\Models\Project::all() as $p)
                                    <a href="#" class="block px-3 py-1.5 text-[11px] text-gray-600 border-b border-[#E2DDD8] hover:bg-[#EAE4DD] hover:text-gray-800 transition">
                                        <span class="text-gray-400 text-xs mr-1">♦</span> {{ $p->name }}
                                    </a>
                                    @endforeach
                                    <a href="#" class="block px-3 py-2 text-[11px] font-bold text-[#867B6F] hover:text-gray-800 hover:bg-[#EAE4DD] transition text-center">
                                        + New Project
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- UTAMA Section -->
                    <div class="mb-6">
                        <p class="px-5 text-[11px] font-bold text-gray-500 tracking-wider mb-2">UTAMA</p>
                        <nav>
                            <a href="{{ route('dashboard.index') }}" class="flex items-center px-5 py-2.5 text-sm {{ request()->routeIs('dashboard.index') ? 'font-semibold text-gray-800 bg-[#E8DFD5] border-l-4 border-[#A3978B] shadow-inner' : 'text-gray-600 hover:bg-[#EAE4DD] hover:text-gray-800 transition' }}">
                                <i class="fas fa-th-large w-6 text-center {{ request()->routeIs('dashboard.index') ? 'text-gray-600' : 'text-gray-500' }} mr-2 text-sm"></i> Dashboard
                            </a>
                            <a href="{{ route('dashboard.sprint') }}" class="flex items-center px-5 py-2.5 text-sm {{ request()->routeIs('dashboard.sprint') ? 'font-semibold text-gray-800 bg-[#E8DFD5] border-l-4 border-[#A3978B] shadow-inner' : 'text-gray-600 hover:bg-[#EAE4DD] hover:text-gray-800 transition' }}">
                                <i class="fas fa-running w-6 text-center {{ request()->routeIs('dashboard.sprint') ? 'text-gray-600' : 'text-gray-500' }} mr-2 text-sm"></i> Sprint
                            </a>
                            <a href="{{ route('dashboard.kanban') }}" class="flex items-center px-5 py-2.5 text-sm {{ request()->routeIs('dashboard.kanban') ? 'font-semibold text-gray-800 bg-[#E8DFD5] border-l-4 border-[#A3978B] shadow-inner' : 'text-gray-600 hover:bg-[#EAE4DD] hover:text-gray-800 transition' }}">
                                <i class="fas fa-columns w-6 text-center {{ request()->routeIs('dashboard.kanban') ? 'text-gray-600' : 'text-gray-500' }} mr-2 text-sm"></i> Kanban Board
                            </a>
                            <a href="{{ route('dashboard.logbook') }}" class="flex items-center px-5 py-2.5 text-sm {{ request()->routeIs('dashboard.logbook') ? 'font-semibold text-gray-800 bg-[#E8DFD5] border-l-4 border-[#A3978B] shadow-inner' : 'text-gray-600 hover:bg-[#EAE4DD] hover:text-gray-800 transition' }}">
                                <i class="fas fa-list-alt w-6 text-center {{ request()->routeIs('dashboard.logbook') ? 'text-gray-600' : 'text-gray-500' }} mr-2 text-sm"></i> Logbook Revision
                            </a>
                        </nav>
                    </div>

                    <!-- LAPORAN Section -->
                    <div>
                        <p class="px-5 text-[11px] font-bold text-gray-500 tracking-wider mb-2">LAPORAN</p>
                        <nav>
                            <a href="{{ route('dashboard.scurve') }}" class="flex items-center px-5 py-2.5 text-sm {{ request()->routeIs('dashboard.scurve') ? 'font-semibold text-gray-800 bg-[#E8DFD5] border-l-4 border-[#A3978B] shadow-inner' : 'text-gray-600 hover:bg-[#EAE4DD] hover:text-gray-800 transition' }}">
                                <i class="fas fa-chart-line w-6 text-center {{ request()->routeIs('dashboard.scurve') ? 'text-gray-600' : 'text-gray-500' }} mr-2 text-sm"></i> S-Curve Progress
                            </a>
                            <a href="{{ route('dashboard.team') }}" class="flex items-center px-5 py-2.5 text-sm {{ request()->routeIs('dashboard.team') ? 'font-semibold text-gray-800 bg-[#E8DFD5] border-l-4 border-[#A3978B] shadow-inner' : 'text-gray-600 hover:bg-[#EAE4DD] hover:text-gray-800 transition' }}">
                                <i class="fas fa-users w-6 text-center {{ request()->routeIs('dashboard.team') ? 'text-gray-600' : 'text-gray-500' }} mr-2 text-sm"></i> Team & Discipline
                            </a>
                            <a href="{{ route('dashboard.documents') }}" class="flex items-center px-5 py-2.5 text-sm {{ request()->routeIs('dashboard.documents') ? 'font-semibold text-gray-800 bg-[#E8DFD5] border-l-4 border-[#A3978B] shadow-inner' : 'text-gray-600 hover:bg-[#EAE4DD] hover:text-gray-800 transition' }}">
                                <i class="far fa-file-alt w-6 text-center {{ request()->routeIs('dashboard.documents') ? 'text-gray-600' : 'text-gray-500' }} mr-2 text-sm"></i> Supporting Documents
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Bottom Actions -->
                <div class="bg-[#867B6F] text-white/90">
                    <div class="flex items-center px-5 py-3 text-sm opacity-50 cursor-not-allowed">
                        <i class="far fa-question-circle w-6 text-center mr-2"></i> Help Center
                    </div>
                </div>
            </aside>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto bg-[#FCFBFA] p-4 md:p-8 custom-scrollbar w-full relative z-0">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleMenu() {
                if (sidebar.classList.contains('-translate-x-full')) {
                    // Open
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    // Add slight delay for opacity transition
                    setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                } else {
                    // Close
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }
            }

            btn.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);
            
            // SweetAlert2 Toast configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Flash Messages
            @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
            @endif

            @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
            @endif

            // Global Delete Confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#BCA99D',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
