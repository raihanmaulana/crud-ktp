<?php

namespace App\Http\Controllers\WEB;

use App\Models\Ktp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KTPWebController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $ktps = Ktp::paginate(8, ['*'], 'page', $page);

        return view('ktp.index', compact('ktps'));
    }


    public function show($id)
    {
        $ktp = Ktp::find($id);

        if ($ktp) {
            $page = request('page', 1); // Ambil nilai page dari query string
            return view('ktp.show', compact('ktp', 'page')); // Kirim page ke view
        } else {
            return redirect()->route('ktp.index')->with('error', 'KTP not found');
        }
    }


    public function edit($id)
    {
        $ktp = Ktp::find($id);

        if ($ktp) {
            return view('ktp.edit', compact('ktp')); // Kembalikan view edit dengan data KTP
        } else {
            return redirect()->route('ktp.index')->with('error', 'KTP not found');
        }
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
   

    private function generateUniqueNik()
    {
        do {
            $nik = str_pad(random_int(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
        } while (Ktp::where('nik', $nik)->exists());

        return $nik;
    }

    

    
}
