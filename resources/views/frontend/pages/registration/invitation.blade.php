<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Kartu QR Code | BTN Festival 2024</title>
    <link rel="icon" type="image/x-icon" href="btn.png">
</head>
<body style="margin-top: 30px; padding: 0;">
    {{-- Notif --}}
    @if(Session::get('success'))
        <div role="alert" style="margin: 10px; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
            {{ Session::get('success') }}
        </div>
    @endif
    @if(Session::get('error'))
        <div role="alert" style="margin: 10px; padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            {{ Session::get('error') }}
        </div>
    @endif

    <div style="max-width: 390px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; position: relative;" id="card">
        <div style="padding: 10px; justify-content: center">
            <span style="display: flex; align-items: flex-end; justify-content: flex-end; width: 100%;">
                <h3 style="margin: 0;">ID</h3>
                <h1 style="margin-left: 8px; margin: 0;">{{ $participant->qrcode }}</h1>
            </span>
            <div style="display: flex; justify-content: center; margin-bottom: 1rem; align-items: center; gap: 10px;">
                <img src="{{ asset('bumn-indonesia.png') }}" alt="" width="100px">
                <img src="{{ asset('kementerian-badan-usaha.png') }}" alt="" width="90px">
                <img src="{{ asset('bumn-school.png') }}" alt="" width="40px">
                <img src="{{ asset('btn.png') }}" alt="" width="40px">
                <img src="{{ asset('forumhuman.png') }}" alt="" width="50px">
            </div>
            <img src="{{ asset('bumn-invitation-1.png') }}" alt="BUMN Learning Festival" style="display: block; margin-left: auto; margin-right: auto; width: 100%; object-fit: contain;">
            <h1 style="font-size: 35px; margin-top: 1rem; padding-bottom: 150px">{{ $participant->name }}</h1>
            
            <!-- QR Code container -->
            <div style="position: absolute; bottom: 10px; right: 10px; margin: 10px">
                <img id="qrCodeImg" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $participant->qrcode }}" alt="QR Code">
            </div>
        </div>
    </div>
    

    <div style="display: flex; justify-content: center; text-align: center; gap: 10px; margin: 1rem;">
        <!-- Button to Download PDF -->
        <a href="{{ route('registration.downloadPdf', $participant->token) }}" id="downloadPdfBtn" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Download Kartu sebagai PDF</a>

        <!-- Button to Send Email -->
        <form action="{{ route('registration.sendmail', $participant->token) }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer;">Kirim QR Code via Email</button>
        </form>

        <a href="#" id="downloadBtn" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Download Kartu Sebagai Image</a>

    </div>
    <!-- Libs JS -->
    <script src="tabler/dist/js/tabler.min.js" defer></script>
    <script src="tabler/dist/js/demo.min.js" defer></script>

    <script>
        // Function to download QR Code as an image
        function downloadQRCode(url) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.crossOrigin = 'Anonymous'; // Enable CORS for external image
                img.src = url;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    resolve(canvas.toDataURL('image/png')); // Keep this as PNG for QR code
                };
                img.onerror = reject;
            });
        }
    
        // Function to download the card as an image
        async function downloadCard() {
            const qrCodeUrl = document.getElementById('qrCodeImg').src;
            try {
                const qrCodeDataUrl = await downloadQRCode(qrCodeUrl);
                const card = document.getElementById('card');
    
                // Create a new canvas to combine the card and QR code
                const cardCanvas = await html2canvas(card);
                const combinedCanvas = document.createElement('canvas');
                combinedCanvas.width = cardCanvas.width;
                combinedCanvas.height = cardCanvas.height;
    
                const combinedCtx = combinedCanvas.getContext('2d');
                combinedCtx.drawImage(cardCanvas, 0, 0);
    
                const qrCodeImg = new Image();
                qrCodeImg.src = qrCodeDataUrl;
    
                qrCodeImg.onload = () => {
                    // Calculate the position for the QR code
                    const qrCodeWidth = 200; // Set the new width for the QR code
                    const qrCodeHeight = 200; // Set the new height for the QR code
                    const qrCodePositionX = cardCanvas.width - qrCodeWidth - 10; // Adjust for the new width
                    const qrCodePositionY = cardCanvas.height - qrCodeHeight - 10; // Adjust for the new height
    
                    combinedCtx.drawImage(qrCodeImg, qrCodePositionX, qrCodePositionY, qrCodeWidth, qrCodeHeight); // Draw QR code with the new size
    
                    const link = document.createElement('a');
                    link.download = 'kartu_bumn_learning_festival.jpg'; // Change file extension to .jpg
                    link.href = combinedCanvas.toDataURL('image/jpeg', 0.9); // Use 'image/jpeg' for JPG format, and set quality
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                };
            } catch (err) {
                console.error('Error capturing card:', err);
            }
        }
    
        document.getElementById('downloadBtn').addEventListener('click', function (e) {
            e.preventDefault();
            downloadCard();
        });
    </script>
    
    <!-- Include html2canvas library for screenshot functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    
</body>
</html>
