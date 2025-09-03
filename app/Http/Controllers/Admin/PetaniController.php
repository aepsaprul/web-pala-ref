<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PetaniController extends Controller
{
    public function index()
    {
        $petaniRole = Role::where('name', 'petani')->first();
        $users = User::where('role_id', $petaniRole->id)->latest()->paginate(10);

        return view('admin.petani.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat petani baru.
     */
    public function create()
    {
        return view('admin.petani.create');
    }

    /**
     * Menyimpan data petani baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $petaniRole = Role::where('name', 'petani')->first();

        // Menggunakan transaksi database untuk memastikan data konsisten
        DB::transaction(function () use ($request, $petaniRole) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $petaniRole->id,
            ]);

            // Buat juga profil default untuk petani ini
            $user->profile()->create();
        });


        return redirect()->route('admin.petani.index')->with('success', 'Data Petani berhasil ditambahkan.');
    }


    /**
     * Menampilkan form untuk mengedit data petani.
     */
    public function edit(User $petani)
    {
        return view('admin.petani.edit', compact('petani'));
    }

    /**
     * Mengupdate data petani di database.
     */
    public function update(Request $request, User $petani)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$petani->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $petani->name = $request->name;
        $petani->email = $request->email;
        if ($request->filled('password')) {
            $petani->password = Hash::make($request->password);
        }
        $petani->save();

        return redirect()->route('admin.petani.index')->with('success', 'Data Petani berhasil diperbarui.');
    }

    /**
     * Menghapus data petani dari database.
     */
    public function destroy(User $petani)
    {
        $petani->delete();
        return redirect()->route('admin.petani.index')->with('success', 'Data Petani berhasil dihapus.');
    }
}
