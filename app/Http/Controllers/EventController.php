<?php

namespace App\Http\Controllers;

use App\Models\Zoom;
use App\Models\Participant;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function leaderboard() {
        return view('backend.pages.leaderboard');
    }

    public function ajaxLeaderboard(Request $request)
    {
        $participants = Participant::where('verification', 1)->where('attendance', 1)->where('status', 1)->orderBy('point', 'desc')->take(50)->get();

        return response()->json($participants);
    }

    public function onlineEvent() {
        $zoom = Zoom::first();

        if ($zoom->link == null) {
            return redirect()->route('index');
        } else {
            return redirect()->away($zoom->link);
        }
    }
}
