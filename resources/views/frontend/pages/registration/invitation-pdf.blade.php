<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Kartu QR Code | BTN Festival 2024</title>
    <link rel="icon" type="image/x-icon" href="btn.png">
</head>
<body style="margin-top: 30px; padding: 0;">
    <div style="max-width: 390px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;" id="card">
        <div style="padding: 10px; justify-content: center">
            <span style="display: flex; align-items: flex-end; justify-content: flex-end; width: 100%;">
                <h3 style="margin: 0;">ID</h3>
                <h1 style="margin-left: 8px; margin: 0;">{{ $participant->qrcode }}</h1>
            </span>
            <div style="display: flex; justify-content: center; margin-bottom: 1rem; align-items: center; gap: 10px;">
                <img src="{{ public_path('bumn-indonesia.png') }}" alt="" width="100px">
                <img src="{{ public_path('kementerian-badan-usaha.png') }}" alt="" width="90px">
                <img src="{{ public_path('bumn-school.png') }}" alt="" width="40px">
                <img src="{{ public_path('btn.png') }}" alt="" width="40px">
                <img src="{{ public_path('forumhuman.png') }}" alt="" width="50px">
            </div>
            <img src="{{ public_path('bumn-invitation-1.png') }}" alt="BUMN Learning Festival" width="450px" style="display: block; margin-left: auto; margin-right: auto;">
            <h1 style="font-size: 35px; margin-top: 1rem;">{{ $participant->name }}</h1>
            <div style="display: flex; justify-content: flex-end; align-items: flex-end; margin-top: 1rem;">
                <img id="qrCodeImg" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $participant->qrcode }}" alt="QR Code">
            </div>
        </div>
    </div>
</body>
</html>
