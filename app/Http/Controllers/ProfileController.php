<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama kandidat wajib diisi.',
            'image.mimes' => 'Format foto profil harus berupa JPG atau PNG.',
            'image.max' => 'Ukuran foto profil maksimal adalah 1MB.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
        ]);

        $imagePath = $user->image;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('profiles', 'public');
        }

        // Use Prepared statement
        if (!empty($validated['password'])) {
            DB::update(
                'UPDATE users SET name = ?, position = ?, image = ?, password = ?, updated_at = ? WHERE id = ?',
                [
                    $validated['name'],
                    $validated['position'] ?? $user->position,
                    $imagePath,
                    Hash::make($validated['password']),
                    now(),
                    $user->id,
                ]
            );
        } else {
            DB::update(
                'UPDATE users SET name = ?, position = ?, image = ?, updated_at = ? WHERE id = ?',
                [
                    $validated['name'],
                    $validated['position'] ?? $user->position,
                    $imagePath,
                    now(),
                    $user->id,
                ]
            );
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profil kandidat berhasil diperbarui.');
    }
}
