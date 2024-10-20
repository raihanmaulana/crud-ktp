<?php

namespace App\Http\Controllers\WEB;

use App\Models\Ktp;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
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

    public function create()
    {
        return view('ktp.create'); // Menampilkan form tambah KTP
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
}
