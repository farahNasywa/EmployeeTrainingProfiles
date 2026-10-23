<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Training Profiles</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <div class="relative min-h-screen flex flex-col items-center justify-center bg-cover bg-center px-4"
         style="background-image: url('{{ asset('img/bglogin.jpg') }}');">
        
        <!-- Title -->
        <h1 class="text-white text-6xl font-bold font-poppins mb-12 text-center leading-tight drop-shadow-lg">
            EMPLOYEE TRAINING PROFILES
        </h1>
        
        <!-- Form Login -->
        <div class="bg-black bg-opacity-40 backdrop-blur-md p-10 rounded-lg shadow-2xl w-[32rem]">
            <h2 class="text-center text-5xl font-bold text-white font-poppins mb-6 drop-shadow-lg">
                Login
            </h2>
            @if (session('failed'))
                <div class="alert alert-danger" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form method="POST" action="/">
                @csrf
                @error('email')
                        <span class="alert text-danger text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                <div class="mb-6">
                    <label class="block font-semibold text-lg text-white font-poppins">Email</label>
                    <input 
                        type="email" 
                        name="email"
                        class="w-full px-3 py-3 rounded-md border border-gray-500 text-lg focus:outline-none focus:ring-2 focus:ring-amber-500 bg-gray-900 bg-opacity-50 text-white placeholder-gray-300
                        @error('email') is-invalid @enderror"
                        placeholder="email"
                        autofocus
                        required
                        value="{{ old('email') }}"
                    >
                </div>

                @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                <div class="mb-6 relative">
                    <label class="block font-semibold text-lg text-white font-poppins">Password</label>
                    <input 
                        type="password"
                        name="password"
                        id="password"
                        class="w-full px-3 py-3 rounded-md border border-gray-500 text-lg focus:outline-none focus:ring-2 focus:ring-amber-500 bg-gray-900 bg-opacity-50 text-white placeholder-gray-300 pr-12"
                        placeholder="password"
                        required
                    >
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-11 text-gray-400 hover:text-white">
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                        </svg>
                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.12 10.12 0 0112 19c-6.5 0-10-7-10-7a18.81 18.81 0 015-5.375M9.34 9.34A3 3 0 0112 9c1.657 0 3 1.343 3 3 0 .53-.138 1.03-.38 1.465m3.04 3.04A9.96 9.96 0 0122 12s-3.5-7-10-7c-1.425 0-2.756.285-3.963.8m-4.59 4.59C2 12 5.5 19 12 19c1.49 0 2.886-.34 4.125-.95"/>
                        </svg>
                    </button>
                </div>

                <div class="row mb-3 -mt-3">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember"/>
                    <label class="form-check-label text-white font-bold" for="flexCheckDefault">Remember Me </label>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-orange-800 text-white text-lg font-bold py-3 rounded-md hover:opacity-90 transition duration-300 font-poppins shadow-md">
                    Login
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>