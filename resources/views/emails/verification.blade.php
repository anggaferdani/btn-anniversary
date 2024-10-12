<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
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

        .brand-color {
            color: #0056a3;
            font-weight: bold;
            font-size: 24px;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
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
            justify-content: center;
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
    <div class="email-container text-center">
        
        <img src="{{ $message->embed('logobaru.png') }}" alt="Logo BTN" class="logo">

        <h2 class="brand-color">Pendaftaran anda berhasil</h2>
        
        <p>Terima kasih telah mendaftar. Untuk mendapatkan ID Card & QR Code, silakan klik tombol di bawah ini.</p>

        <a href="{{ $url }}" class="btn-verify" style="color: white; text-decoration: none">Download ID Card</a>

        <div class="footer-note">
            <p>Terima kasih atas perhatian Anda. Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi tim kami.</p>
        </div>
    </div>
</body>

</html>
