<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        if (!$user) {
            $user = (object) ['name' => 'Admin Medis', 'email' => 'admin@stuntguard.com', 'photo_path' => null];
        }
        
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'photo_cropped' => 'nullable|string', // Menerima data Base64 dari Cropper.js
        ]);

        $user->name = $request->name;

        // Jika ada foto baru yang sudah di-crop
        if ($request->filled('photo_cropped')) {
            // Hapus foto lama jika ada
            if ($user->photo_path && Storage::disk('public')->exists($user->photo_path)) {
                Storage::disk('public')->delete($user->photo_path);
            }
            
            // Proses decoding dari Base64 ke File Gambar
            $image_parts = explode(";base64,", $request->photo_cropped);
            $image_base64 = base64_decode($image_parts[1]);
            
            // Generate nama file unik
            $fileName = 'profile-photos/' . uniqid() . '.png';
            
            // Simpan ke storage
            Storage::disk('public')->put($fileName, $image_base64);
            $user->photo_path = $fileName;
        }

        $user->save();

        return back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }
}