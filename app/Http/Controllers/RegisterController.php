<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Participant;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register() {
        $instansis = Instansi::where('status', 1)->get();

        return view('backend.pages.register', compact(
            'instansis',
        ));
    }

    public function postRegister(Request $request) {
        $request->validate([
            'name' => 'required',
            'instansi_id' => 'required',
            'email' => 'required|email',
        ]);

        try {
            if (empty($request->qrcode)) {
                $qrcode = $this->generateQrcode();
            } else {
                $existingParticipant = Participant::where('qrcode', $request->qrcode)->first();
    
                if (!$existingParticipant || empty($request->qrcode)) {
                    $qrcode = $request->qrcode;
                } else {
                    $qrcode = $this->generateQrcode();
                }
            }
            
            $token = $this->generateUniqueToken(12);

            $array = [
                'qrcode' => $qrcode,
                'token' => $token,
                'name' => $request['name'],
                'instansi_id' => $request['instansi_id'],
                'email' => $request['email'],
                'kehadiran' => $request['kehadiran'],
                'kendaraan' => $request['kendaraan'],
                'verification' => 1,
                'attendance' => 1,
            ];

            Participant::create($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    private function generateQrcode() {
        $existingQRCodes = Participant::whereNotNull('qrcode')->where('status', 1)
            ->pluck('qrcode')
            ->toArray();

        $qrcode = null;

        $qrcode = $this->findAvailableQRCode($existingQRCodes, 'B', 1, 100);
        if (!$qrcode) {
            $qrcode = $this->findAvailableQRCode($existingQRCodes, 'U', 1, 100);
        }
        if (!$qrcode) {
            $qrcode = $this->findAvailableQRCode($existingQRCodes, 'M', 1, 100);
        }
        if (!$qrcode) {
            $participantCount = Participant::whereNotNull('qrcode')
                ->where('qrcode', 'like', 'N%')
                ->lockForUpdate()
                ->count();
            $qrcode = 'N' . str_pad($participantCount + 1, 3, '0', STR_PAD_LEFT);
        }
    
        return $qrcode;
    }

    private function findAvailableQRCode($existingQRCodes, $prefix, $start, $end)
    {
        for ($i = $start; $i <= $end; $i++) {
            $formattedCode = $prefix . str_pad($i, 3, '0', STR_PAD_LEFT);
            if (!in_array($formattedCode, $existingQRCodes)) {
                return $formattedCode;
            }
        }
        return null;
    }

    private function generateUniqueToken($length = 12) {
        do {
            $token = bin2hex(random_bytes($length / 2));
        } while (Participant::where('token', $token)->exists());
    
        return $token;
    }
}
