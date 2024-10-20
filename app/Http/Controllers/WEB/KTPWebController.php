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

    public function create()
    {
        return view('ktp.create'); // Menampilkan form tambah KTP
    }
}
