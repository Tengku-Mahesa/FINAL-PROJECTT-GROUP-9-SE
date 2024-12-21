<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the profile and edit profile page.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('auth.profile', [
            'user' => $request->user()
        ]);
    }
    
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('auth.profile', [
            'user' => $user
        ]);
    }
    
    public function simpan(Request $data)
    {
        // Validasi input
        $this->validate($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($data->id),],
            'password' => $data->password != null ? ['sometimes', 'confirmed','min:8'] : '',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($data->id),],
            'profesi' => ['required', 'string', 'max:255'],
            'avatar' => ['sometimes','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);

        // Pastikan hanya pengguna yang tepat yang bisa mengedit profil mereka sendiri
        if (Auth::id() !== (int)$data->id) {
            return redirect()->route('dashboard')->with('error', 'Tidak diizinkan untuk mengubah profil pengguna lain!');
        }

        // Proses upload avatar jika ada
        if ($data->hasFile('avatar')) {
            $avatarname = 'avatar'.time().'.'.$data->avatar->getClientOriginalExtension();
            $path = $data->avatar->storeAs('public/avatars', $avatarname);  // Store image

            // Pastikan file disimpan dengan benar
            if (!$path) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload gambar.');
            }

            // Menghapus gambar lama jika ada (selain default.jpg)
            $oldpic = User::find($data->id)->select('avatar')->first();
            if ($oldpic && $oldpic->avatar != "default.jpg" && file_exists(storage_path('app/public/avatars/'.$oldpic->avatar))) {
                Storage::delete('public/avatars/'.$oldpic->avatar);
            }

            // Update avatar pengguna
            User::find($data->id)->update([
                'avatar' => $avatarname,
            ]);
        }

        // Proses update password jika ada
        if ($data->has('password') && $data->password !== NULL) {
            User::find($data->id)->update([
                'password' => Hash::make($data->password),
            ]);
        }

        // Update data lainnya (nama, email, username, profesi)
        User::find($data->id)->update([
            'name' => $data->name,
            'email' => $data->email,
            'username' => $data->username,
            'profesi' => $data->profesi,
        ]);

        // Update status admin jika ada
        if ($data->has('admin') && $data->admin !== NULL) {
            User::find($data->id)->update([
                'admin' => $data->admin,
            ]);
        }

        return redirect()->route('dashboard')->with('pesan', 'Data Profil Berhasil Disimpan');
    }
}
