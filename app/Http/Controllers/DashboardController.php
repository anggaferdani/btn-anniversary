<?php

namespace App\Http\Controllers;

use App\Exports\InstansiExport;
use App\Exports\ParticipantExport;
use App\Models\Instansi;
use App\Models\Participant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class DashboardController extends Controller
{
    public function index(Request $request) {
        $participantsCount = Participant::where('status', 1)->count();
        $participantsCountOfflineRegister = Participant::where('status', 1)->where('kehadiran', 'onsite')->count();
        $participantsCountOnlineRegister = Participant::where('status', 1)->where('kehadiran', 'online')->count();
        $participantsVerifiedCount = Participant::where('verification', 1)->where('status', 1)->count();
        $participantsUnverifiedCount = Participant::where('verification', 2)->where('status', 1)->count();
        $participantsVerifiedOfflineCountHadir = Participant::where('verification', 1)->where('attendance', 1)->where('kehadiran', 'onsite')->where('status', 1)->count();
        $participantsVerifiedOfflineCountNotHadir = Participant::where('verification', 1)->where('attendance', 2)->where('kehadiran', 'onsite')->where('status', 1)->count();

        $participantsOnlineCount = Participant::where('verification', 1)->where('kehadiran', 'online')->where('status', 1)->count();
        $participantsOfflineCount = Participant::where('verification', 1)->where('kehadiran', 'onsite')->where('status', 1)->count();

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

        return view('backend.pages.dashboard', compact('participantsCountOnlineRegister', 'participantsCountOfflineRegister' ,'participantsCount', 'participantsVerifiedCount', 'participantsUnverifiedCount', 'participantsVerifiedOfflineCountHadir', 'participantsVerifiedOfflineCountNotHadir', 'instansis', 'participantsOnlineCount', 'participantsOfflineCount'));
    }

    public function exportExcel()
    {
        return Excel::download(new InstansiExport, 'data_kehadiran_instansi.xlsx');
    }

    public function participantExcel()
    {

        return Excel::download(new ParticipantExport, 'participant.xlsx');


    }
}
