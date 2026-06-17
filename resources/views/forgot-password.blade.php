<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Logbook Dashboard</title>
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
             <h2 class="text-3xl font-bold text-white mb-4 tracking-wide">Forgot Password?</h2>
             <p class="text-indigo-200 text-sm font-medium leading-relaxed max-w-md mx-auto">No worries, we'll send you reset instructions. Please enter the email address associated with your account.</p>
        </div>
        
        <!-- Decorative glowing orbs -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-1000"></div>
    </div>

    <!-- Right Reset Password Form Area -->
    <div class="flex-1 flex flex-col justify-center items-center relative bg-[#FCFBFA] px-6 sm:px-8">
        
        <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-gray-100">
            
            <!-- Mobile Logo -->
            <div class="flex md:hidden items-center justify-center mb-10">
                <img src="{{ asset('image.png') }}" alt="Logo BITA" class="h-14 object-contain">
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-extrabold text-[#112338] text-center mb-2">Reset Password</h1>
            <p class="text-center text-gray-500 text-sm font-medium mb-10">Enter your email to receive a reset link</p>

            <!-- Form -->
            <form action="{{ route('password.email') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                
                @if (session('status'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl relative text-sm flex items-center gap-3 shadow-sm" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <span class="block sm:inline font-medium">{{ session('status') }}</span>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl relative text-sm flex items-center gap-3 shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="block sm:inline font-medium">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your Email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 placeholder-gray-400 shadow-sm transition duration-200 bg-gray-50/50 hover:bg-gray-50 focus:bg-white">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-500 hover:to-blue-400 hover:-translate-y-0.5 text-white font-bold py-3.5 rounded-xl shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.5)] transition-all duration-300 mt-2">
                    Send Reset Link
                </button>

                <!-- Back to Login -->
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Sign In
                    </a>
                </div>

            </form>
        </div>
        
        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 font-medium mt-8">
            &copy; 2026 BITA Bina Taruna. All rights reserved.
        </p>
    </div>

</body>
</html>
