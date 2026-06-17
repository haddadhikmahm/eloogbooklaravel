<!DOCTYPE html>
<html lang="en">
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
            background: linear-gradient(135deg, #fbfaf9 0%, #F1EBE6 100%);
            background-attachment: fixed;
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
            background: rgba(99, 102, 241, 0.4); 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.7); 
        }
        
        /* Animated Border Glow */
        @keyframes glowingBorder {
            0% { border-color: #818cf8; box-shadow: 0 0 5px rgba(129,140,248,0.2); }
            50% { border-color: #c084fc; box-shadow: 0 0 20px rgba(192,132,252,0.6); }
            100% { border-color: #818cf8; box-shadow: 0 0 5px rgba(129,140,248,0.2); }
        }
        .hover-glow {
            transition: all 0.3s ease;
        }
        .hover-glow:hover {
            animation: glowingBorder 2s infinite ease-in-out;
            z-index: 10;
        }

        /* Pagination Overrides for Unified Theme */
        nav[role="navigation"] span[aria-current="page"] > span {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: white !important;
        }
        nav[role="navigation"] a {
            transition: all 0.2s ease-in-out;
        }
        nav[role="navigation"] a:hover {
            color: #4f46e5 !important;
            border-color: #c7d2fe !important;
            background-color: #e0e7ff !important;
        }

        /* Collapsible Sidebar Styles */
        #sidebar.collapsed { width: 5.5rem !important; }
        #sidebar.collapsed .sidebar-text { display: none; }
        #sidebar.collapsed .sidebar-icon { margin-right: 0 !important; margin: 0 auto; display: block; text-align: center; font-size: 1.25rem; transition: all 0.3s; }
        #sidebar.collapsed a { justify-content: center; padding-left: 0; padding-right: 0; }
        #sidebar.collapsed .sidebar-section-title { display: none; }
        #sidebar.collapsed #projectDropdownWrapper { display: none; }
        #desktop-logo-area.collapsed { width: 5.5rem !important; padding-left: 0; padding-right: 0; justify-content: center; }
        #desktop-logo-area.collapsed .sidebar-text { display: none; }
        #sidebar { transition: width 0.3s ease-in-out, transform 0.3s ease-in-out; }
        #desktop-logo-area { transition: width 0.3s ease-in-out; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-gray-800">

    <div class="flex flex-col w-full h-full">
        <!-- Top Navbar -->
        <header class="h-16 bg-gradient-to-r from-slate-900 to-indigo-950 flex items-center justify-between shrink-0 shadow-md relative z-30">
            <!-- Left Area (Logo) - Matches Sidebar Width -->
            <div id="desktop-logo-area" class="w-64 flex items-center px-6 h-full hidden md:flex border-r border-white/10">
                <button id="desktop-menu-btn" class="text-white mr-4 p-2 focus:outline-none hover:bg-white/10 rounded-full transition-colors flex-shrink-0">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <img src="{{ asset('image.png') }}" alt="Logo BITA" class="h-10 object-contain sidebar-text">
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
                    @php
                        $activeProject = \App\Models\Project::find(session('active_project_id')) ?? \App\Models\Project::first();
                    @endphp
                    <div class="hidden sm:block bg-white/20 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap border border-white/20">
                        {{ $activeProject->type ?? 'Detailed Engineering Design' }}
                    </div>
                    <div class="relative w-full max-w-xs md:max-w-none hidden sm:block group z-50">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-white/60 group-focus-within:text-white text-sm transition-colors z-10"></i>
                        <input type="text" id="globalSearchInput" placeholder="Search everywhere..." class="w-full pl-10 pr-4 py-2 rounded-full bg-white/10 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm border border-transparent focus:border-white/30 placeholder-white/60 transition-all duration-300 backdrop-blur-sm relative" autocomplete="off">
                        
                        <!-- Autocomplete Dropdown -->
                        <div id="globalSearchDropdown" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden hidden z-50">
                            <div id="globalSearchResults" class="max-h-80 overflow-y-auto">
                                <!-- Results injected via JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification & Profile -->
                <div class="flex items-center gap-4 ml-auto">
                        <!-- Notification Bell -->
                        @php
                            $recentKanbans = \App\Models\KanbanTask::latest()->take(2)->get();
                            $recentRevisions = \App\Models\ClientRevision::latest()->take(2)->get();
                            $hasNotifications = $recentKanbans->count() > 0 || $recentRevisions->count() > 0;
                        @endphp
                        <div class="relative">
                            <button type="button" id="notifButton" class="text-white/80 hover:text-white relative transition p-1 focus:outline-none">
                                <i class="far fa-bell text-lg"></i>
                                @if($hasNotifications)
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div id="notifDropdown" class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg border border-gray-100 hidden z-50 overflow-hidden">
                                <div class="bg-gray-50 px-4 py-2 border-b border-gray-100">
                                    <h3 class="text-[11px] font-bold text-gray-700 uppercase tracking-wider">Recent Activity</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    @if(!$hasNotifications)
                                    <div class="p-4 text-center text-sm text-gray-500">No recent activity.</div>
                                    @else
                                        @foreach($recentKanbans as $kt)
                                        <a href="{{ route('dashboard.kanban', ['search' => $kt->title]) }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-indigo-50/50 transition cursor-pointer">
                                            <p class="text-[10px] text-gray-400 font-bold mb-0.5">KANBAN TASK</p>
                                            <p class="text-[13px] font-bold text-gray-800 line-clamp-2 leading-tight">{{ $kt->title }}</p>
                                            <p class="text-[10px] text-gray-500 mt-1">{{ $kt->created_at->diffForHumans() }}</p>
                                        </a>
                                        @endforeach
                                        @foreach($recentRevisions as $rr)
                                        <a href="{{ route('dashboard.logbook', ['search' => $rr->revision_code ?? $rr->description]) }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-rose-50/50 transition cursor-pointer">
                                            <p class="text-[10px] text-red-400 font-bold mb-0.5">CLIENT REVISION</p>
                                            <p class="text-[13px] font-bold text-gray-800 line-clamp-2 leading-tight">{{ $rr->description }}</p>
                                            <p class="text-[10px] text-gray-500 mt-1">{{ $rr->created_at->diffForHumans() }}</p>
                                        </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <div id="profileButton" class="flex items-center gap-3 bg-white/10 hover:bg-white/20 transition-colors duration-300 rounded-full py-1 pr-1 pl-4 cursor-pointer border border-white/10">
                                <div class="hidden md:block text-right">
                                    <p class="text-[13px] font-bold text-white leading-tight">{{ auth()->user()->name ?? 'Guest User' }}</p>
                                    <p class="text-[10px] text-gray-200">{{ auth()->user()->email ?? 'guest@eloogbook.com' }}</p>
                                </div>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Guest User') }}&background=4f46e5&color=fff&bold=true" alt="Profile" class="w-8 h-8 md:w-9 md:h-9 rounded-full object-cover border-2 border-white/50 shadow-sm">
                            </div>
                            
                            <!-- Profile Dropdown -->
                            <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 hidden z-50 overflow-hidden">
                                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#" onclick="confirmLogout(event)" class="flex items-center px-4 py-3 text-sm text-rose-500 hover:bg-rose-50 transition-colors font-medium">
                                        <i class="fas fa-sign-out-alt w-5 text-center mr-2"></i> Logout
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
            <aside id="sidebar" class="absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-300 ease-in-out w-64 bg-white/70 backdrop-blur-md flex flex-col shrink-0 border-r border-white/50 shadow-sm z-20 h-full">
                <div class="flex-1 overflow-y-auto py-5 custom-scrollbar">
                    
                    <!-- PROJECT Section -->
                    <div class="mb-6 px-3">
                        <p class="px-2 text-[10px] font-bold text-gray-400 tracking-widest mb-2 uppercase sidebar-section-title">Project</p>
                        <div id="projectDropdownWrapper" class="bg-white rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.05)] border border-indigo-100 overflow-hidden">
                            <button type="button" onclick="document.getElementById('projectDropdown').classList.toggle('hidden')" class="w-full flex items-center justify-between px-4 py-3 hover:bg-indigo-50/50 transition-colors duration-300 cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
                                    <span class="text-xs font-bold text-gray-800 truncate" style="max-width: 140px;" title="{{ $activeProject->name ?? 'No Project' }}">
                                        {{ $activeProject->name ?? 'No Project' }}
                                    </span>
                                </div>
                                <i class="fas fa-chevron-down text-indigo-400 text-xs transition-transform duration-300"></i>
                            </button>
                            <div id="projectDropdown" class="hidden bg-gray-50 border-t border-indigo-100">
                                @foreach(\App\Models\Project::all() as $p)
                                <a href="{{ route('projects.switch', $p->id) }}" class="block px-4 py-2.5 text-[11px] font-medium text-gray-600 border-b border-gray-200 hover:bg-indigo-100 hover:text-indigo-800 transition-colors duration-200 truncate" title="{{ $p->name }}">
                                    <span class="text-indigo-500 text-[9px] mr-1.5"><i class="fas fa-circle"></i></span> {{ $p->name }}
                                </a>
                                @endforeach
                                <button type="button" onclick="document.getElementById('newProjectModal').classList.remove('hidden')" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-[11px] font-bold text-white bg-indigo-500 hover:bg-indigo-600 transition-colors duration-200 focus:outline-none">
                                    <i class="fas fa-plus"></i> New Project
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- MAIN Section -->
                    <div class="mb-6 px-3">
                        <p class="px-2 text-[10px] font-bold text-gray-400 tracking-widest mb-2 uppercase sidebar-section-title">Main Menu</p>
                        <nav class="space-y-1.5">
                            <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-2.5 text-sm rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.index') ? 'font-bold text-indigo-700 bg-indigo-50 shadow-sm border border-indigo-100' : 'text-gray-500 hover:bg-indigo-50/50 hover:text-indigo-600' }}">
                                <i class="fas fa-th-large w-6 text-center {{ request()->routeIs('dashboard.index') ? 'text-indigo-600' : 'text-gray-400' }} mr-3 text-sm sidebar-icon"></i> <span class="sidebar-text">Dashboard</span>
                            </a>
                            <a href="{{ route('dashboard.sprint') }}" class="flex items-center px-4 py-2.5 text-sm rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.sprint') ? 'font-bold text-indigo-700 bg-indigo-50 shadow-sm border border-indigo-100' : 'text-gray-500 hover:bg-indigo-50/50 hover:text-indigo-600' }}">
                                <i class="fas fa-running w-6 text-center {{ request()->routeIs('dashboard.sprint') ? 'text-indigo-600' : 'text-gray-400' }} mr-3 text-sm sidebar-icon"></i> <span class="sidebar-text">Sprint</span>
                            </a>
                            <a href="{{ route('dashboard.kanban') }}" class="flex items-center px-4 py-2.5 text-sm rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.kanban') ? 'font-bold text-indigo-700 bg-indigo-50 shadow-sm border border-indigo-100' : 'text-gray-500 hover:bg-indigo-50/50 hover:text-indigo-600' }}">
                                <i class="fas fa-columns w-6 text-center {{ request()->routeIs('dashboard.kanban') ? 'text-indigo-600' : 'text-gray-400' }} mr-3 text-sm sidebar-icon"></i> <span class="sidebar-text">Kanban Board</span>
                            </a>
                            <a href="{{ route('dashboard.logbook') }}" class="flex items-center px-4 py-2.5 text-sm rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.logbook') ? 'font-bold text-indigo-700 bg-indigo-50 shadow-sm border border-indigo-100' : 'text-gray-500 hover:bg-indigo-50/50 hover:text-indigo-600' }}">
                                <i class="fas fa-list-alt w-6 text-center {{ request()->routeIs('dashboard.logbook') ? 'text-indigo-600' : 'text-gray-400' }} mr-3 text-sm sidebar-icon"></i> <span class="sidebar-text">Logbook Revision</span>
                            </a>
                        </nav>
                    </div>

                    <!-- REPORTS Section -->
                    <div class="px-3">
                        <p class="px-2 text-[10px] font-bold text-gray-400 tracking-widest mb-2 uppercase sidebar-section-title">Reports</p>
                        <nav class="space-y-1.5">
                            <a href="{{ route('dashboard.scurve') }}" class="flex items-center px-4 py-2.5 text-sm rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.scurve') ? 'font-bold text-indigo-700 bg-indigo-50 shadow-sm border border-indigo-100' : 'text-gray-500 hover:bg-indigo-50/50 hover:text-indigo-600' }}">
                                <i class="fas fa-chart-line w-6 text-center {{ request()->routeIs('dashboard.scurve') ? 'text-indigo-600' : 'text-gray-400' }} mr-3 text-sm sidebar-icon"></i> <span class="sidebar-text">S-Curve Progress</span>
                            </a>
                            <a href="{{ route('dashboard.team') }}" class="flex items-center px-4 py-2.5 text-sm rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.team') ? 'font-bold text-indigo-700 bg-indigo-50 shadow-sm border border-indigo-100' : 'text-gray-500 hover:bg-indigo-50/50 hover:text-indigo-600' }}">
                                <i class="fas fa-users w-6 text-center {{ request()->routeIs('dashboard.team') ? 'text-indigo-600' : 'text-gray-400' }} mr-3 text-sm sidebar-icon"></i> <span class="sidebar-text">Team & Discipline</span>
                            </a>
                            <a href="{{ route('dashboard.documents') }}" class="flex items-center px-4 py-2.5 text-sm rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.documents') ? 'font-bold text-indigo-700 bg-indigo-50 shadow-sm border border-indigo-100' : 'text-gray-500 hover:bg-indigo-50/50 hover:text-indigo-600' }}">
                                <i class="far fa-file-alt w-6 text-center {{ request()->routeIs('dashboard.documents') ? 'text-indigo-600' : 'text-gray-400' }} mr-3 text-sm sidebar-icon"></i> <span class="sidebar-text">Supporting Documents</span>
                            </a>
                        </nav>
                    </div>
                </div>

            </aside>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto bg-[#FCFBFA] custom-scrollbar w-full relative z-0 flex flex-col">
                
                @if(isset($activeProject) && !request()->routeIs('dashboard.sprint') && !request()->routeIs('dashboard.documents') && !request()->routeIs('dashboard.team') && !request()->routeIs('dashboard.scurve') && !request()->routeIs('dashboard.logbook') && !request()->routeIs('dashboard.index') && !request()->routeIs('dashboard.kanban'))
                <!-- Project Identity Card -->
                <div class="bg-white px-6 py-6 md:px-10 md:py-8 border-b border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] shrink-0">
                    <div class="flex items-start gap-5 max-w-[1200px] mx-auto">
                        <!-- Icon Box -->
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gray-50/80 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-inner">
                            <i class="fas fa-map-marked-alt text-2xl sm:text-3xl text-[#8E9EAC]"></i>
                        </div>
                        
                        <!-- Info Section -->
                        <div class="flex flex-col flex-1">
                            <div class="mb-2">
                                <span class="bg-indigo-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded shadow-sm tracking-wide">ACTIVE</span>
                            </div>
                            <h1 class="text-[18px] sm:text-[22px] font-extrabold text-[#112338] leading-tight mb-1.5">
                                {{ $activeProject->code ? $activeProject->code . ' - ' : '' }}{{ $activeProject->name }}
                            </h1>
                            <p class="text-[#72839A] text-[14px] sm:text-[15px] font-medium mb-3">
                                {{ $activeProject->type ?? 'Detailed Engineering Design' }}
                            </p>
                            
                            <div class="flex items-center gap-6 text-[#72839A] text-[13px] font-bold">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-layer-group text-[#AAB8C7] text-sm"></i>
                                    <span>{{ $activeProject->disciplines_count ?? 0 }} Disciplines</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user-friends text-[#AAB8C7] text-sm"></i>
                                    <span>{{ $activeProject->personnel_count ?? 0 }} Personnel</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="p-4 md:p-8 flex-1 w-full max-w-full">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Modal New Project -->
    <div id="newProjectModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden flex items-center justify-center transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] w-full max-w-md overflow-hidden transform transition-all">
            <div class="flex justify-between items-center p-6 border-b-2 border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg tracking-tight">Create New Project</h3>
                <button onclick="document.getElementById('newProjectModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="p-6">
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Project Name</label>
                        <input type="text" name="name" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" placeholder="e.g. DED Coal Terminal" required>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Project Type</label>
                        <input type="text" name="type" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" placeholder="e.g. Detailed Engineering Design" required>
                    </div>
                </div>
                <div class="p-6 border-t-2 border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('newProjectModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,70,229,0.4)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.6)] transform hover:-translate-y-0.5">Save Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script for Mobile Menu -->
    <script>
        function confirmLogout(e) {
            e.preventDefault();
            const form = e.target.closest('form') || document.getElementById('logoutForm');
            Swal.fire({
                title: 'Sign Out?',
                text: "Are you sure you want to log out of your account?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: '<i class="fas fa-sign-out-alt mr-1"></i> Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

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

            // Desktop Menu Toggle
            const desktopMenuBtn = document.getElementById('desktop-menu-btn');
            const desktopLogoArea = document.getElementById('desktop-logo-area');
            if(desktopMenuBtn) {
                desktopMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    desktopLogoArea.classList.toggle('collapsed');
                });
            }
            
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

            @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: '{!! addslashes($errors->first()) !!}'
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
    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global Search Logic
            const searchInput = document.getElementById('globalSearchInput');
            const searchDropdown = document.getElementById('globalSearchDropdown');
            const searchResults = document.getElementById('globalSearchResults');
            let searchTimeout;

            if(searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();
                    
                    if (query.length < 2) {
                        searchDropdown.classList.add('hidden');
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        fetch(`/api/global-search?q=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                searchResults.innerHTML = '';
                                if (data.length === 0) {
                                    searchResults.innerHTML = '<div class="p-5 text-center text-sm text-gray-500"><i class="fas fa-search mb-2 opacity-20 text-2xl block"></i>No results found</div>';
                                } else {
                                    data.forEach(item => {
                                        searchResults.innerHTML += `
                                            <a href="${item.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-50/50 transition border-b border-gray-50 last:border-0 cursor-pointer">
                                                <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0 border border-gray-200/50">
                                                    <i class="fas ${item.icon} ${item.color} text-[13px]"></i>
                                                </div>
                                                <div class="overflow-hidden">
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">${item.type}</p>
                                                    <p class="text-[13px] font-semibold text-gray-800 truncate">${item.title}</p>
                                                </div>
                                            </a>
                                        `;
                                    });
                                }
                                searchDropdown.classList.remove('hidden');
                            });
                    }, 300);
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                        searchDropdown.classList.add('hidden');
                    }
                });
            }

            // Notification Dropdown Logic
            const notifButton = document.getElementById('notifButton');
            const notifDropdown = document.getElementById('notifDropdown');
            if (notifButton && notifDropdown) {
                notifButton.addEventListener('click', function(e) {
                    notifDropdown.classList.toggle('hidden');
                    e.stopPropagation();
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!notifButton.contains(e.target) && !notifDropdown.contains(e.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                });
            }

            // Profile Dropdown Logic
            const profileButton = document.getElementById('profileButton');
            const profileDropdown = document.getElementById('profileDropdown');
            if (profileButton && profileDropdown) {
                profileButton.addEventListener('click', function(e) {
                    profileDropdown.classList.toggle('hidden');
                    e.stopPropagation();
                });
                
                document.addEventListener('click', function(e) {
                    if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
