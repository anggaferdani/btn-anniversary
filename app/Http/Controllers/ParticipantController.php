<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\UserParticipant;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = Participant::where('verification', 1)->where('attendance', 2)->where('kehadiran', 'onsite')->where('status', 1);

        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('qrcode', $search)
              ->orWhere('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('phone_number', 'like', '%' . $search . '%');
        });

        $participants = $query->take(3)->get();

        if ($participants->isEmpty()) {
            return response()->json(['message' => 'No participants found'], 404);
        }

        return response()->json($participants);
    }

    public function downloadId($token) {
        $participant = Participant::where('token', $token)->where('verification', 1)->where('status', 1)->first();
        $filePath = public_path('images/' . $participant->image);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function downloadQr($token) {
        $participant = Participant::where('token', $token)->where('verification', 1)->where('status', 1)->first();
        $filePath = public_path('qrcodes/' . $participant->image);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
    
    public function scan() {
        $participants = Participant::where('status', 1)->where('verification', 1)->where('attendance', 1)->get();
        return view('backend.pages.receptionist.scan', compact(
            'participants',
        ));
    }

    public function attendance($qrcode)
    {
        $participant = Participant::where('verification', 1)->where('qrcode', $qrcode)->first();

        if ($participant) {
            if ($participant->status == 2) {
                return response()->json(['error' => 'Participant tidak aktif'], 400);
            }

            if ($participant->attendance == 1) {
                return response()->json(['error' => 'Participant sudah absen kehadiran'], 400);
            }

            return response()->json([
                'success' => 'Participant',
                'name' => $participant->name,
                'qrcode' => $participant->qrcode,
                'email' => $participant->email,
                'phone_number' => $participant->phone_number,
                'point' => $participant->point,
            ]);
        }

        return response()->json(['error' => 'Participant not found'], 404);
    }

    public function attendanceOk($qrcode)
    {
        $participant = Participant::where('verification', 1)->where('qrcode', $qrcode)->first();

        if ($participant) {
            if ($participant->status == 2) {
                return response()->json(['error' => 'Participant tidak aktif'], 400);
            }

            if ($participant->attendance == 1) {
                return response()->json(['error' => 'Participant sudah absen kehadiran'], 400);
            }

            $participant->update(['attendance' => 1]);

            return response()->json([
                'success' => 'Absen kehadiran participant berhasil ditambahkan',
                'name' => $participant->name,
                'qrcode' => $participant->qrcode,
                'email' => $participant->email,
                'phone_number' => $participant->phone_number,
                'point' => $participant->point,
            ]);
        }

        return response()->json(['error' => 'Participant not found'], 404);
    }

    public function hadir($id) {
        try {
            $participant = Participant::find($id);

            $participant->update([
                'verification' => 1,
                'attendance' => 1,
            ]);

            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function onsite($id) {
        try {
            $participant = Participant::find($id);

            $participant->update([
                'kehadiran' => 'onsite',
                'attendance' => 1,
            ]);

            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function index(Request $request) {
        $query = Participant::where('status', 1);
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('qrcode', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('kehadiran', 'like', '%' . $search . '%')
                  ->orWhereHas('instansi', function($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->has('instansi') && !empty($request->input('instansi'))) {
            $instansi = $request->input('instansi');
            $query->whereHas('instansi', function ($q) use ($instansi) {
                $q->where('id', $instansi);
            });
        }
        

        if ($request->has('kehadiran') && !empty($request->input('kehadiran'))) {
            $kehadiran = $request->input('kehadiran');
            $query->where('kehadiran', $kehadiran);
        }
    
        if ($request->has('status') && !empty($request->input('status'))) {
            $status = $request->input('status');
            $query->where('verification', $status);
        }
    
        $participants = $query->latest()->paginate(10);
    
        $instansis = Instansi::where('status', 1)->withCount(['participants' => function ($q) {
            $q->where('status', 1);
        }])->get();
    
        return view('backend.pages.participant', compact(
            'participants',
            'instansis',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        
        DB::beginTransaction();
        
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10',
                'instansi_id' => 'required',
                'kehadiran' => 'required',
            ]);

            $participantCount = Participant::whereNotNull('qrcode')->lockForUpdate()->count();

            if ($participantCount === 0) {
                $qrcode = 'B001';
            } elseif ($participantCount === 1) {
                $qrcode = 'B002';
            } else {
                $participantCount++;
    
                if ($participantCount <= 100) {
                    $qrcode = 'B' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 100 && $participantCount <= 200) {
                    $qrcode = 'U' . str_pad($participantCount - 100, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 200 && $participantCount <= 300) {
                    $qrcode = 'M' . str_pad($participantCount - 200, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 300 && $participantCount <= 400) {
                    $qrcode = 'N' . str_pad($participantCount - 300, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 400) {
                    $qrcode = 'N' . str_pad($participantCount - 300, 3, '0', STR_PAD_LEFT);
                }
            }

            $token = $this->generateUniqueToken(12);
            
            $array = [
                'qrcode' => $qrcode,
                'token' => $token,
                'name' => $request['name'],
                'instansi_id' => $request['instansi_id'],
                'jabatan' => $request['jabatan'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'kehadiran' => $request['kehadiran'],
                'kendaraan' => $request['kendaraan'],
                'verification' => 1,
                'attendance' => 2,
            ];

            Participant::create($array);

            DB::commit();
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {
        $participant = Participant::find($id);
        
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10',
                'instansi_id' => 'required',
                'kehadiran' => 'required',
            ]);

            $array = [
                'name' => $request['name'],
                'instansi_id' => $request['instansi_id'],
                'jabatan' => $request['jabatan'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'kehadiran' => $request['kehadiran'],
                'kendaraan' => $request['kendaraan'],
            ];

            $participant->update($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $participant = Participant::find($id);
            if (!$participant) {
                return back()->with('error', 'Participant not found.');
            }
    
            $userParticipants = UserParticipant::where('participant_id', $participant->id)->get(); 
    
            if ($userParticipants->isNotEmpty()) {
                foreach ($userParticipants as $userParticipant) {
                    $userParticipant->update([
                        'status' => 2,
                    ]);
                }
            }
    
            $existingQrcodes = Participant::where('qrcode', 'like', 'testing%')
                ->orderByRaw('CAST(SUBSTRING(qrcode, 8) AS UNSIGNED) ASC')
                ->pluck('qrcode')
                ->toArray();
    
            $nextNumber = 1;
            foreach ($existingQrcodes as $qrcode) {
                $number = (int)substr($qrcode, 7);
                if ($number != $nextNumber) {
                    break;
                }
                $nextNumber++;
            }
    
            $newQrcode = 'testing' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    
            $participant->update([
                'qrcode' => $newQrcode,
                'kehadiran' => 'online',
                'status' => 2,
            ]);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    private function generateUniqueToken($length = 12) {
        do {
            $token = bin2hex(random_bytes($length / 2));
        } while (Participant::where('token', $token)->exists());
    
        return $token;
    }
}
