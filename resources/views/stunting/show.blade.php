@extends('layouts.app')

@section('title', 'Detail Hasil Skrining - StuntGuard')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Detail Hasil Skrining</h1>
        <p class="text-slate-500 text-sm mt-1">Laporan analitik dari model Machine Learning</p>
    </div>
    <a href="{{ route('stunting.index') }}" class="px-4 py-2 bg-white text-slate-600 rounded-lg border border-slate-200 hover:bg-slate-50 transition text-sm font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl p-6 border-t-4 {{ $stunting->prediction_code == 1 ? 'border-red-500' : 'border-emerald-500' }} shadow-sm text-center">
            @if($stunting->prediction_code == 1)
                <div class="w-20 h-20 mx-auto bg-red-100 text-red-500 rounded-full flex items-center justify-center text-4xl mb-4 shadow-inner">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="text-2xl font-bold text-red-600">STUNTING</h2>
                <p class="text-slate-500 text-sm mt-2">Sistem mendeteksi risiko stunting pada balita ini. Diperlukan intervensi segera.</p>
            @else
                <div class="w-20 h-20 mx-auto bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center text-4xl mb-4 shadow-inner">
                    <i class="fas fa-check"></i>
                </div>
                <h2 class="text-2xl font-bold text-emerald-600">TUMBUH NORMAL</h2>
                <p class="text-slate-500 text-sm mt-2">Pertumbuhan balita dalam kondisi optimal dan sesuai standar usia.</p>
            @endif

            @if($stunting->probability_stunting_percent !== null)
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Probabilitas (Keyakinan Model)</p>
                    <div class="text-3xl font-bold text-slate-700">{{ number_format($stunting->probability_stunting_percent, 1) }}%</div>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-teal-50 rounded-bl-full -z-0"></div>
            <h3 class="text-lg font-bold text-slate-800 mb-4 relative z-10 flex items-center">
                <i class="fas fa-lightbulb text-amber-400 mr-2"></i> Rekomendasi AI
            </h3>
            
            <ul class="space-y-3 relative z-10">
                @forelse($recommendations ?? [] as $rek)
                    <li class="flex items-start bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <i class="fas fa-arrow-circle-right text-teal-500 mt-1 mr-3"></i>
                        <span class="text-sm text-slate-700 leading-relaxed">{{ $rek }}</span>
                    </li>
                @empty
                    <li class="text-sm text-slate-500 italic">Tidak ada rekomendasi khusus. Pertahankan pola asuh saat ini.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-bold text-slate-800"><i class="fas fa-notes-medical text-teal-600 mr-2"></i> Rekam Medis Input</h3>
                <span class="text-xs text-slate-400">ID: #{{ $stunting->id }} &bull; {{ $stunting->created_at->format('d/m/Y H:i') }}</span>
            </div>
            
            <div class="p-0">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500 w-1/3">Nama Balita</td><td class="px-6 py-3 font-semibold text-slate-800">{{ $stunting->nama_balita ?? 'Anak Anonim' }}</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Usia</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->usia_bulan }} bulan</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Jenis Kelamin</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Berat Lahir</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->berat_lahir_kg }} kg</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Panjang Lahir</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->panjang_lahir_cm }} cm</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">ASI Eksklusif</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->asi_eksklusif }}</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Protein Harian</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->protein_harian }} g</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Frekuensi Makan</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->frekuensi_makan }}x sehari</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Tinggi Ibu</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->tinggi_ibu_cm }} cm</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Riwayat Diare</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->riwayat_diare }} kali</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Sanitasi Layak</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->sanitasi_layak }}</td></tr>
                        <tr class="hover:bg-slate-50 transition-colors"><td class="px-6 py-3 text-slate-500">Imunisasi Lengkap</td><td class="px-6 py-3 font-medium text-slate-700">{{ $stunting->imunisasi_lengkap }}</td></tr>
                        <tr class="bg-slate-50"><td class="px-6 py-3 text-slate-500">Risk Score Model</td><td class="px-6 py-3 font-mono text-teal-600 font-bold">{{ $stunting->risk_score }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('stunting.create') }}" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl shadow-sm transition font-semibold text-sm">
                <i class="fas fa-plus mr-2"></i> Prediksi Baru
            </a>
        </div>
    </div>
</div>
@endsection