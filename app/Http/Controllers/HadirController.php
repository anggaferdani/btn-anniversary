<?php

namespace App\Http\Controllers;

use App\Models\Hadir;
use App\Models\Instansi;
use Illuminate\Http\Request;

class HadirController extends Controller
{
    public function hadir() {
        $instansis = Instansi::where('status', 1)->get();

        return view('backend.pages.hadir', compact(
            'instansis',
        ));
    }

    public function postHadir(Request $request) {
        $request->validate([
            'nama' => 'required',
        ]);

        try {
            $array = [
                'qrcode' => $request['qrcode'],
                'nama' => $request['nama'],
                'instansi' => $request['instansi'],
            ];

            Hadir::create($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
