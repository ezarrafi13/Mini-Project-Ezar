@extends('layouts.app')

@section('title', 'Form Skrining Baru - StuntGuard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Skrining Balita Baru</h1>
        <p class="text-slate-500 text-sm mt-1">Masukkan data klinis dan lingkungan untuk dianalisis oleh Machine Learning.</p>
    </div>

    @if ($errors->has('api'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 shadow-sm flex items-start" role="alert">
            <i class="fas fa-exclamation-circle mt-0.5 mr-3 text-lg"></i>
            <div>
                <p class="font-bold text-sm">Sistem AI Gagal Merespons</p>
                <p class="text-sm mt-1">{{ $errors->first('api') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('stunting.store') }}" method="POST" id="stunting-form" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 group-hover:bg-teal-50/30 transition-colors">
                <h2 class="text-slate-800 font-semibold"><i class="fas fa-child text-teal-500 mr-2"></i>Data Dasar Anak</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5 bg-white">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Balita (Opsional)</label>
                    <input type="text" name="nama_balita" value="{{ old('nama_balita') }}" placeholder="Masukkan nama atau inisial anak" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Usia (bulan) *</label>
                    <input type="number" name="usia_bulan" value="{{ old('usia_bulan') }}" min="0" max="60" placeholder="0 - 60" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                    @error('usia_bulan')<p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all cursor-pointer" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Berat Lahir (kg) *</label>
                    <input type="number" step="0.01" name="berat_lahir_kg" value="{{ old('berat_lahir_kg') }}" placeholder="cth: 3.2" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Panjang Lahir (cm) *</label>
                    <input type="number" step="0.1" name="panjang_lahir_cm" value="{{ old('panjang_lahir_cm') }}" placeholder="cth: 50.0" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 group-hover:bg-teal-50/30 transition-colors">
                <h2 class="text-slate-800 font-semibold"><i class="fas fa-apple-alt text-teal-500 mr-2"></i>Nutrisi & Medis</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5 bg-white">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">ASI Eksklusif *</label>
                    <select name="asi_eksklusif" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all cursor-pointer" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('asi_eksklusif')=='Ya'?'selected':'' }}>Ya</option>
                        <option value="Tidak" {{ old('asi_eksklusif')=='Tidak'?'selected':'' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Imunisasi Lengkap *</label>
                    <select name="imunisasi_lengkap" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all cursor-pointer" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('imunisasi_lengkap')=='Ya'?'selected':'' }}>Ya</option>
                        <option value="Tidak" {{ old('imunisasi_lengkap')=='Tidak'?'selected':'' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Frekuensi Makan (x/hari) *</label>
                    <input type="number" name="frekuensi_makan" value="{{ old('frekuensi_makan') }}" placeholder="cth: 3" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Protein Harian (g) *</label>
                    <input type="number" step="0.1" name="protein_harian" value="{{ old('protein_harian') }}" placeholder="cth: 45.0" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Riwayat Diare (kali dalam 1 bulan terakhir) *</label>
                    <input type="number" name="riwayat_diare" value="{{ old('riwayat_diare') }}" placeholder="0" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 group-hover:bg-teal-50/30 transition-colors">
                <h2 class="text-slate-800 font-semibold"><i class="fas fa-home text-teal-500 mr-2"></i>Keluarga & Lingkungan</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5 bg-white">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tinggi Ibu (cm) *</label>
                    <input type="number" step="0.1" name="tinggi_ibu_cm" value="{{ old('tinggi_ibu_cm') }}" placeholder="cth: 160.0" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Sanitasi Layak *</label>
                    <select name="sanitasi_layak" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all cursor-pointer" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('sanitasi_layak')=='Ya'?'selected':'' }}>Ya</option>
                        <option value="Tidak" {{ old('sanitasi_layak')=='Tidak'?'selected':'' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Pendapatan Keluarga (Rp) *</label>
                    <input type="number" name="pendapatan_keluarga" value="{{ old('pendapatan_keluarga') }}" placeholder="cth: 6000000" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 text-slate-400">Risk Score (Otomatis dari ML) *</label>
                    <input type="number" step="0.1" name="risk_score" value="{{ old('risk_score', '10.5') }}" class="form-input bg-slate-100 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm text-slate-500 cursor-not-allowed" required readonly>
                    <p class="text-[10px] text-slate-400 mt-1">Nilai ini digunakan untuk pengujian API</p>
                </div>
            </div>
        </div>

        <div class="pt-2 pb-10">
            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-lg shadow-teal-500/30 transition transform hover:-translate-y-0.5 text-base flex items-center justify-center gap-2">
                <i class="fas fa-brain"></i> Proses dengan Machine Learning
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formInputs = document.querySelectorAll('.form-input[required]');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');

        function updateProgress() {
            let filled = 0;
            formInputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filled++;
                }
            });
            const total = formInputs.length;
            const percentage = Math.round((filled / total) * 100);
            
            progressBar.style.width = percentage + '%';
            progressText.innerText = percentage + '%';

            if (percentage === 100) {
                progressBar.classList.replace('bg-teal-500', 'bg-emerald-500');
                progressText.classList.replace('text-teal-600', 'text-emerald-700');
                progressText.classList.replace('bg-teal-50', 'bg-emerald-100');
            } else {
                progressBar.classList.replace('bg-emerald-500', 'bg-teal-500');
                progressText.classList.replace('text-emerald-700', 'text-teal-600');
                progressText.classList.replace('bg-emerald-100', 'bg-teal-50');
            }
        }

        formInputs.forEach(input => {
            input.addEventListener('input', updateProgress);
            input.addEventListener('change', updateProgress);
        });

        updateProgress();
    });
</script>
@endpush
@endsection