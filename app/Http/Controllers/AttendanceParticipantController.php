<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Exports\ParticipantExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceParticipantController extends Controller
{
    public function index(Request $request) {
        $query = Participant::where('status', 1)->where('verification', 1)->where('kehadiran', 'onsite')->where('attendance', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('qrcode', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('kehadiran', 'like', '%' . $search . '%')
                  ->orWhereHas('instansi', function($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->has('export') && $request->export == 'excel') {
            $fileName = 'participant-' . Carbon::now()->format('Y-m-d') . '.xlsx';
            return Excel::download(new ParticipantExport($query->get()), $fileName);
        }

        $attendanceParticipants = $query->latest()->paginate(10);

        return view('backend.pages.attendance-participant', compact(
            'attendanceParticipants',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        
        DB::beginTransaction();
        
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10',
            ]);

            $attendanceParticipantCount = Participant::lockForUpdate()->count() + 1;

            $qrcode = '';

            if ($attendanceParticipantCount >= 1 && $attendanceParticipantCount <= 2) {
                $qrcode = 'B' . str_pad($attendanceParticipantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($attendanceParticipantCount >= 3 && $attendanceParticipantCount <= 200) {
                $qrcode = 'U' . str_pad($attendanceParticipantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($attendanceParticipantCount >= 201 && $attendanceParticipantCount <= 300) {
                $qrcode = 'M' . str_pad($attendanceParticipantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($attendanceParticipantCount >= 301 && $attendanceParticipantCount <= 400) {
                $qrcode = 'N' . str_pad($attendanceParticipantCount, 3, '0', STR_PAD_LEFT);
            } elseif ($attendanceParticipantCount >= 401) {
                $qrcode = 'F' . str_pad($attendanceParticipantCount, 3, '0', STR_PAD_LEFT);
            }
            
            $array = [
                'qrcode' => $qrcode,
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'verification' => 1,
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
        $attendanceParticipant = Participant::find($id);
        
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10',
            ]);

            $array = [
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
            ];

            if($request['password']){
                $array['password'] = bcrypt($request['password']);
            }

            $attendanceParticipant->update($array);
    
            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $attendanceParticipant = Participant::find($id);

            $attendanceParticipant->update([
                'status' => 2,
            ]);

            return redirect()->back()->with('success', 'Success.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
