@extends('layouts.app')

@section('title', 'Pengaturan Profil - StuntGuard')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    /* Memastikan area crop tidak melebihi modal */
    .cropper-container { max-width: 100%; }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Profil</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola informasi pribadi dan sesuaikan foto profil Anda.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg mb-6 shadow-sm flex items-center">
            <i class="fas fa-check-circle mr-3"></i>
            <p class="font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            
            <input type="hidden" name="photo_cropped" id="photo_cropped">

            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row items-center gap-6 pb-8 border-b border-slate-100 mb-8">
                    <div class="relative group">
                        <div id="photo-preview-container" class="w-28 h-28 rounded-full border-4 border-white shadow-lg overflow-hidden bg-slate-100 flex items-center justify-center relative">
                            
                            @php 
                                $initial = strtoupper(substr($user->name, 0, 1)); 
                            @endphp

                            @if($user->photo_path)
                                <img id="photo-preview" src="{{ asset('storage/' . $user->photo_path) }}" class="w-full h-full object-cover">
                            @else
                                <div id="initial-preview" class="w-full h-full bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center text-white text-4xl font-bold">
                                    {{ $initial }}
                                </div>
                                <img id="photo-preview" src="#" class="w-full h-full object-cover hidden">
                            @endif

                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('photo-input').click()">
                                <i class="fas fa-camera text-white text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">Foto Profil</h3>
                        <p class="text-sm text-slate-500 mb-3">Pilih foto, lalu atur posisinya. Format: PNG/JPG.</p>
                        
                        <input type="file" id="photo-input" class="hidden" accept="image/jpeg, image/png, image/jpg">
                        <button type="button" onclick="document.getElementById('photo-input').click()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition border border-slate-200">
                            Pilih & Atur Foto
                        </button>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input bg-slate-50 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email <span class="text-slate-400 font-normal">(Tidak dapat diubah)</span></label>
                        <input type="email" value="{{ $user->email }}" class="form-input bg-slate-100 border border-slate-200 rounded-xl w-full px-4 py-2.5 text-sm text-slate-500 cursor-not-allowed" readonly>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="cropper-modal" class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm hidden flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800">Atur Posisi Foto</h3>
            <button type="button" id="close-modal" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="p-6 bg-slate-100 flex justify-center">
            <div class="w-full max-h-[50vh] flex justify-center items-center">
                <img id="image-to-crop" src="#" class="max-w-full hidden">
            </div>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 bg-white flex justify-end gap-3">
            <button type="button" id="cancel-crop" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
                Batal
            </button>
            <button type="button" id="apply-crop" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition flex items-center">
                <i class="fas fa-crop-alt mr-2"></i> Terapkan Foto
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.getElementById('photo-input');
        const cropperModal = document.getElementById('cropper-modal');
        const imageToCrop = document.getElementById('image-to-crop');
        const closeModal = document.getElementById('close-modal');
        const cancelCrop = document.getElementById('cancel-crop');
        const applyCrop = document.getElementById('apply-crop');
        const photoPreview = document.getElementById('photo-preview');
        const initialPreview = document.getElementById('initial-preview');
        const photoCroppedInput = document.getElementById('photo_cropped');
        
        let cropper;

        // Ketika pengguna memilih file gambar
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    imageToCrop.classList.remove('hidden');
                    
                    // Tampilkan modal
                    cropperModal.classList.remove('hidden');
                    
                    // Inisialisasi Cropper.js
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 1, // Memaksa rasio 1:1 (persegi)
                        viewMode: 1,    // Membatasi kotak crop agar tidak keluar dari gambar
                        dragMode: 'move', // Memungkinkan pengguna mendrag/menggeser gambar
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        // Fungsi untuk menutup modal
        function hideModal() {
            cropperModal.classList.add('hidden');
            photoInput.value = ''; // Reset input file
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        closeModal.addEventListener('click', hideModal);
        cancelCrop.addEventListener('click', hideModal);

        // Ketika pengguna menekan tombol "Terapkan Foto"
        applyCrop.addEventListener('click', function() {
            if (cropper) {
                // Ambil hasil crop dalam bentuk Base64 (Kualitas tinggi, format PNG)
                const canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                });
                
                const base64Image = canvas.toDataURL('image/png');
                
                // Masukkan ke input hidden untuk dikirim ke Controller
                photoCroppedInput.value = base64Image;
                
                // Update tampilan preview di UI
                photoPreview.src = base64Image;
                photoPreview.classList.remove('hidden');
                
                if (initialPreview) {
                    initialPreview.classList.add('hidden');
                }
                
                hideModal();
            }
        });
    });
</script>
@endpush
@endsection