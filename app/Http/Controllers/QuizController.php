<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function join() {
        return view('quiz.join');
    }

    public function joinPost(Request $request) {
        $request->validate([
            'email' => 'required|',
            'pin' => 'required',
        ]);

        $participant = Participant::where('verification', 1)->where('attendance', 1)->where('status', 1)->where('email', $request['email'])->first();

        if ($participant && $request['pin'] == 123456) {
            return redirect()->route('quiz');
        } else {
            return back()->with('error', 'Email atau PIN salah.');
        }
    }

    public function quiz() {
        return view('quiz.quiz');
    }
}
