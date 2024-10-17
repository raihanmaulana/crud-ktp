<?php

namespace App\Http\Controllers;

use App\Models\Ktp;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KTPController extends Controller
{

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

    public function exportCsv()
    {
        $ktps = Ktp::all();

        $filename = "ktp_data.csv";
        $handle = fopen($filename, 'w');
        fputcsv($handle, ['ID', 'Nama', 'NIK', 'Alamat', 'Tempat Lahir', 'Tanggal Lahir', 'Created At', 'Updated At']);

        foreach ($ktps as $ktp) {
            fputcsv($handle, [
                $ktp->id,
                $ktp->nama,
                $ktp->nik,
                $ktp->alamat,
                $ktp->tempat_lahir,
                $ktp->tanggal_lahir,
                $ktp->created_at,
                $ktp->updated_at,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }


    public function exportPdf()
    {
        $ktps = Ktp::all();

        $pdf = PDF::loadView('ktp_pdf', compact('ktps'));

        return $pdf->download('ktp_data.pdf');
    }

    public function importCsv(Request $request)
    {
        // Validasi bahwa file adalah CSV
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');

        // Buka dan baca file CSV
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle); // Ambil baris pertama sebagai header

        // Loop setiap baris data CSV dan simpan ke database
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Buat validasi untuk setiap data CSV
            $validator = Validator::make([
                'nama' => $data[0],
                'nik' => $data[1],
                'alamat' => $data[2],
                'tempat_lahir' => $data[3],
                'tanggal_lahir' => $data[4],
            ], [
                'nama' => 'required',
                'nik' => 'required|unique:ktps,nik',
                'alamat' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
            ]);

            if ($validator->fails()) {
                // Abaikan baris yang tidak valid
                continue;
            }

            // Simpan data ke database
            Ktp::create([
                'nama' => $data[0],
                'nik' => $data[1],
                'alamat' => $data[2],
                'tempat_lahir' => $data[3],
                'tanggal_lahir' => $data[4],
            ]);
        }

        fclose($handle); // Tutup file

        return response()->json(['message' => 'Data imported successfully'], 200);
    }
}
