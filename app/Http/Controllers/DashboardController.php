<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $participantsCount = Participant::count();
        $participantsVerifiedCount = Participant::where('verification', 1)->count();
        $participantsVerifiedOfflineCountHadir = Participant::where('verification', 1)->where('attendance', 1)->where('kehadiran', 'onsite')->count();
        $participantsVerifiedOfflineCountNotHadir = Participant::where('verification', 1)->where('attendance', 2)->where('kehadiran', 'onsite')->count();

        $participantsOnlineCount = Participant::where('verification', 1)->where('kehadiran', 'online')->count();
        $participantsOfflineCount = Participant::where('verification', 1)->where('kehadiran', 'offline')->count();


        $participants = Participant::where('attendance', 1)->with('instansi')->orderBy('updated_at', 'desc')->get();

        $query = Participant::where('status', 1)->where('attendance', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('qrcode', 'like', '%' . $search . '%');
                $q->where('name', 'like', '%' . $search . '%');
                $q->where('email', 'like', '%' . $search . '%');
                $q->where('phone_number', 'like', '%' . $search . '%');
            });
        }

        $attendanceParticipants = $query->with('instansi')->latest()->paginate(10);
        
        $participantsOfflineCount = Participant::where('verification', 1)->where('kehadiran', 'offline')->count();
        return view('backend.pages.dashboard', compact('participants', 'participantsCount', 'participantsVerifiedCount', 'participantsVerifiedOfflineCountHadir', 'participantsVerifiedOfflineCountNotHadir', 'attendanceParticipants', 'participantsOnlineCount', 'participantsOfflineCount'));
    }
}
