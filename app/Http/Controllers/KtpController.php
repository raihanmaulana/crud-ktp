<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use Illuminate\Http\Request;

class KTPController extends Controller
{
    // GET: List All KTPs
    public function index()
    {
        return response()->json(Ktp::all(), 200);
    }

    // POST: Create New KTP
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto
        ]);

        // Handle Upload Foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('foto_ktp', 'public'); // Simpan ke storage public/foto_ktp
        }

        // Generate Unique NIK
        $nik = $this->generateUniqueNik();

        // Simpan Data KTP
        $ktp = Ktp::create([
            'nama' => $request->nama,
            'nik' => $nik,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto' => $fotoPath, // Simpan path foto
        ]);

        return response()->json($ktp, 201);
    }


    // GET: Get Specific KTP by ID
    public function show($id)
    {
        $ktp = Ktp::find($id);

        if ($ktp) {
            return response()->json($ktp, 200);
        } else {
            return response()->json(['message' => 'KTP not found'], 404);
        }
    }

    // PUT/PATCH: Update KTP by ID
    public function update(Request $request, $id)
    {
        $ktp = Ktp::find($id);

        if ($ktp) {
            $ktp->update($request->all());
            return response()->json($ktp, 200);
        } else {
            return response()->json(['message' => 'KTP not found'], 404);
        }
    }

    // DELETE: Delete KTP by ID
    public function destroy($id)
    {
        $ktp = Ktp::find($id);

        if ($ktp) {
            $ktp->delete();
            return response()->json(['message' => 'KTP deleted'], 200);
        } else {
            return response()->json(['message' => 'KTP not found'], 404);
        }
    }

    private function generateUniqueNik()
    {
        do {
            $nik = str_pad(random_int(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
        } while (Ktp::where('nik', $nik)->exists());

        return $nik;
    }
}
