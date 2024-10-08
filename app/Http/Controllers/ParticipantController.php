<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function scan() {
        return view('backend.pages.receptionist.scan');
    }

    public function attendance($qrcode)
    {
        $participant = Participant::where('verification', 1)->where('qrcode', $qrcode)->first();

        if ($participant) {
            if ($participant->status == 2) {
                return response()->json(['error' => 'Participant tidak aktif'], 400);
            }

            if ($participant->attendance == 1) {
                return response()->json(['error' => 'Attendance has already been marked'], 400);
            }

            $participant->update(['attendance' => 1]);

            return response()->json([
                'success' => 'Absen kehadiran participant berhasil ditambahkan',
                'name' => $participant->name,
                'qrcode' => $participant->qrcode,
                'email' => $participant->email,
                'phone' => $participant->phone,
                'point' => $participant->point,
            ]);
        }

        return response()->json(['error' => 'Participant not found'], 404);
    }

    public function index(Request $request) {
        $query = Participant::where('status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('qrcode', 'like', '%' . $search . '%');
                $q->where('name', 'like', '%' . $search . '%');
                $q->where('email', 'like', '%' . $search . '%');
                $q->where('phone_number', 'like', '%' . $search . '%');
            });
        }

        $participants = $query->latest()->paginate(10);

        return view('backend.pages.participant', compact(
            'participants',
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
                    $qrcode = 'F' . str_pad($participantCount - 400, 3, '0', STR_PAD_LEFT);
                }
            }

            $token = $this->generateUniqueToken(12);
            
            $array = [
                'qrcode' => $qrcode,
                'token' => $token,
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
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
            ]);

            $array = [
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
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

            $participant->update([
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
