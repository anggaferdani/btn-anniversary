<?php

namespace App\Http\Controllers;

use App\Models\Zoom;
use Illuminate\Http\Request;

class ZoomContoller extends Controller
{
    public function index(Request $request) {
        $zooms = Zoom::first()->get();

        return view('backend.pages.zoom', compact(
            'zooms',
        ));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {
        $zoom = Zoom::find($id);

        $request->validate([
            'link' => 'nullable',
        ]);

        try {
            $array = [
                'link' => $request['link'],
            ];

            $zoom->update($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id) {}
}
