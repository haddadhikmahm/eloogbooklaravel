<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Logbook Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FCFBFA;
        }
    </style>
</head>
<body class="h-screen w-full flex overflow-hidden">

    <!-- Left Gradient Background (Following App Template) -->
    <div class="hidden md:flex w-[45%] h-full bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 rounded-r-[40px] shadow-2xl relative z-10 flex-col justify-center items-center overflow-hidden">
        <div class="absolute inset-0 bg-white/5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px] opacity-10"></div>
        
        <div class="relative z-20 text-center px-10">
             <!-- Inverse logo color for dark background -->
             <img src="{{ asset('image.png') }}" alt="Logo BITA" class="h-20 object-contain mx-auto mb-8 filter drop-shadow-lg brightness-0 invert">
             <h2 class="text-3xl font-bold text-white mb-4 tracking-wide">Welcome to Logbook</h2>
             <p class="text-indigo-200 text-sm font-medium leading-relaxed max-w-md mx-auto">Track your project progress, manage revisions, and collaborate with your team efficiently.</p>
        </div>
        
        <!-- Decorative glowing orbs -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-1000"></div>
    </div>

    <!-- Right Login Form Area -->
    <div class="flex-1 flex flex-col justify-center items-center relative bg-[#FCFBFA] px-6 sm:px-8">
        
        <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-gray-100">
            
            <!-- Mobile Logo -->
            <div class="flex md:hidden items-center justify-center mb-10">
                <img src="{{ asset('image.png') }}" alt="Logo BITA" class="h-14 object-contain">
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-extrabold text-[#112338] text-center mb-2">Sign In</h1>
            <p class="text-center text-gray-500 text-sm font-medium mb-10">Enter your details to access your account</p>

            <!-- Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl relative text-sm flex items-center gap-3 shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="block sm:inline font-medium">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Username -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Email Address</label>
                    <input type="text" id="email" name="email" placeholder="Enter your Email" value="{{ old('email') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 placeholder-gray-400 shadow-sm transition duration-200 bg-gray-50/50 hover:bg-gray-50 focus:bg-white">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Enter your Password" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 placeholder-gray-400 shadow-sm transition duration-200 bg-gray-50/50 hover:bg-gray-50 focus:bg-white">
                        <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition-colors">
                            <i class="far fa-eye-slash text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Options Row -->
                <div class="flex items-center justify-between mt-1 mb-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0 transition-colors cursor-pointer">
                        <span class="text-xs font-semibold text-gray-500 group-hover:text-gray-700 transition-colors">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline underline-offset-2 transition-all">Forgot password?</a>
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 hover:-translate-y-0.5 text-white font-bold py-3.5 rounded-xl shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.5)] transition-all duration-300">
                    Sign In
                </button>

                <!-- Divider -->
                <div class="relative my-4 flex items-center justify-center">
                    <div class="w-full border-t border-gray-200"></div>
                    <div class="absolute bg-white px-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Or sign in with</div>
                </div>

                <!-- Microsoft Button -->
                <button type="button" class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 font-bold py-3.5 rounded-xl shadow-sm hover:shadow-md transition duration-200 flex items-center justify-center gap-3">
                    <svg width="18" height="18" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0H0V10H10V0Z" fill="#F25022"/>
                        <path d="M21 0H11V10H21V0Z" fill="#7FBA00"/>
                        <path d="M10 11H0V21H10V11Z" fill="#00A4EF"/>
                        <path d="M21 11H11V21H21V11Z" fill="#FFB900"/>
                    </svg>
                    Sign in with Microsoft
                </button>

            </form>
        </div>
        
        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 font-medium mt-8">
            &copy; 2026 BITA Bina Taruna. All rights reserved.
        </p>
    </div>

</body>
</html>
