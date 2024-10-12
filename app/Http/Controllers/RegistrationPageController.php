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
        $instansis = Instansi::withCount('participants')
                    ->where('status', 1)
                    ->get(['id', 'name', 'max_participant', 'participants_count', 'status_kehadiran']); // Jangan lupa untuk mengambil kolom status_kehadiran

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

                // if ($participantCount >= 3 && $participantCount <= 100) {
                //     $qrcode = 'B' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                // } elseif ($participantCount >= 101 && $participantCount <= 200) {
                //     $qrcode = 'U' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                // } elseif ($participantCount >= 201 && $participantCount <= 300) {
                //     $qrcode = 'M' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                // } elseif ($participantCount >= 301) {
                //     $qrcode = 'N' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                // }

                if ($participantCount <= 100) {
                    $qrcode = 'B' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 100 && $participantCount <= 200) {
                    $qrcode = 'U' . str_pad($participantCount - 100, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 200 && $participantCount <= 300) {
                    $qrcode = 'M' . str_pad($participantCount - 200, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 300 && $participantCount <= 400) {
                    $qrcode = 'N' . str_pad($participantCount - 300, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount > 400) {
                    $qrcode = 'N' . str_pad($participantCount - 300, 3, '0', STR_PAD_LEFT);
                }
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

    public function sendImage(Request $request, $token) {
        $participant = Participant::where('token', $token)->first();

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
            'phone_number' => 'required|min:8|max:13',
            'instansi_id' => 'required',
        ]);

        $participantCheck = Participant::where('email', $request->email)->whereNotNull('qrcode')->first();

        if ($participantCheck) {
            $participant = Participant::where('qrcode', $participantCheck->qrcode)->where('verification', 1)->first();

            try {
                $url = route('registration.verify', ['token' => $participant->token]);

                $mail = [
                    'to' => $participant->email,
                    'email' => 'bumnlearningfestival@gmail.com',
                    'from' => 'BUMN Learning Festival',
                    'subject' => 'Verification Email | BUMN LEARNING FESTIVAL 2024',
                    'url' => $url,
                ];

                Mail::send('emails.verification', $mail, function($message) use ($mail){
                    $message->to($mail['to'])
                    ->from($mail['email'], $mail['from'])
                    ->subject($mail['subject']);
                });
                return redirect()->back()->with('success', 'Resend email berhasil, silahkan cek inbox atau spam email'. $participant->email .'untuk verifikasi');
            } catch (\Throwable $th) {
                return back()->with('error', $th->getMessage());
            }

        } else {
            // Cari instansi berdasarkan ID yang dipilih
            $instansi = Instansi::find($request->instansi_id);

            // Hitung jumlah partisipan yang sudah terdaftar di instansi
            $participantCount = Participant::where('instansi_id', $request->instansi_id)->count();

            // Cek apakah jumlah partisipan sudah mencapai batas maksimal
            if ($participantCount >= $instansi->max_participant) {
                return redirect()->back()->with('error', 'Kuota pendaftaran On Site untuk instansi ini sudah penuh. Anda Tetap Bisa Melakukan Pendaftaran Online');
            }

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
                    'kendaraan' => $request['kendaraan'],
                ];

                $participant = Participant::create($array);

                if ($participant && $participant->email) {
                    $url = route('registration.verify', ['token' => $participant->token]);

                    $mail = [
                        'to' => $participant->email,
                        'email' => 'bumnlearningfestival@gmail.com',
                        'from' => 'BUMN Learning Festival',
                        'subject' => 'Verification Email | BUMN LEARNING FESTIVAL 2024',
                        'url' => $url,
                    ];

                    Mail::send('emails.verification', $mail, function($message) use ($mail){
                        $message->to($mail['to'])
                        ->from($mail['email'], $mail['from'])
                        ->subject($mail['subject']);
                    });
                }

                DB::commit();

                return redirect()->back()->with('success', 'Registrasi anda berhasil silahkan cek inbox atau spam email'. $participant->email .' untuk verifikasi');
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
            'phone_number' => 'required|min:8|max:13',
            'instansi_id' => 'required',
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
                'kehadiran' => 'online',
                'kendaraan' => $request['kendaraan'],
                'verification' => 1,
            ];
    
            $participant = Participant::create($array);
    
            if ($participant && $participant->email) {
                // Menggunakan $participant->email untuk query
                $participant = Participant::where('email', $participant->email)->first();
    
                $url = Zoom::first();
    
                $mail = [
                    'to' => $participant->email,
                    'name' => $participant->name,
                    'email' => 'bumnlearningfestival@gmail.com',
                    'from' => 'BUMN Learning Festival',
                    'subject' => 'Link Zoom | BUMN LEARNING FESTIVAL 2024',
                    'url' => $url->link,
                ];
    
                Mail::send('emails.linkzoom', $mail, function($message) use ($mail) {
                    $message->to($mail['to'])
                        ->from($mail['email'], $mail['from'])
                        ->subject($mail['subject']);
                });
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Link Zoom telah terkirim via email '. $participant->email);
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
