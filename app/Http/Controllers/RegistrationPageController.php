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
        $instansis = Instansi::where('status', 1)->get();
        return view('frontend.pages.registration.registration', compact('instansis'));
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
        $participant = Participant::where('token', $token)->first();

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
                } elseif ($participantCount >= 301 && $participantCount <= 400) {
                    $qrcode = 'N' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
                } elseif ($participantCount >= 401) {
                    $qrcode = 'F' . str_pad($participantCount, 3, '0', STR_PAD_LEFT);
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

            $participant->update('image', $fileName);
    
            // Save the image
            file_put_contents($filePath, $imageData);
    
            // Prepare email data
            $mail = [
                'to' => $participant->email,
                'from_email' => 'example@gmail.com',
                'from_name' => 'BTN Anniversary',
                'subject' => 'Kartu QR Code',
                'name' => $participant->name,
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
    
    // public function downloadPdf($token) {
    //     $participant = Participant::where('token', $token)->first();
    
    //     $pdf = Pdf::loadView('frontend.pages.registration.invitation-pdf', compact('participant'))->setOption("isRemoteEnabled", true)->setOption("defaultFont", "sans-serif");
      
    //     // Download PDF
    //     return $pdf->download($participant->qrcode . '.pdf');
    // }

    // public function downloadPdf($token) {
    //     // Ambil participant berdasarkan token
    //     $participant = Participant::where('token', $token)->first();

    //     // Set opsi untuk Dompdf
    //     $options = new Options();
    //     $options->set('defaultFont', 'sans-serif'); // Mengatur font default
    //     $options->set('isRemoteEnabled', true); // Mengizinkan pemuatan CSS dari URL

    //     // Buat instance Dompdf
    //     $dompdf = new Dompdf($options);

    //     // Render view menjadi HTML
    //     $html = view('frontend.pages.registration.invitation-pdf', compact('participant'))->render();
        
    //     // Load HTML ke Dompdf
    //     $dompdf->loadHtml($html);

    //     // Set ukuran kertas dan orientasi
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     // Output the generated PDF to Browser
    //     return $dompdf->stream($participant->qrcode . '.pdf', ['Attachment' => true]); // Set 'Attachment' => true untuk mengunduh
    // }

    
    // public function sendmailQRCode($token, Request $request) {
    //     $participant = Participant::where('token', $token)->first();
        
    //     if (!$participant) {
    //         return redirect()->back()->with('error', 'Participant not found.');
    //     }
    
    //     // Generate PDF
    //     $pdf = Pdf::loadView('frontend.pages.registration.invitation-pdf', compact('participant'))
    //               ->setOption("isRemoteEnabled", true);
    
    //     // Data yang akan dikirim ke email
    //     $mail = [
    //         'to' => $participant->email,
    //         'from_email' => 'example@gmail.com',
    //         'from_name' => 'BTN Anniversary',
    //         'subject' => 'QR Code',
    //         'name' => $participant->name,
    //     ];
    
    //     try {
    //         Mail::send('emails.invitation', $mail, function($message) use ($mail, $pdf) {
    //             $message->to($mail['to'])
    //                     ->from($mail['from_email'], $mail['from_name'])
    //                     ->subject($mail['subject'])
    //                     ->attachData($pdf->output(), 'qrcode.pdf', [
    //                         'mime' => 'application/pdf',
    //                     ]); // Attach the PDF file
    //         });
    
    //         // Email berhasil dikirim
    //         return redirect()->back()->with('success', 'PDF QR Code berhasil dikirim ke email ' . $mail['to']);
    //     } catch (\Exception $e) {
    //         // Tampilkan pesan error jika email gagal dikirim
    //         return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
    //     }
    // }
    
    
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
                return redirect()->back()->with('success', 'A verification email has been resent to ' . $participant->email . '. Please check your inbox to confirm your registration.');
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
        
                return redirect()->back()->with('success', 'A verification email has been sent to ' . $participant->email . '. Please check your inbox to confirm your registration.');
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with('error', $th->getMessage());
            }
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
