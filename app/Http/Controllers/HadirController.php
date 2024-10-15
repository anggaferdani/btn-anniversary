<?php

namespace App\Http\Controllers;

use App\Models\Hadir;
use App\Models\Instansi;
use App\Models\Participant;
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

    public function check($qrcode)
    {
        $participant = Participant::where('verification', 1)->where('qrcode', $qrcode)->where('status', 1)->first();

        if ($participant) {
            return response()->json([
                'success' => 'Participant',
                'qrcode' => $participant->qrcode,
                'nama' => $participant->name,
                'instansi' => $participant->instansi->name,
            ]);
        }

        return response()->json(['error' => 'Participant not found'], 404);
    }

    public function checkOk($qrcode)
    {
        $participant = Participant::where('verification', 1)->where('qrcode', $qrcode)->where('status', 1)->first();

        if ($participant) {

            $array = [
                'qrcode' => $participant->qrcode,
                'nama' => $participant->name,
                'instansi' => $participant->instansi->name,
            ];

            $hadir = Hadir::create($array);

            return response()->json([
                'success' => 'Kehadiran berhasil ditambahkan',
                'qrcode' => $hadir->qrcode,
                'nama' => $hadir->nama,
                'instansi' => $hadir->instansi,
            ]);
        } else {
            return response()->json(['error' => 'Participant tidak ditemukan'], 404);
        }

    }
}
