<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Participant;
use App\Models\Zoom;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
        // Mengambil instansi dengan status = 1 dan status kehadiran
        $instansis = Instansi::where('status_kehadiran', 'hybrid')->withCount('participants')
                    ->where('status', 1)->orderBy('name', 'asc')
                    ->get(['id', 'name', 'max_participant', 'participants_count', 'status_kehadiran']); // Jangan lupa untuk mengambil kolom status_kehadiran

        return view('frontend.pages.registration.register', compact('instansis'));
    }


    public function indexOnline()
    {
        // Mengambil instansi dengan status = 1 dan status kehadiran
        $instansis = Instansi::withCount('participants')
                    ->where('status', 1)->orderBy('name', 'asc')
                    ->get(['id', 'name', 'max_participant', 'participants_count', 'status_kehadiran']);

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
        $participant = Participant::with('instansi')->where('token', $token)->where('status', 1)->first();

        if (!empty($participant->qrcode)) {
            return view('frontend.pages.registration.invitation', compact('participant'));
        } else {
            $existingQRCodes = Participant::whereNotNull('qrcode')->where('status', 1)
                ->pluck('qrcode')
                ->toArray();

            $qrcode = null;

            $qrcode = $this->findAvailableQRCode($existingQRCodes, 'B', 1, 100);
            if (!$qrcode) {
                $qrcode = $this->findAvailableQRCode($existingQRCodes, 'U', 1, 100);
            }
            if (!$qrcode) {
                $qrcode = $this->findAvailableQRCode($existingQRCodes, 'M', 1, 100);
            }
            if (!$qrcode) {
                $participantCount = Participant::whereNotNull('qrcode')
                    ->where('qrcode', 'like', 'N%')
                    ->lockForUpdate()
                    ->count();
                $qrcode = 'N' . str_pad($participantCount + 1, 3, '0', STR_PAD_LEFT);
            }

            $participant->update([
                'qrcode' => $qrcode,
                'verification' => 1,
            ]);

            $qrCodeData = $participant->qrcode;
            $png = QrCode::format('png')->size(512)->generate($qrCodeData);
            $base64Image = base64_encode($png);
            $publicPath = public_path();
            $directoryPath = $publicPath . '/qrcodes/';
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }
            $fileName = $participant->token . '.png';
            $filePath = $directoryPath . $fileName;
            file_put_contents($filePath, base64_decode($base64Image));

            return view('frontend.pages.registration.invitation', compact('participant'));
        }
    }

    private function findAvailableQRCode($existingQRCodes, $prefix, $start, $end)
    {
        for ($i = $start; $i <= $end; $i++) {
            $formattedCode = $prefix . str_pad($i, 3, '0', STR_PAD_LEFT);
            if (!in_array($formattedCode, $existingQRCodes)) {
                return $formattedCode;
            }
        }
        return null;
    }

    public function sendImage(Request $request, $token) {
        $participant = Participant::where('token', $token)->where('status', 1)->first();
    
        if (!$participant) {
            return response()->json(['error' => 'Participant not found.'], 404);
        }

        // Decode the image data
        $imageData = $request->input('imageData');
        // dd($imageData);
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);

            // Define the public path for saving the image
            $publicPath = public_path('images');
            $fileName = $participant->token . '.png';
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
                'from_email' => 'bumnlearningfestival@gmail.com',
                'from_name' => 'BUMN Learning Festival',
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
                return view('frontend.pages.registration.invitation', compact('participant'));
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to send email: ' . $e->getMessage());
            }
        } else {
            session()->flash('error', 'Invalid image data.');
        }

        return view('frontend.pages.registration.invitation', compact('participant'));
    }

    public function downloadImage($token) {
        $participant = Participant::where('token', $token)->where('status', 1)->first();

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

    public function store(Request $request) {
        // Validasi input dari form
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|min:8|max:13',
            'instansi_id' => 'required',
        ]);
    
        // Kehadiran Onsite (Offline)
        if ($request->kehadiran == "onsite") {
            // Cek apakah peserta sudah terdaftar sebagai peserta online dengan email yang sama
            $participantOnlineCheck = Participant::where('email', $request->email)
                ->where('kehadiran', 'online')
                ->where('verification', 1)
                ->where('status', 1)
                ->first(); 
    
            if ($participantOnlineCheck) {
                return back()->with('error', 'Email Anda sudah terdaftar sebagai peserta Online.');
            }
    
            // Cek apakah peserta sudah memiliki QR code (berarti sudah pernah daftar onsite)
            $participantCheck = Participant::where('email', $request->email)
                ->whereNotNull('qrcode')
                ->where('status', 1)
                ->first();
    
            if ($participantCheck) {
                // Kirim ulang email verifikasi jika sudah terdaftar
                $participant = Participant::where('qrcode', $participantCheck->qrcode)
                    ->where('verification', 1)
                    ->where('status', 1)
                    ->first();
    
                try {
                    $url = route('registration.verify', ['token' => $participant->token]);
    
                    $mail = [
                        'to' => $participant->email,
                        'email' => 'bumnlearningfestival@gmail.com',
                        'from' => 'BUMN Learning Festival',
                        'subject' => 'Verification Email | BUMN LEARNING FESTIVAL 2024',
                        'url' => $url,
                    ];
    
                    Mail::send('emails.verification', $mail, function($message) use ($mail) {
                        $message->to($mail['to'])
                            ->from($mail['email'], $mail['from'])
                            ->subject($mail['subject']);
                    });
    
                    return redirect()->back()->with('success', 'Pendaftaran ulang berhasil. Silahkan cek email ' . $participant->email);
                } catch (\Throwable $th) {
                    return back()->with('error', 'Gagal mengirim email.');
                }
            }
    
            // Cek kuota peserta untuk instansi
            $instansi = Instansi::find($request->instansi_id);
            $participantCount = Participant::where('instansi_id', $request->instansi_id)->where('status', 1)->count();
    
            if ($participantCount > $instansi->max_participant) {
                return redirect()->back()->with('error', 'Kuota pendaftaran On Site untuk instansi ini sudah penuh. Anda Tetap Bisa Mendaftar Secara Online.');
            }
    
            // Buat peserta baru untuk kehadiran onsite
            DB::beginTransaction();
            try {
                $token = $this->generateUniqueToken(12);
    
                $participantData = [
                    'token' => $token,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'instansi_id' => $request->instansi_id,
                    'jabatan' => $request->jabatan,
                    'kehadiran' => 'onsite',
                    'kendaraan' => $request->kendaraan,
                ];
    
                $participant = Participant::create($participantData);
    
                if ($participant && $participant->email) {
                    $url = route('registration.verify', ['token' => $participant->token]);
    
                    $mail = [
                        'to' => $participant->email,
                        'email' => 'bumnlearningfestival@gmail.com',
                        'from' => 'BUMN Learning Festival',
                        'subject' => 'Verification Email | BUMN LEARNING FESTIVAL 2024',
                        'url' => $url,
                    ];
    
                    Mail::send('emails.verification', $mail, function($message) use ($mail) {
                        $message->to($mail['to'])
                            ->from($mail['email'], $mail['from'])
                            ->subject($mail['subject']);
                    });
                }
    
                DB::commit();
                return redirect()->back()->with('success', 'Registrasi berhasil. Silakan cek email ' . $participant->email . ' untuk verifikasi.');
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with('error', 'Gagal melakukan registrasi: ' . $th->getMessage());
            }
        } 
        // Kehadiran Online
        else {
            // Cek apakah peserta sudah terdaftar sebagai peserta offline dengan email yang sama
            $participantOnsiteCheck = Participant::where('email', $request->email)
                ->where('kehadiran', 'onsite')
                ->where('verification', 1)
                ->where('status', 1)
                ->first(); 
    
            if ($participantOnsiteCheck) {
                return back()->with('error', 'Email Anda sudah terdaftar sebagai peserta Offline.');
            } else {
                // Cek apakah peserta sudah pernah mendaftar sebagai peserta online
            $participantCheckZoom = Participant::where('email', $request->email)
            ->where('kehadiran', 'online')
            ->where('verification', 1)
            ->where('status', 1)
            ->first();

            if ($participantCheckZoom) {
                // Kirim ulang link Zoom
                $participant = Participant::where('email', $participantCheckZoom->email)->first();
                $url = route('online-event');

                $mail = [
                    'to' => $participant->email,
                    'name' => $participant->name,
                    'email' => 'bumnlearningfestival@gmail.com',
                    'from' => 'BUMN Learning Festival',
                    'subject' => 'Link Zoom | BUMN LEARNING FESTIVAL 2024',
                    'url' => $url,
                ];

                Mail::send('emails.linkzoom', $mail, function($message) use ($mail) {
                    $message->to($mail['to'])
                        ->from($mail['email'], $mail['from'])
                        ->subject($mail['subject']);
                });

                return redirect()->back()->with('success', 'Resend link Zoom berhasil. Silahkan cek email ' . $participant->email);
            }

            // Buat peserta baru untuk kehadiran online
            DB::beginTransaction();
            try {
                $token = $this->generateUniqueToken(12);

                $participantData = [
                    'token' => $token,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'instansi_id' => $request->instansi_id,
                    'jabatan' => $request->jabatan,
                    'kehadiran' => 'online',
                    'kendaraan' => $request->kendaraan,
                    'attendance' => 1,
                    'verification' => 1,
                ];

                $participant = Participant::create($participantData);

                if ($participant && $participant->email) {
                    $url = route('online-event');

                    $mail = [
                        'to' => $participant->email,
                        'name' => $participant->name,
                        'email' => 'bumnlearningfestival@gmail.com',
                        'from' => 'BUMN Learning Festival',
                        'subject' => 'Link Zoom | BUMN LEARNING FESTIVAL 2024',
                        'url' => $url,
                    ];

                    Mail::send('emails.linkzoom', $mail, function($message) use ($mail) {
                        $message->to($mail['to'])
                            ->from($mail['email'], $mail['from'])
                            ->subject($mail['subject']);
                    });
                }

                DB::commit();
                    return redirect()->back()->with('success', 'Link Zoom telah dikirim via email ' . $participant->email);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return back()->with('error', 'Gagal melakukan registrasi: ' . $th->getMessage());
                }
            }
        }
    }
    


    // public function store(Request $request) {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'phone_number' => 'required|min:8|max:13',
    //         'instansi_id' => 'required',
    //     ]);

    //     $emailParticipantCheck = Participant::where('email', $request->email);

    //     if ($emailParticipantCheck) {
    //         if ($request->kehadiran == "onsite") {
    //             $participantCheck = Participant::where('email', $request->email)->whereNotNull('qrcode')->first();
    
    //             if ($participantCheck) {
    //                 $participant = Participant::where('qrcode', $participantCheck->qrcode)->where('verification', 1)->first();
    
    //                 try {
    //                     $url = route('registration.verify', ['token' => $participant->token]);
    
    //                     $mail = [
    //                         'to' => $participant->email,
    //                         'email' => 'bumnlearningfestival@gmail.com',
    //                         'from' => 'BUMN Learning Festival',
    //                         'subject' => 'Verification Email | BUMN LEARNING FESTIVAL 2024',
    //                         'url' => $url,
    //                     ];
    
    //                     Mail::send('emails.verification', $mail, function($message) use ($mail){
    //                         $message->to($mail['to'])
    //                         ->from($mail['email'], $mail['from'])
    //                         ->subject($mail['subject']);
    //                     });
    //                     return redirect()->back()->with('success', 'Resend email berhasil, silahkan cek inbox atau spam email ' . $participant->email . ' untuk verifikasi');
    //                 } catch (\Throwable $th) {
    //                     return back()->with('error', $th->getMessage());
    //                 }
    //             } else {
    //                 return back()->with('error', 'Gagal Mengirim Ulang Email Pendaftaran');
    //             }
    //         } else {
    //             $participant = Participant::where('email', $request->email)->where('verification', 1)->first();
    
    //             $url = route('online-event');
    
    //             $mail = [
    //                 'to' => $participant->email,
    //                 'name' => $participant->name,
    //                 'email' => 'bumnlearningfestival@gmail.com',
    //                 'from' => 'BUMN Learning Festival',
    //                 'subject' => 'Link Zoom | BUMN LEARNING FESTIVAL 2024',
    //                 'url' => $url,
    //             ];
    
    //             Mail::send('emails.linkzoom', $mail, function($message) use ($mail) {
    //                 $message->to($mail['to'])
    //                     ->from($mail['email'], $mail['from'])
    //                     ->subject($mail['subject']);
    //             });
    //         }
    //     } elseif (!$emailParticipantCheck) {
    //         if ($request->kehadiran == "onsite") {
            
    //             $instansi = Instansi::find($request->instansi_id);

    //             $participantCount = Participant::where('instansi_id', $request->instansi_id)->count();

    //             if ($participantCount >= $instansi->max_participant) {
    //                 return redirect()->back()->with('error', 'Kuota pendaftaran On Site untuk instansi ini sudah penuh. Anda Tetap Bisa Melakukan Pendaftaran Online');
    //             }

    //             DB::beginTransaction();

    //             try {
    //                 $token = $this->generateUniqueToken(12);

    //                 $array = [
    //                     'token' => $token,
    //                     'name' => $request['name'],
    //                     'email' => $request['email'],
    //                     'phone_number' => $request['phone_number'],
    //                     'instansi_id' => $request['instansi_id'],
    //                     'jabatan' => $request['jabatan'],
    //                     'kehadiran' => 'onsite',
    //                     'kendaraan' => $request['kendaraan'],
    //                 ];

    //                 $participant = Participant::create($array);

    //                 if ($participant && $participant->email) {
    //                     $url = route('registration.verify', ['token' => $participant->token]);

    //                     $mail = [
    //                         'to' => $participant->email,
    //                         'email' => 'bumnlearningfestival@gmail.com',
    //                         'from' => 'BUMN Learning Festival',
    //                         'subject' => 'Verification Email | BUMN LEARNING FESTIVAL 2024',
    //                         'url' => $url,
    //                     ];

    //                     Mail::send('emails.verification', $mail, function($message) use ($mail){
    //                         $message->to($mail['to'])
    //                         ->from($mail['email'], $mail['from'])
    //                         ->subject($mail['subject']);
    //                     });
    //                 }

    //                 DB::commit();

    //                 return redirect()->back()->with('success', 'Registrasi anda berhasil silahkan cek inbox atau spam email '. $participant->email .' untuk verifikasi');
    //             } catch (\Throwable $th) {
    //                 DB::rollBack();
    //                 return back()->with('error', $th->getMessage());
    //             }
    //         } else {
    //             DB::beginTransaction();
        
    //             try {
    //                 $token = $this->generateUniqueToken(12);
            
    //                 $array = [
    //                     'token' => $token,
    //                     'name' => $request['name'],
    //                     'email' => $request['email'],
    //                     'phone_number' => $request['phone_number'],
    //                     'instansi_id' => $request['instansi_id'],
    //                     'jabatan' => $request['jabatan'],
    //                     'kehadiran' => 'online',
    //                     'kendaraan' => $request['kendaraan'],
    //                     'verification' => 1,
    //                 ];
            
    //                 $participant = Participant::create($array);
            
    //                 if ($participant && $participant->email) {
    //                     // Menggunakan $participant->email untuk query
    //                     $participant = Participant::where('email', $participant->email)->first();
            
    //                     $url = route('online-event');
            
    //                     $mail = [
    //                         'to' => $participant->email,
    //                         'name' => $participant->name,
    //                         'email' => 'bumnlearningfestival@gmail.com',
    //                         'from' => 'BUMN Learning Festival',
    //                         'subject' => 'Link Zoom | BUMN LEARNING FESTIVAL 2024',
    //                         'url' => $url,
    //                     ];
            
    //                     Mail::send('emails.linkzoom', $mail, function($message) use ($mail) {
    //                         $message->to($mail['to'])
    //                             ->from($mail['email'], $mail['from'])
    //                             ->subject($mail['subject']);
    //                     });
    //                 }
            
    //                 DB::commit();
            
    //                 return redirect()->back()->with('success', 'Link Zoom telah terkirim via email '. $participant->email);
    
    //             } catch (\Throwable $th) {
    //                 DB::rollBack();
    //                 return back()->with('error', $th->getMessage());
    //             }
    //         }
    //     } else {
    //         return back()->with('error', 'Gagal Registrasi Akun');
    //     }
    // }

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
