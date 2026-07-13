<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StuntGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #ffffff;
        }
        /* Blobs Hijau/Teal disesuaikan dengan Dashboard */
        .blob-emerald {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(167,243,208,0.7) 0%, rgba(255,255,255,0) 60%);
            top: -10%;
            right: -5%;
            z-index: 0;
        }
        .blob-teal {
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(153,246,228,0.6) 0%, rgba(255,255,255,0) 60%);
            bottom: -20%;
            left: -10%;
            z-index: 0;
        }
        .text-gradient-emerald {
            background: linear-gradient(90deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="relative min-h-screen overflow-hidden flex items-center justify-center">

    <div class="blob-emerald"></div>
    <div class="blob-teal"></div>

    <!-- Peningkatan Responsivitas: Penyesuaian px, py, dan gap untuk layar mobile -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 lg:py-12 grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
        
        <div class="space-y-6 lg:space-y-8 text-center lg:text-left flex flex-col items-center lg:items-start">
            <div class="flex items-center gap-2 mb-4 lg:mb-10">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl shadow-sm">
                    <i class="fas fa-shield-virus"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">StuntGuard.</span>
            </div>

            <!-- Teks lebih adaptif ukurannya -->
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                Always in <br class="hidden sm:block"> 
                touch <span class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-emerald-100 text-emerald-600 text-2xl sm:text-3xl align-middle shadow-sm mx-2"><i class="fas fa-child"></i></span> <br class="hidden sm:block">
                with your <br class="hidden lg:block">
                <span class="text-gradient-emerald">well-being</span>
            </h1>

            <p class="text-slate-500 font-medium max-w-sm text-base sm:text-lg">
                Now, we have a feature to monitor your child's growth and prevent stunting with AI.
            </p>

            <div class="flex flex-wrap justify-center lg:justify-start gap-3 pt-4 sm:pt-6">
                <span class="px-5 py-2.5 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-sm shadow-sm">Medical AI</span>
                <span class="px-5 py-2.5 rounded-full bg-slate-900 text-white font-semibold text-sm shadow-sm">Dashboard</span>
                <span class="px-5 py-2.5 rounded-full bg-emerald-50 text-slate-600 font-semibold text-sm shadow-sm border border-emerald-200">Growth Track</span>
            </div>
        </div>

        <div class="flex justify-center lg:justify-end w-full">
            <div class="w-full max-w-md bg-white/70 backdrop-blur-2xl border border-white/80 p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] relative">
                
                <div class="bg-white p-1.5 rounded-full flex justify-between shadow-inner mb-8 border border-slate-100 relative z-10">
                    <button id="btn-login" onclick="switchTab('login')" class="w-1/2 py-3 rounded-full bg-emerald-600 text-white font-semibold text-sm shadow-md transition-all">Login</button>
                    <button id="btn-register" onclick="switchTab('register')" class="w-1/2 py-3 rounded-full text-slate-500 font-semibold text-sm hover:text-emerald-700 transition-all">Register</button>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 text-red-500 p-3 rounded-xl text-xs font-semibold mb-4 text-center border border-red-100 relative z-10">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="relative w-full overflow-hidden">
                    <div id="form-slider" class="flex transition-transform duration-500 ease-in-out items-start w-full transform translate-x-0">
                        
                        <!-- Form Login -->
                        <div id="form-login" class="w-full flex-shrink-0 transition-opacity duration-300 opacity-100 px-1">
                            <div class="text-center mb-6">
                                <h2 class="text-2xl font-bold text-slate-800 mb-2">Welcome Back! 👋</h2>
                                <p class="text-sm text-slate-500">Sign in to access your dashboard</p>
                            </div>

                            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                                @csrf
                                <!-- Fokus ring dan border diubah ke emerald -->
                                <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" class="w-full px-6 py-4 rounded-full bg-white border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all shadow-sm" required>
                                
                                <input type="password" name="password" placeholder="Password" class="w-full px-6 py-4 rounded-full bg-white border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all shadow-sm" required>

                                <button type="submit" class="w-full py-4 mt-2 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 transition-all flex justify-center items-center gap-2 group">
                                    Sign In
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Form Register -->
                        <div id="form-register" class="w-full flex-shrink-0 transition-opacity duration-300 opacity-0 px-1">
                            <div class="text-center mb-6">
                                <h2 class="text-2xl font-bold text-slate-800 mb-2">Join Us Today! ✨</h2>
                                <p class="text-sm text-slate-500">Create an account to start monitoring</p>
                            </div>

                            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" class="w-full px-6 py-4 rounded-full bg-white border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all shadow-sm" required>

                                <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" class="w-full px-6 py-4 rounded-full bg-white border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all shadow-sm" required>
                                
                                <input type="password" name="password" placeholder="Password (Min. 6 chars)" class="w-full px-6 py-4 rounded-full bg-white border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 transition-all shadow-sm" required>

                                <button type="submit" class="w-full py-4 mt-2 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 transition-all flex justify-center items-center gap-2 group">
                                    Create Account
                                    <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const slider = document.getElementById('form-slider');
            const formLogin = document.getElementById('form-login');
            const formRegister = document.getElementById('form-register');
            const btnLogin = document.getElementById('btn-login');
            const btnRegister = document.getElementById('btn-register');

            if (tab === 'login') {
                slider.style.transform = 'translateX(0)';
                formLogin.style.opacity = '1';
                formRegister.style.opacity = '0';
                
                btnLogin.className = 'w-1/2 py-3 rounded-full bg-emerald-600 text-white font-semibold text-sm shadow-md transition-all';
                btnRegister.className = 'w-1/2 py-3 rounded-full text-slate-500 font-semibold text-sm hover:text-emerald-700 transition-all';
            } else {
                slider.style.transform = 'translateX(-100%)';
                formLogin.style.opacity = '0';
                formRegister.style.opacity = '1';
                
                btnRegister.className = 'w-1/2 py-3 rounded-full bg-emerald-600 text-white font-semibold text-sm shadow-md transition-all';
                btnLogin.className = 'w-1/2 py-3 rounded-full text-slate-500 font-semibold text-sm hover:text-emerald-700 transition-all';
            }
        }
        
        @if(old('name') || $errors->has('name'))
            switchTab('register');
        @endif
    </script>
</body>
</html>