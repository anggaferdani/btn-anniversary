<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Participant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Configuration\Variable;

class RegistrationPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansis = Instansi::withCount('participants')->where('status', 1)->get();

        return view('frontend.pages.registration.registration', compact('instansis'));
    }

    public function indexOnline()
    {
        $instansis = Instansi::withCount('participants')->where('status', 1)->get();

        return view('frontend.pages.registration.registrationOnline', compact('instansis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function verify($token)
    {
        $participant = Participant::with('instansi')->where('token', $token)->first();

        if (!empty($participant->qrcode)) {
            return view('frontend.pages.registration.invitation', compact('participant'));
        } else {
            $participantCount = Participant::whereNotNull('qrcode')->lockForUpdate()->count();

            if ($participantCount === 0) {
                $qrcode = 'B001';
            } elseif ($participantCount === 1) {
                $qrcode = 'B002';
            } else {
                $participantCount = Participant::whereNotNull('qrcode')->lockForUpdate()->count() + 1;

                if ($participantCount >= 3 && $participantCount <= 100) {
                    $qrcode = 'B' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount >= 101 && $participantCount <= 200) {
                    $qrcode = 'U' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount >= 201 && $participantCount <= 300) {
                    $qrcode = 'M' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount >= 301) {
                    $qrcode = 'N' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                }
            }

            $participant->update([
                'qrcode' => $qrcode,
                'verification' => 1,
            ]);

            return view('frontend.pages.registration.invitation', compact('participant'));
        }
    }

    public function sendImage(Request $request, $token) {
        $participant = Participant::where('token', $token)->first();

        if (!$participant) {
            return response()->json(['error' => 'Participant not found.'], 404);
        }

        // Decode the image data
        $imageData = $request->input('imageData');
//        dd($imageData);
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);

            // Define the public path for saving the image
            $publicPath = public_path('images');
            $fileName = $participant->qrcode . '.jpg';
            $filePath = $publicPath . '/' . $fileName;

            // Create directory if it doesn't exist
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }

            // Save the image
            file_put_contents($filePath, $imageData);

            $participant->update([
                'image' => $fileName,
            ]);

            $url = route('registration.downloadImage', ['token' => $participant->token]);
            // Prepare email data
            $mail = [
                'to' => $participant->email,
                'from_email' => 'example@gmail.com',
                'from_name' => 'BTN Anniversary',
                'subject' => 'Kartu QR Code',
                'name' => $participant->name,
                'image' => $participant->image,
                'token' => $participant->token,
                'url' => $url,
            ];

            try {
                Mail::send('emails.invitation', $mail, function($message) use ($mail, $filePath) {
                    $message->to($mail['to'])
                            ->from($mail['from_email'], $mail['from_name'])
                            ->subject($mail['subject'])
                            ->attach($filePath); // Attach the saved image
                });

                // Set a flash message to indicate success
                session()->flash('success', 'Image sent successfully to ' . $mail['to']);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to send email: ' . $e->getMessage());
            }
        } else {
            session()->flash('error', 'Invalid image data.');
        }

        // Redirect to the invitation view
        return view('frontend.pages.registration.invitation', compact('participant'));
    }

    public function downloadImage($token) {
        $participant = Participant::where('token', $token)->first();

        if (!$participant || !$participant->image) {
            return response()->json(['error' => 'Image not found.'], 404);
        }

        // Tentukan path gambar
        $filePath = public_path('images/' . $participant->image);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Kembalikan file sebagai response download
        return response()->download($filePath, $participant->image);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'instansi_id' => 'required',
            'jabatan' => 'required',
        ]);

        $participantCheck = Participant::where('email', $request->email)->whereNotNull('qrcode')->first();

        if ($participantCheck) {
            $participant = Participant::where('qrcode', $participantCheck->qrcode)->where('verification', 1)->first();

            try {
                $url = route('registration.verify', ['token' => $participant->token]);

                $mail = [
                    'to' => $participant->email,
                    'email' => 'btnfestivalevent@gmail.com',
                    'from' => 'BTN Event',
                    'subject' => 'Verification Email | BTN ANNIVERSARY 2024',
                    'url' => $url,
                ];

                Mail::send('emails.verification', $mail, function($message) use ($mail){
                    $message->to($mail['to'])
                    ->from($mail['email'], $mail['from'])
                    ->subject($mail['subject']);
                });
                return redirect()->back()->with('success', 'notifikasi id card sudah terkirim via email ' . $participant->email);
            } catch (\Throwable $th) {
                return back()->with('error', $th->getMessage());
            }

        } else {
            DB::beginTransaction();

            try {
                $token = $this->generateUniqueToken(12);

                $array = [
                    'token' => $token,
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone_number' => $request['phone_number'],
                    'instansi_id' => $request['instansi_id'],
                    'jabatan' => $request['jabatan'],
                    'kehadiran' => 'onsite',
                ];

                $participant = Participant::create($array);

                if ($participant && $participant->email) {
                    $url = route('registration.verify', ['token' => $participant->token]);

                    $mail = [
                        'to' => $participant->email,
                        'email' => 'btnfestivalevent@gmail.com',
                        'from' => 'BTN Event',
                        'subject' => 'Verification Email | BTN ANNIVERSARY 2024',
                        'url' => $url,
                    ];

                    Mail::send('emails.verification', $mail, function($message) use ($mail){
                        $message->to($mail['to'])
                        ->from($mail['email'], $mail['from'])
                        ->subject($mail['subject']);
                    });
                }

                DB::commit();

                return redirect()->back()->with('success', 'ID Card sudah terkirim via email '. $participant->email);
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with('error', $th->getMessage());
            }
        }
    }

    public function storeOnline(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'instansi_id' => 'required',
            'jabatan' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $token = $this->generateUniqueToken(12);

            $array = [
                'token' => $token,
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'instansi_id' => $request['instansi_id'],
                'jabatan' => $request['jabatan'],
                'verification' => 1,
                'kehadiran' => 'online',
            ];

            Participant::create($array);

            DB::commit();

            return redirect()->back()->with('success', 'Pendaftaran Berhasil, Link zoom akan kami kirimkan pada tanggal 14 Oktober 2024');
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
