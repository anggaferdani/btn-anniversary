<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Invitation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .btn-verify {
            background-color: #0056a3;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-verify:hover {
            background-color: #004080;
        }

        .footer-note {
            font-size: 12px;
            color: #777777;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container" style="text-align: center;">
        <img src="{{ $message->embed('LOGOVOKEFINAL.png') }}" alt="Logo BTN" class="logo" style="display: block; margin: 0 auto;">
        <h1 style="text-align: center;">Selamat, {{ $name }}!</h1>
        <img src="{{ $message->embed('images/'. $image) }}" alt="qrcode"
             style="width: 100%; max-width: 100%; height: auto; overflow: hidden;">
        <a href="{{ $url }}" class="btn-verify" style="color: white; text-decoration: none;">Download QR Code</a>
        <p style="text-align: center;">QR code Anda telah disisipkan sebagai lampiran. Harap bawa QR code ini untuk mengikuti Event.</p>
        <div class="footer-note" style="text-align: center;">
            <p>Terima kasih atas perhatian Anda. Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi tim kami.</p>
        </div>
    </div>
</body>
</html>
