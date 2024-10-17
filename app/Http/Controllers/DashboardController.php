<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Participant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        if (auth()->user()->role == 3) {
            return view('backend.pages.dashboard');
        } else {
            $participantsCount = Participant::where('status', 1)->count();
            $participantsVerifiedCount = Participant::where('verification', 1)->where('status', 1)->count();
            $participantsUnverifiedCount = Participant::where('verification', 2)->where('status', 1)->count();
            $participantsVerifiedOfflineCountHadir = Participant::where('verification', 1)->where('attendance', 1)->where('kehadiran', 'onsite')->where('status', 1)->count();
            $participantsVerifiedOfflineCountNotHadir = Participant::where('verification', 1)->where('attendance', 2)->where('kehadiran', 'onsite')->where('status', 1)->count();
    
            $participantsOnlineCount = Participant::where('verification', 1)->where('kehadiran', 'online')->where('status', 1)->count();
            $participantsOfflineCount = Participant::where('verification', 1)->where('kehadiran', 'onsite')->where('status', 1)->count();
    
            $percentageOnline = $participantsCount > 0 ? ($participantsOnlineCount / $participantsCount) * 100 : 0;
            $percentageOffline = $participantsCount > 0 ? ($participantsVerifiedCount / $participantsCount) * 100 : 0;
    
            $percentageHadir = $participantsOfflineCount > 0 ? ($participantsVerifiedOfflineCountHadir / $participantsOfflineCount) * 100 : 0;
            $percentageNotHadir = $participantsOfflineCount > 0 ? ($participantsVerifiedOfflineCountNotHadir / $participantsOfflineCount) * 100 : 0;
            $percentageVerified = $participantsCount > 0 ? ($participantsVerifiedCount / $participantsCount) * 100 : 0;
            $percentageUnverified = $participantsCount > 0 ? ($participantsUnverifiedCount / $participantsCount) * 100 : 0;
    
            $query = Instansi::where('status', 1);
    
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->orWhere('name', 'like', '%' . $search . '%')
                      ->orWhereHas('participants', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%')
                            ->where('kehadiran', 'like', '%' . $search . '%');
                      });
                });
            }
            
            $instansis = $query->with('participants')->latest()->paginate(10);
            
            return view('backend.pages.dashboard', compact(
                'participantsCount', 
                'participantsVerifiedCount', 
                'participantsUnverifiedCount', 
                'participantsVerifiedOfflineCountHadir', 
                'participantsVerifiedOfflineCountNotHadir', 
                'instansis', 
                'participantsOnlineCount', 
                'participantsOfflineCount',
                'percentageHadir',
                'percentageNotHadir',
                'percentageVerified',
                'percentageUnverified',
                'percentageOnline',
                'percentageOffline'
            ));
        }
    }
}
