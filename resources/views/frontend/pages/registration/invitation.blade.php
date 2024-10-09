<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desain Kartu BUMN Learning Festival</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .card-container {
            width: 350px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
            padding: 20px;
            text-align: center;
            position: relative;
            background: url('{{ asset('assets/frontend/invitation/card-background.png') }}') no-repeat center center;
            display: flex; /* Use flexbox */
            flex-direction: column; /* Arrange items vertically */
            align-items: center; /* Center items horizontally */
        }

        .card-header {
            padding: 10px;
            text-align: center; /* Center text for header */
        }

        .card-header img {
            width: 100%; /* Make the image responsive */
            max-width: 190px; /* Set a max-width for the image */
            height: auto; /* Maintain aspect ratio */
        }

        .card-body {
            margin-top: 20px;
            text-align: center; /* Center text in card body */
        }

        .qr-code {
            margin-top: 20px;
            display: flex; /* Use flexbox for QR code */
            justify-content: center; /* Center the QR code horizontally */
            width: 100%; /* Make sure QR code takes full width */
        }

        .qr-code img {
            width: 150px;
            height: 150px;
            border: 1px solid #e0e0e0; /* Optional: Add a border to the QR Code */
        }

        .card-footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="card-container" id="card">
    <div class="card-header">
        <img src="{{ asset('bumn-learning-festival.png') }}" alt="BUMN Learning Festival">
    </div>
    <div class="card-body">
        <h2>{{ $participant->name }}</h2>
        <p>Pertamina Pusat</p>
        <div class="qr-code">
            <img id="qrCodeImg" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $participant->qrcode }}" alt="QR Code">
        </div>
    </div>
    <div class="card-footer"></div>
</div>

<!-- Button to Download Card -->
<a href="#" id="downloadBtn" class="download-btn">Download Kartu</a>

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
                resolve(canvas.toDataURL('image/png'));
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
                combinedCtx.drawImage(qrCodeImg, 125, 250, 150, 150); // Adjust position if needed

                const link = document.createElement('a');
                link.download = 'kartu_bumn_learning_festival.png';
                link.href = combinedCanvas.toDataURL('image/png');
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
