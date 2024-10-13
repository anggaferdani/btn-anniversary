<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizAdminController extends Controller
{
    public function index(Request $request) {
        $query = Quiz::where('status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('soal', 'like', '%' . $search . '%');
            });
        }

        $quizzes = $query->latest()->paginate(10);

        return view('backend.pages.quiz', compact(
            'quizzes',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        $request->validate([
            'soal' => 'required',
            'jawaban_a' => 'required',
            'jawaban_b' => 'required',
            'jawaban_c' => 'required',
            'jawaban_d' => 'required',
            'jawaban' => 'required',
        ]);

        try {
            $array = [
                'soal' => $request['soal'],
                'jawaban_a' => $request['jawaban_a'],
                'jawaban_b' => $request['jawaban_b'],
                'jawaban_c' => $request['jawaban_c'],
                'jawaban_d' => $request['jawaban_d'],
                'jawaban' => $request['jawaban'],
            ];

            Quiz::create($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {
        $quiz = Quiz::find($id);

        $request->validate([
            'soal' => 'required',
            'jawaban_a' => 'required',
            'jawaban_b' => 'required',
            'jawaban_c' => 'required',
            'jawaban_d' => 'required',
            'jawaban' => 'required',
        ]);

        try {
            $array = [
                'soal' => $request['soal'],
                'jawaban_a' => $request['jawaban_a'],
                'jawaban_b' => $request['jawaban_b'],
                'jawaban_c' => $request['jawaban_c'],
                'jawaban_d' => $request['jawaban_d'],
                'jawaban' => $request['jawaban'],
            ];

            $quiz->update($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $quiz = Quiz::find($id);

            $quiz->update([
                'status' => 2,
            ]);

            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
