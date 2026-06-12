<!DOCTYPE html>
<html lang="id">
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
            background-color: #ffffff;
        }
    </style>
</head>
<body class="h-screen w-full flex overflow-hidden">

    <!-- Left Gradient Background -->
    <div class="hidden md:block w-[45%] h-full bg-gradient-to-br from-[#AF8C64] via-[#D3C7BC] to-[#C9CAD0] rounded-r-[40px] shadow-lg relative z-10">
        <!-- Optional: You can put a background image here if needed -->
    </div>

    <!-- Right Login Form Area -->
    <div class="flex-1 flex flex-col justify-center items-center relative bg-white px-6 sm:px-8">
        
        <div class="w-full max-w-md">
            
            <!-- Logo -->
            <div class="flex items-center justify-center mb-12">
                <span class="text-[40px] font-bold tracking-wide text-[#CBB964] drop-shadow-sm">BITA</span>
                <span class="ml-2 text-[40px] font-bold italic text-[#CBB964] drop-shadow-sm" style="-webkit-text-stroke: 1px #A39345; color: transparent;">15</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-10">Sign In</h1>

            <!-- Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm" role="alert">
                        <span class="block sm:inline">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Username -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-800 mb-2 tracking-wide">Username/Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your Email" value="{{ old('email') }}"
                        class="w-full border border-[#BCAEA2] rounded-md px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#AF8C64] placeholder-gray-400">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-800 mb-2 tracking-wide">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Enter your Password" 
                            class="w-full border border-[#BCAEA2] rounded-md px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#AF8C64] placeholder-gray-400">
                        <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="far fa-eye-slash text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Options Row -->
                <div class="flex items-center justify-between mt-1 mb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#AF8C64] focus:ring-[#AF8C64]">
                        <span class="text-xs font-semibold text-gray-500">Remember me</span>
                    </label>
                    <a href="#" class="text-xs font-semibold text-gray-500 hover:text-gray-800 underline decoration-gray-400 underline-offset-2">Forgot password?</a>
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="w-full bg-[#9B8877] hover:bg-[#867566] text-white font-bold py-3.5 rounded-md shadow-sm transition">
                    Sign In
                </button>

                <!-- Divider -->
                <div class="relative my-4 flex items-center justify-center">
                    <div class="w-full border-t border-[#E2DDD8]"></div>
                    <div class="absolute bg-white px-3 text-xs font-semibold text-gray-400">Or sign in with</div>
                    <div class="absolute right-0 bg-white pl-2">
                        <i class="far fa-question-circle text-gray-400 text-[10px]"></i>
                    </div>
                </div>

                <!-- Microsoft Button -->
                <button type="button" class="w-full bg-[#9B8877] hover:bg-[#867566] text-white font-bold py-3.5 rounded-md shadow-sm transition flex items-center justify-center gap-3">
                    <svg width="20" height="20" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0H0V10H10V0Z" fill="#F25022"/>
                        <path d="M21 0H11V10H21V0Z" fill="#7FBA00"/>
                        <path d="M10 11H0V21H10V11Z" fill="#00A4EF"/>
                        <path d="M21 11H11V21H21V11Z" fill="#FFB900"/>
                    </svg>
                    Sign in with Microsoft
                </button>

            </form>
        </div>
    </div>

</body>
</html>
