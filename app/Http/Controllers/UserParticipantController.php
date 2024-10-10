<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\UserParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserParticipantController extends Controller
{
    public function scan() {
        return view('backend.pages.tenant.scan');
    }

    public function point($qrcode)
    {
        $participant = Participant::where('verification', 1)->where('qrcode', $qrcode)->first();

        if ($participant) {
            if ($participant->status == 2) {
                return response()->json(['error' => 'Participant tidak aktif'], 400);
            }

            if ($participant->attendance == 2) {
                return response()->json(['error' => 'Participant belum absen kehadiran'], 400);
            }

            $userId = Auth::id();
            $userParticipant = UserParticipant::where('user_id', $userId)
                                            ->where('participant_id', $participant->id)
                                            ->where('point', 1)
                                            ->first();

            if ($userParticipant) {
                return response()->json(['error' => 'Point sudah ditambahkan sebelumnya untuk user ini dan participant ini'], 400);
            }

            $participant->update([
                'point' => $participant->point + 1
            ]);

            $array = [
                'user_id' => Auth::id(),
                'participant_id' => $participant->id,
                'point' => 1,
            ];

            UserParticipant::create($array);

            return response()->json([
                'success' => '+1 Point berhasil ditambahkan',
                'name' => $participant->name,
                'qrcode' => $participant->qrcode,
                'email' => $participant->email,
                'phone' => $participant->phone,
                'point' => $participant->point,
            ]);
        }

        return response()->json(['error' => 'Participant not found'], 404);
    }

    public function history(Request $request) {
        $search = $request->input('search');
    
        $user = Auth::user();
        
        $userParticipants = UserParticipant::query()
            ->when($user->role == 1, function ($query) use ($user) {
                return $query->where('point', 1)
                             ->where('status', 1);
            })
            ->when($user->role == 3, function ($query) use ($user) {
                return $query->where('user_id', $user->id)
                             ->where('point', 1)
                             ->where('status', 1);
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('participant', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone_number', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('backend.pages.tenant.history', compact('userParticipants', 'search'));
    }
}
