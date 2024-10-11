<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function leaderboard() {
        return view('backend.pages.leaderboard');
    }
}
