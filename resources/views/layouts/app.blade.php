<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Prediksi Stunting')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800">

@php
    $currentUser = auth()->user();
    
    // Fallback darurat jika diakses tanpa login (meski sudah diblokir middleware)
    if (!$currentUser) {
        $currentUser = (object)['name' => 'Guest', 'email' => 'guest@stuntguard.com', 'photo_path' => null];
    }
    
    $userInitial = strtoupper(substr($currentUser->name, 0, 1));
@endphp

<div class="flex h-screen overflow-hidden">

    <aside id="sidebar" class="bg-white w-64 border-r border-slate-200 flex-shrink-0 hidden md:flex flex-col transition-all duration-300 absolute md:relative z-40 h-full shadow-2xl md:shadow-none -translate-x-full md:translate-x-0">
        <div class="h-16 flex items-center px-6 border-b border-slate-100">
            <i class="fas fa-shield-virus text-teal-600 text-2xl mr-3"></i>
            <span class="text-lg font-bold text-slate-700 tracking-tight">Stunt<span class="text-teal-600">Guard</span></span>
            <button id="close-sidebar" class="md:hidden ml-auto text-slate-400 hover:text-slate-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
            <a href="{{ route('stunting.index') }}" class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('stunting.index') ? 'bg-teal-50 text-teal-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} transition-all">
                <i class="fas fa-chart-pie w-6 text-center {{ request()->routeIs('stunting.index') ? 'text-teal-600' : 'text-slate-400' }}"></i>
                <span class="ml-3 text-sm">Dashboard Utama</span>
            </a>

            <a href="{{ route('stunting.create') }}" class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('stunting.create') ? 'bg-teal-50 text-teal-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} transition-all">
                <i class="fas fa-stethoscope w-6 text-center {{ request()->routeIs('stunting.create') ? 'text-teal-600' : 'text-slate-400' }}"></i>
                <span class="ml-3 text-sm">Skrining AI Baru</span>
            </a>

            <div class="pt-4 mt-4 border-t border-slate-100">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('profile.edit') ? 'bg-teal-50 text-teal-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }} transition-all">
                    <i class="fas fa-user-cog w-6 text-center {{ request()->routeIs('profile.edit') ? 'text-teal-600' : 'text-slate-400' }}"></i>
                    <span class="ml-3 text-sm">Pengaturan Profil</span>
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 hover:text-red-700 transition-all text-left">
                        <i class="fas fa-sign-out-alt w-6 text-center"></i>
                        <span class="ml-3 text-sm font-semibold">Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        <a href="{{ route('profile.edit') }}" class="p-4 border-t border-slate-100 bg-slate-50 hover:bg-slate-100 transition-colors group cursor-pointer block">
            <div class="flex items-center">
                <div class="h-9 w-9 rounded-full overflow-hidden shadow-sm border-2 border-transparent group-hover:border-teal-400 transition-colors flex-shrink-0">
                    @if($currentUser->photo_path)
                        <img src="{{ asset('storage/' . $currentUser->photo_path) }}" alt="Profile" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-teal-500 to-emerald-600 text-white font-bold text-sm">
                            {{ $userInitial }}
                        </div>
                    @endif
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-semibold text-slate-700 truncate">{{ $currentUser->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $currentUser->email }}</p>
                </div>
            </div>
        </a>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-800 bg-opacity-40 backdrop-blur-sm z-30 hidden md:hidden transition-opacity"></div>

    <div class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-20 shadow-sm">
            <div class="flex items-center">
                <button id="open-sidebar" class="text-slate-500 hover:text-teal-600 focus:outline-none md:hidden mr-4 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="hidden sm:flex items-center bg-slate-100 rounded-full px-4 py-2 w-72 border border-slate-200 focus-within:bg-white focus-within:border-teal-400 focus-within:shadow-sm transition-all">
                    <i class="fas fa-search text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Cari rekam medis balita..." class="bg-transparent border-none focus:outline-none ml-2 text-sm w-full text-slate-600 placeholder-slate-400">
                </div>
            </div>

            <div class="flex items-center space-x-5">
                <button class="text-slate-400 hover:text-teal-600 relative transition-colors">
                    <i class="far fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                
                <a href="{{ route('profile.edit') }}" class="h-9 w-9 rounded-full bg-slate-200 border-2 border-slate-200 overflow-hidden cursor-pointer hover:border-teal-500 transition-colors flex-shrink-0">
                    @if($currentUser->photo_path)
                        <img src="{{ asset('storage/' . $currentUser->photo_path) }}" alt="Profile" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-teal-500 to-emerald-600 text-white font-bold text-sm">
                            {{ $userInitial }}
                        </div>
                    @endif
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8">
            @yield('content')
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
        }

        openBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    });
</script>

@stack('scripts')
</body>
</html>