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
        /* Custom CSS untuk efek pendaran warna (Blobs) seperti di gambar */
        .blob-pink {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,212,233,0.8) 0%, rgba(255,255,255,0) 60%);
            top: -10%;
            right: -5%;
            z-index: 0;
        }
        .blob-purple {
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(235,225,255,0.8) 0%, rgba(255,255,255,0) 60%);
            bottom: -20%;
            left: -10%;
            z-index: 0;
        }
        /* Efek teks gradien pink seperti tulisan "well-being" */
        .text-gradient-pink {
            background: linear-gradient(90deg, #ff8da1, #ffb3c6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="relative min-h-screen overflow-hidden flex items-center justify-center">

    <div class="blob-pink"></div>
    <div class="blob-purple"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        
        <div class="space-y-8">
            <div class="flex items-center gap-2 mb-10">
                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-500 text-xl shadow-sm">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">StuntGuard.</span>
            </div>

            <h1 class="text-6xl md:text-7xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                Always in <br> 
                touch <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-pink-100 text-pink-500 text-3xl align-middle shadow-sm"><i class="fas fa-child"></i></span> <br>
                with your <br>
                <span class="text-gradient-pink">well-being</span>
            </h1>

            <p class="text-slate-500 font-medium max-w-sm text-lg">
                Now, we have a feature to monitor your child's growth and prevent stunting with AI.
            </p>

            <div class="flex flex-wrap gap-3 pt-6">
                <span class="px-5 py-2.5 rounded-full bg-pink-100 text-pink-600 font-semibold text-sm shadow-sm">Medical AI</span>
                <span class="px-5 py-2.5 rounded-full bg-slate-900 text-white font-semibold text-sm shadow-sm">Dashboard</span>
                <span class="px-5 py-2.5 rounded-full bg-pink-50 text-slate-600 font-semibold text-sm shadow-sm border border-pink-100">Growth Track</span>
            </div>
        </div>

        <div class="flex justify-center lg:justify-end w-full">
            <div class="w-full max-w-md bg-white/60 backdrop-blur-2xl border border-white/80 p-8 sm:p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
                
                <div class="bg-white p-1.5 rounded-full flex justify-between shadow-inner mb-8 border border-slate-100">
                    <button class="w-1/2 py-3 rounded-full bg-slate-900 text-white font-semibold text-sm shadow-md transition-all">Login</button>
                    <button class="w-1/2 py-3 rounded-full text-slate-500 font-semibold text-sm hover:text-slate-800 transition-all">Register</button>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Welcome Back! 👋</h2>
                    <p class="text-sm text-slate-500">Sign in to access your dashboard</p>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    <div>
                        <input type="email" placeholder="Email address" class="w-full px-6 py-4 rounded-full bg-white border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition-all shadow-sm" required>
                    </div>
                    
                    <div>
                        <input type="password" placeholder="Password" class="w-full px-6 py-4 rounded-full bg-white border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition-all shadow-sm" required>
                    </div>

                    <div class="flex items-center justify-between px-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 rounded-md text-pink-500 focus:ring-pink-400 border-slate-300">
                            <span class="text-xs font-medium text-slate-500">Remember me</span>
                        </label>
                        <a href="#" class="text-xs font-semibold text-pink-500 hover:text-pink-600">Forgot Password?</a>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm shadow-lg shadow-slate-900/20 transition-all flex justify-center items-center gap-2 group">
                            Sign In to Account
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-8 relative flex items-center justify-center">
                    <div class="absolute inset-x-0 h-px bg-slate-200"></div>
                    <span class="relative bg-white/60 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider backdrop-blur-md">Or continue with</span>
                </div>

                <div class="mt-6">
                    <button class="w-full py-3.5 rounded-full bg-white border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition-all flex justify-center items-center gap-3 shadow-sm">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                        Google
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>