<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Configuration\Variable;

class RegistrationPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.pages.registration.registration');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function verify($token) {
        
        $participant = Participant::where('token', $token)->first();
        
        $participantCount = Participant::lockForUpdate()->count() + 1;
        
        $qrcode = '';

        if ($participantCount >= 1 && $participantCount <= 100) {
            $qrcode = 'B' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
        } elseif ($participantCount >= 101 && $participantCount <= 200) {
            $qrcode = 'U' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
        } elseif ($participantCount >= 201 && $participantCount <= 300) {
            $qrcode = 'M' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
        } elseif ($participantCount >= 301 && $participantCount <= 400) {
            $qrcode = 'N' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
        } elseif ($participantCount >= 401) {
            $qrcode = 'F' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
        }


        $participant->update([
            'qrcode' => $qrcode,
            'verification' => 1,
        ]);

        return view('frontend.pages.registration.invitation', compact('participant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
        ]);

        DB::beginTransaction();

        try {
            

            $token = $this->generateUniqueToken(12);
            
            $array = [
                'token' => $token,
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
            ];

            $participant = Participant::create($array);

            if ($participant && $participant->email) {
                $url = route('registration.verify', ['token' => $participant->token]);

                $mail = [
                    'to' => $participant->email,
                    'email' => 'example@gmail.com',
                    'from' => 'Example',
                    'subject' => 'Example',
                    'url' => $url,
                ];

                Mail::send('emails.verification', $mail, function($message) use ($mail){
                    $message->to($mail['to'])
                    ->from($mail['email'], $mail['from'])
                    ->subject($mail['subject']);
                });
            }

            DB::commit();
    
            return redirect()->back()->with('success', 'A verification email has been sent to ' . $participant->email . '. Please check your inbox to confirm your registration.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    private function generateUniqueToken($length = 12) {
        do {
            $token = bin2hex(random_bytes($length / 2));
        } while (Participant::where('token', $token)->exists());
    
        return $token;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
