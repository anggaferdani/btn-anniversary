<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Score;
use App\Models\Setting;
use App\Models\Participant;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function leaderboard() {
        return view('quiz.leaderboard');
    }

    public function ajaxLeaderboard(Request $request)
    {
        $participants = Participant::join('scores', 'participants.id', '=', 'scores.participant_id')
            ->where('participants.verification', 1)
            ->where('participants.attendance', 1)
            ->where('participants.status', 1)
            ->select('participants.qrcode', 'participants.name', 'scores.score', 'scores.waktu_pengerjaan')
            ->orderBy('scores.score', 'desc')
            ->orderBy('scores.waktu_pengerjaan', 'asc')
            ->take(10)
            ->get()
            ->map(function ($participant) {
                $formattedWaktuPengerjaan = gmdate("i:s", $participant->waktu_pengerjaan);

                return [
                    'qrcode' => $participant->qrcode,
                    'name' => $participant->name,
                    'score' => $participant->score,
                    'waktu_pengerjaan' => $formattedWaktuPengerjaan,
                ];
            });

        return response()->json($participants);
    }

    public function join() {
        $setting = Setting::first();
        $currentTime = Carbon::now();
        $startTime = Carbon::createFromTimeString($setting->jam_mulai);
        $endTime = Carbon::createFromTimeString($setting->jam_selesai);
        
        $canJoin = $currentTime->between($startTime, $endTime);

        return view('quiz.join', compact('canJoin'));
    }

    public function joinPost(Request $request) {
        $request->validate([
            'email' => 'required|',
            'pin' => 'required',
        ]);

        $participant = Participant::where('verification', 1)->where('attendance', 1)->where('status', 1)->where('email', $request['email'])->first();
        $setting = Setting::first();

        if ($participant && $request['pin'] == $setting->pin) {
            $existsInScores = Score::where('participant_id', $participant->id)->first();

            if ($existsInScores) {
                return back()->with('error', 'Sudah mengisi kuis ini sebelumnya');
            }

            return redirect()->route('quiz', ['token' => $participant->token]);
        } else {
            return back()->with('error', 'Email atau PIN salah.');
        }
    }

    public function quiz($token) {
        $quizzes = Quiz::where('status', 1)->inRandomOrder()->get();
        $setting = Setting::first();
        $participant = Participant::where('token', $token)->first();
        $existsInScores = Score::where('participant_id', $participant->id)->first();
        
        return view('quiz.quiz', compact(
            'token',
            'quizzes',
            'setting',
            'existsInScores',
        ));
    }

    public function quizPost(Request $request, $token) {
        $request->validate([
            'waktu_pengerjaan' => 'required',
        ]);
    
        
        $participant = Participant::where('token', $token)->first();

        try {
            $existsInScores = Score::where('participant_id', $participant->id)->first();
    
            if ($existsInScores) {
                return back()->with('error', 'Anda sudah mengikuti kuis ini.');
            } else {
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
            }

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

    public function history(Request $request) {
        $query = Participant::with('score')->has('score')->where('status', 1)->where('verification', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('qrcode', 'like', '%' . $search . '%');
                $q->where('name', 'like', '%' . $search . '%');
                $q->where('email', 'like', '%' . $search . '%');
                $q->where('phone_number', 'like', '%' . $search . '%');
            });
        }

        $participants = $query->latest()->paginate(10);

        return view('quiz.history', compact(
            'participants',
        ));
    }
}
