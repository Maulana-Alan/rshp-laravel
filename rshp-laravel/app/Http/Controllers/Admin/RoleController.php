<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRole($request);
            $this->createRole($validatedData);

            return redirect()->route('admin.role.index')
                             ->with('success', 'Role berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Helper: Validasi
     */
    protected function validateRole(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:role,nama_role,' . $id . ',idrole' 
                         : 'unique:role,nama_role';

        return $request->validate([
            'nama_role' => [
                'required',
                'string',
                'max:100',
                'min:3',
                $uniqueRule
            ],
        ], [
            'nama_role.required' => 'Nama role wajib diisi.',
            'nama_role.min' => 'Nama role minimal 3 karakter.',
            'nama_role.unique' => 'Nama role ini sudah ada.',
        ]);
    }

    /**
     * Helper: Simpan ke DB
     */
    protected function createRole(array $data)
    {
        try {
            return Role::create([
                'nama_role' => $this->formatNama($data['nama_role']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data role: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Format Nama (Title Case)
     */
    protected function formatNama($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}