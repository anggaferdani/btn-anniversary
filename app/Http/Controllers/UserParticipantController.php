<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\UserParticipant;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserParticipantExport;

class UserParticipantController extends Controller
{
    public function scan() {
        return view('backend.pages.tenant.scan');
    }

    public function autocomplete(Request $request)
    {
        $query = Participant::with('instansi')->where('verification', 1)->where('attendance', 1)->where('status', 1);

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

        $userId = Auth::id();
        foreach ($participants as $participant) {
            $userParticipant = UserParticipant::where('user_id', $userId)
                                              ->where('participant_id', $participant->id)
                                              ->where('point', 1)
                                              ->where('status', 1)
                                              ->first();
    
            $participant->disableButton = $userParticipant ? true : false;
            $participant->instansi = $participant->instansi->name;
        }

        return response()->json(['participants' => $participants]);
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
                                            ->where('status', 1)
                                            ->first();

            if ($userParticipant) {
                return response()->json(['error' => 'Total point anda ' . $participant->point], 400);
            }

            return response()->json([
                'success' => 'Point berhasil ditambahkan',
                'name' => $participant->name,
                'qrcode' => $participant->qrcode,
            ]);
        }

        return response()->json(['error' => 'Participant not found'], 404);
    }

    public function pointOk($qrcode)
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
                                            ->where('status', 1)
                                            ->first();

            if ($userParticipant) {
                return response()->json(['error' => 'Total point anda: {$participant->point}'], 400);
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
                'success' => 'Point berhasil ditambahkan',
                'name' => $participant->name,
                'qrcode' => $participant->qrcode,
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

            if ($request->has('export') && $request->export == 'excel') {
                $fileName = 'user-participant-' . Carbon::now()->format('Y-m-d') . '.xlsx';
                return Excel::download(new UserParticipantExport($userParticipants->items()), $fileName);
            }

        return view('backend.pages.tenant.history', compact('userParticipants', 'search'));
    }
}
