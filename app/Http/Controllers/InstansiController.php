<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index(Request $request) {
        $query = Instansi::where('status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $instansis = $query->latest()->paginate(10);

        return view('backend.pages.instansi', compact(
            'instansis',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'max_participant' => 'required',
        ]);

        try {
            $array = [
                'name' => $request['name'],
                'max_participant' => $request['max_participant'],
            ];

            Instansi::create($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {
        $instansi = Instansi::find($id);

        $request->validate([
            'name' => 'required',
            'max_participant' => 'required',
        ]);

        try {
            $array = [
                'name' => $request['name'],
                'max_participant' => $request['max_participant'],
            ];

            $instansi->update($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $instansi = Instansi::find($id);

            $instansi->update([
                'status' => 2,
            ]);

            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
