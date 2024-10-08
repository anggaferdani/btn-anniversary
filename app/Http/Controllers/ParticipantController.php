<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function index(Request $request) {
        $query = Participant::where('status', 1);

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

        return view('backend.pages.participant', compact(
            'participants',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $participantCount = Participant::lockForUpdate()->count() + 1;

            $qrcode = '';

            if ($participantCount >= 1 && $participantCount <= 2) {
                $qrcode = 'B' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($participantCount >= 3 && $participantCount <= 200) {
                $qrcode = 'U' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($participantCount >= 201 && $participantCount <= 300) {
                $qrcode = 'M' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($participantCount >= 301 && $participantCount <= 400) {
                $qrcode = 'N' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($participantCount >= 401) {
                $qrcode = 'F' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
            }
            
            $array = [
                'qrcode' => $qrcode,
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
            ];

            Participant::create($array);

            DB::commit();
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {
        $participant = Participant::find($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        try {
            $array = [
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
            ];

            if($request['password']){
                $array['password'] = bcrypt($request['password']);
            }

            $participant->update($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $participant = Participant::find($id);

            $participant->update([
                'status' => 2,
            ]);

            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
