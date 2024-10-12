<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $participantsCount = Participant::count();
        $participantsVerifiedCount = Participant::where('verification', 1)->count();
        $participantsVerifiedOnlineCount = Participant::where('verification', 1)->where('kehadiran', 'online')->count();
        $participantsVerifiedOfflineCount = Participant::where('verification', 1)->where('kehadiran', 'onsite')->count();

        $participantsAttendanceHistory = Participant::where('attendance', 1)->orderBy('updated_at', 'desc')->get();

        $participants = Participant::where('attendance', 1)->with('instansi')->orderBy('updated_at', 'desc')->get();
        
            
        return view('backend.pages.dashboard', compact('participants', 'participantsCount', 'participantsVerifiedCount', 'participantsVerifiedOnlineCount', 'participantsVerifiedOfflineCount', 'participantsAttendanceHistory'));
    }
}
