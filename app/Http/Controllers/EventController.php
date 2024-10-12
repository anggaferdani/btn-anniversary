<?php

namespace App\Http\Controllers;

use App\Models\Zoom;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function leaderboard() {
        return view('backend.pages.leaderboard');
    }

    public function onlineEvent() {
        $zoom = Zoom::first()->get();

        if ($zoom->link == null) {
            return redirect()->route('index');
        } else {
            return redirect()->away($zoom->link);
        }
    }
}
