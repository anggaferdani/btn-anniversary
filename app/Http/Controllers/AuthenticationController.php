<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{
    public function login() {
        return view('backend.pages.authentications.login');
    }

    public function postLogin(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $credentials = array(
            'email' => $request['email'],
            'password' => $request['password'],
        );

        if (Auth::guard('web')->attempt($credentials)) {
            if (auth()->user()->status == 1) {
                if (auth()->user()->role == 1) {
                    return redirect()->route('admin.dashboard');
                } elseif (auth()->user()->role == 2) {
                    return redirect()->route('receptionist.dashboard');
                } elseif (auth()->user()->role == 3) {
                    return redirect()->route('tenant.dashboard');
                } else {
                    return redirect()->route('login')->with('error', 'The account level you entered does not match');
                }
            } else {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('error', 'Your account has been disabled');
            }
        } else {
            return redirect()->route('login')->with('error', 'The email or password you entered is incorrect. Please try again');
        }
    }

    public function logout() {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function resendEmailVerification($token) {
        $participant = Participant::where('token', $token)->first();

        if ($participant && $participant->email) {
            $url = route('registration.verify', ['token' => $participant->token]);

            $mail = [
                'to' => $participant->email,
                'email' => 'example@gmail.com',
                'from' => 'Example',
                'subject' => 'Example',
                'url' => $url,
            ];

            try {
                Mail::send('emails.verification', $mail, function($message) use ($mail){
                    $message->to($mail['to'])
                    ->from($mail['email'], $mail['from'])
                    ->subject($mail['subject']);
                });

                return redirect()->back()->with('success', 'Email verification has been resent successfully.');
            } catch (\Throwable $th) {
                return back()->with('error', 'Failed to resend email verification.');
            }
        } else {
            return redirect()->back()->with('error', 'Email not found.');
        }
    }
}
