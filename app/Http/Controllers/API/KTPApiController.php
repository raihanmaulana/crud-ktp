<?php

namespace App\Http\Controllers\API;

use App\Models\Ktp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class KTPApiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter 'page' dari request, default ke 1
        $page = $request->input('page', 1); // Mengambil halaman dari request
        $ktps = Ktp::paginate(8, ['*'], 'page', $page); // Gunakan parameter 'page' dalam paginate

        return response()->json([
            'data' => $ktps->items(), // Data pada halaman ini
            'links' => $ktps->linkCollection(), // Links pagination dalam bentuk objek
            'meta' => [
                'current_page' => $ktps->currentPage(),
                'last_page' => $ktps->lastPage(),
                'per_page' => $ktps->perPage(),
                'total' => $ktps->total()
            ]
        ]);
    }



    // Fungsi untuk membuat pagination links
    private function generatePaginationLinks($pagination)
    {
        $links = '<ul class="pagination">';

        // Link "Previous"
        if ($pagination->onFirstPage()) {
            $links .= '<li class="disabled"><span class="px-2">Previous</span></li>';
        } else {
            $links .= '<li><a href="#" onclick="loadKTPData(' . ($pagination->currentPage() - 1) . ')" class="px-2">Previous</a></li>';
        }

        // Numbered Links
        for ($i = 1; $i <= $pagination->lastPage(); $i++) {
            if ($i == $pagination->currentPage()) {
                $links .= '<li class="active"><span class="px-2">' . $i . '</span></li>';
            } else {
                $links .= '<li><a href="#" onclick="loadKTPData(' . $i . ')" class="px-2">' . $i . '</a></li>';
            }
        }

        // Link "Next"
        if ($pagination->hasMorePages()) {
            $links .= '<li><a href="#" onclick="loadKTPData(' . ($pagination->currentPage() + 1) . ')" class="px-2">Next</a></li>';
        } else {
            $links .= '<li class="disabled"><span class="px-2">Next</span></li>';
        }

        $links .= '</ul>';

        return $links;
    }


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

    private function generateUniqueNik()
    {
        do {
            $nik = str_pad(random_int(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
        } while (Ktp::where('nik', $nik)->exists());

        return $nik;
    }


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
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'alamat' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        $ktp = Ktp::findOrFail($id);
        $ktp->update($validatedData);

        // Ambil parameter 'page' dari request query
        $page = $request->query('page', 1);
        \Log::info("Page received in update: $page"); // Log halaman untuk memastikan

        return response()->json([
            'message' => 'Data KTP berhasil diperbarui.',
            'page' => $page, 
        ], 200);
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
        $ktps = Ktp::cursor(); // Gunakan cursor untuk menghindari penggunaan memori berlebih

        $pdf = PDF::loadView('ktp_pdf', compact('ktps'));

        return $pdf->download('ktp_data.pdf');
    }



    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        // Ambil header dari CSV
        $header = fgetcsv($handle);

        $imported = 0; // Counter untuk data yang berhasil diimport

        // Loop setiap baris CSV dan simpan ke database
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $rowData = array_combine($header, $data); // Gabungkan header dengan data

            $validator = Validator::make($rowData, [
                'Nama' => 'required',
                'NIK' => 'required|unique:ktps,nik',
                'Alamat' => 'required',
                'Tempat Lahir' => 'required',
                'Tanggal Lahir' => 'required|date',
            ]);

            if ($validator->fails()) {
                continue; // Abaikan baris yang tidak valid
            }

            try {
                Ktp::create([
                    'nama' => $rowData['Nama'],
                    'nik' => $rowData['NIK'],
                    'alamat' => $rowData['Alamat'],
                    'tempat_lahir' => $rowData['Tempat Lahir'],
                    'tanggal_lahir' => $rowData['Tanggal Lahir'],
                ]);
                $imported++;
            } catch (\Exception $e) {
                \Log::error('Import error: ' . $e->getMessage());
            }
        }

        fclose($handle);

        return response()->json([
            'message' => "$imported data berhasil diimport",
        ], 200);
    }


}
