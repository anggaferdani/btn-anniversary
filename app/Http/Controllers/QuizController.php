<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Score;
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
            $existsInScores = Score::where('participant_id', $participant->id)->first();

            if ($existsInScores) {
                return back()->with('error', 'Anda sudah mengikuti kuis ini.');
            }

            return redirect()->route('quiz', ['token' => $participant->token]);
        } else {
            return back()->with('error', 'Email atau PIN salah.');
        }
    }

    public function quiz($token) {
        $quizzes = Quiz::where('status', 1)->inRandomOrder()->get();
        
        return view('quiz.quiz', compact(
            'token',
            'quizzes',
        ));
    }

    public function quizPost(Request $request, $token) {
        $request->validate([
            'waktu_pengerjaan' => 'required',
        ]);
    
        $participant = Participant::where('verification', 1)
                                  ->where('attendance', 1)
                                  ->where('status', 1)
                                  ->where('token', $token)
                                  ->orderBy('id')
                                  ->first();
    
        try {
            $waktuPengerjaan = $request->input('waktu_pengerjaan');
    
            $correctAnswers = 0;
    
            $quizzes = Quiz::where('status', 1)->get();
    
            foreach ($quizzes as $quiz) {
                $userAnswer = $request->input("jawaban")[$quiz->id] ?? null;
                if ($userAnswer == $quiz->jawaban) {
                    $correctAnswers++;
                }
            }
    
            $score = $correctAnswers * 10;
    
            $array = [
                'participant_id' => $participant->id,
                'score' => $score,
                'waktu_pengerjaan' => $waktuPengerjaan,
            ];
    
            Score::create($array);
    
            return redirect()->route('result', ['token' => $participant->token]);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function result($token) {
        $participant = Participant::where('verification', 1)->where('attendance', 1)->where('status', 1)->where('token', $token)->first();
        $score = Score::where('status', 1)->where('participant_id', $participant->id)->first();
        
        return view('quiz.result', compact(
            'participant',
            'score',
        ));
    }
}
