<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Prediksi Stunting</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">
<div class="mx-auto px-4 max-w-lg">

    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Hasil Prediksi Stunting</h1>

    @if($stunting->prediction_code == 1)
        <div class="bg-red-50 border-2 border-red-400 rounded-2xl p-8 mb-5 text-center shadow">
            <p class="text-6xl mb-3">⚠️</p>
            <h2 class="text-3xl font-bold text-red-700">STUNTING</h2>
            <p class="text-red-500 mt-2 text-sm">Balita terdeteksi berisiko stunting. Segera konsultasi ke dokter.</p>
        </div>
    @else
        <div class="bg-green-50 border-2 border-green-400 rounded-2xl p-8 mb-5 text-center shadow">
            <p class="text-6xl mb-3">✅</p>
            <h2 class="text-3xl font-bold text-green-700">TIDAK STUNTING</h2>
            <p class="text-green-500 mt-2 text-sm">Pertumbuhan balita dalam kondisi normal.</p>
        </div>
    @endif

    @if($stunting->probability_stunting_percent !== null)
        <div class="bg-white rounded-xl shadow p-4 mb-5 text-center">
            <p class="text-gray-500 text-sm mb-1">Probabilitas Stunting</p>
            <p class="text-3xl font-bold {{ $stunting->prediction_code == 1 ? 'text-red-600' : 'text-green-600' }}">
                {{ number_format($stunting->probability_stunting_percent, 2) }}%
            </p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-5 mb-5 text-sm text-gray-700 space-y-2">
        <h3 class="font-semibold text-gray-800 mb-3 text-base">Detail Data</h3>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Nama Balita</span><span class="font-medium">{{ $stunting->nama_balita ?? '-' }}</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Usia</span><span class="font-medium">{{ $stunting->usia_bulan }} bulan</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Jenis Kelamin</span><span class="font-medium">{{ $stunting->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Berat Lahir</span><span class="font-medium">{{ $stunting->berat_lahir_kg }} kg</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Panjang Lahir</span><span class="font-medium">{{ $stunting->panjang_lahir_cm }} cm</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">ASI Eksklusif</span><span class="font-medium">{{ $stunting->asi_eksklusif }}</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Protein Harian</span><span class="font-medium">{{ $stunting->protein_harian }} g</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Frekuensi Makan</span><span class="font-medium">{{ $stunting->frekuensi_makan }}x/hari</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Tinggi Ibu</span><span class="font-medium">{{ $stunting->tinggi_ibu_cm }} cm</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Riwayat Diare</span><span class="font-medium">{{ $stunting->riwayat_diare }} kali</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Pendapatan Keluarga</span><span class="font-medium">Rp {{ number_format($stunting->pendapatan_keluarga, 0, ',', '.') }}</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Sanitasi Layak</span><span class="font-medium">{{ $stunting->sanitasi_layak }}</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Imunisasi Lengkap</span><span class="font-medium">{{ $stunting->imunisasi_lengkap }}</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Risk Score</span><span class="font-medium">{{ $stunting->risk_score }}</span></div>
        <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Diprediksi oleh</span><span class="font-medium">{{ $stunting->predicted_by ?? '-' }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Waktu</span><span class="font-medium">{{ $stunting->created_at->format('d M Y H:i') }}</span></div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('stunting.create') }}"
           class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition text-sm">
            + Prediksi Baru
        </a>
        <a href="{{ route('stunting.index') }}"
           class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg transition text-sm">
            Riwayat
        </a>
    </div>

</div>
</body>
</html>