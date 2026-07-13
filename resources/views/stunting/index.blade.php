@extends('layouts.app')

@section('title', 'Dashboard Skrining - StuntGuard')

@section('content')
<div class="bg-gradient-to-r from-teal-600 to-emerald-500 rounded-2xl p-6 sm:p-8 mb-8 text-white shadow-lg relative overflow-hidden">
    <div class="relative z-10">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang di Dashboard StuntGuard 👋</h1>
        <p class="text-teal-50 max-w-2xl text-sm sm:text-base">Pantau riwayat prediksi, kelola data balita, dan bantu tingkatkan status gizi anak secara real-time dengan bantuan Machine Learning.</p>
    </div>
    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-48 h-48 rounded-full bg-white opacity-10"></div>
    <div class="absolute bottom-0 right-20 -mb-10 w-32 h-32 rounded-full bg-white opacity-10"></div>
</div>

@if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg mb-8 shadow-sm flex items-center" role="alert">
        <i class="fas fa-check-circle mr-3 text-lg"></i>
        <p class="font-medium text-sm">{{ session('success') }}</p>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Total Balita Diskrinning</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $predictions->total() }}</h3>
        </div>
        <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center text-2xl">
            <i class="fas fa-file-medical"></i>
        </div>
    </div>
    
    @php
        $stuntingCount = $predictions->where('prediction_code', 1)->count();
        $normalCount = $predictions->where('prediction_code', 0)->count();
    @endphp
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Kasus Risiko Stunting</p>
            <h3 class="text-3xl font-bold text-red-500">{{ $stuntingCount }} <span class="text-xs text-slate-400 font-normal">di halaman ini</span></h3>
        </div>
        <div class="w-14 h-14 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-2xl">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Kasus Tumbuh Normal</p>
            <h3 class="text-3xl font-bold text-emerald-500">{{ $normalCount }} <span class="text-xs text-slate-400 font-normal">di halaman ini</span></h3>
        </div>
        <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center text-2xl">
            <i class="fas fa-child"></i>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
        <h2 class="text-lg font-bold text-slate-800">Riwayat Skrining Terbaru</h2>
        <a href="{{ route('stunting.create') }}" class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors flex items-center justify-center shadow-sm">
            <i class="fas fa-plus mr-2"></i> Prediksi Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs tracking-wider border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">ID & Nama Balita</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Probabilitas</th>
                    <th class="px-6 py-4">Waktu Check</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($predictions as $p)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-800 text-base">{{ $p->nama_balita ?? 'Anak Anonim' }} <span class="text-xs font-normal text-slate-400 ml-1">#{{ $p->id }}</span></p>
                        <p class="text-xs text-slate-500 mt-0.5"><i class="fas fa-calendar-alt mr-1 text-slate-400"></i> {{ $p->usia_bulan }} bulan &nbsp;&bull;&nbsp; <i class="fas {{ $p->jenis_kelamin == 'L' ? 'fa-mars text-blue-400' : 'fa-venus text-pink-400' }} mr-1"></i> {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($p->prediction_code == 1)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 animate-pulse"></span> Stunting
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Normal
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($p->probability_stunting_percent !== null)
                            <div class="flex flex-col items-center justify-center gap-1">
                                <span class="text-slate-700 font-semibold text-xs">{{ number_format($p->probability_stunting_percent, 1) }}%</span>
                                <div class="w-20 h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full {{ $p->prediction_code == 1 ? 'bg-red-500' : 'bg-emerald-400' }}" style="width: {{ $p->probability_stunting_percent }}%"></div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-slate-400">-</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">
                        <p class="font-medium text-slate-700">{{ $p->created_at->format('d M Y') }}</p>
                        <p>{{ $p->created_at->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('stunting.show', $p->id) }}" class="inline-flex items-center text-teal-600 hover:text-teal-800 font-semibold text-xs bg-teal-50 hover:bg-teal-100 px-3 py-2 rounded-lg transition-colors">
                            Detail <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <i class="fas fa-box-open text-5xl mb-4 text-slate-200"></i>
                            <p class="text-base font-medium text-slate-600">Belum ada data skrining</p>
                            <p class="text-sm mt-1">Data prediksi balita akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($predictions->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
        {{ $predictions->links() }}
    </div>
    @endif
</div>
@endsection