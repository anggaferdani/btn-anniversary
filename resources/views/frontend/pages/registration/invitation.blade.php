<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Kartu QR Code | BTN Festival 2024</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('btn.png') }}">
    <link href="{{ asset('tabler/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/dist/css/demo.min.css?1692870487') }}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="{{ asset('tabler/dist/js/demo-theme.min.js?1692870487') }}"></script>
    
    {{-- Notif --}}
    @if(Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container my-4">
        <div id="card" class="border rounded" style="width: 450px; margin: auto; background-color:white">
            <div class="position-relative">
                <div class="position-absolute d-flex justify-content-center" style="bottom: 0%; left:0%">
                    <img src="{{ asset('AKSEN2.png') }}" alt="BUMN Learning Festival" width="220px">
                </div>
                <span class="d-flex align-items-end justify-content-end mb-2 pe-4 ps-4 pt-4">
                    <h3 class="m-0 me-2" style="font-size:25px; font-weight: 800">ID</h3>
                    <h1 class="m-0" style="font-size: 35px; font-weight:800">{{ substr($participant->qrcode, 0, 1) }} {{ substr($participant->qrcode, 1) }}</h1>
                </span>
                <div class="d-flex justify-content-between align-items-center gap-2 pe-4 ps-4" style="margin-bottom: 220px">
                    <div class="d-flex gap-2">
                        <img src="{{ asset('bumn-indonesia.png') }}" alt="" width="48px">
                        <img src="{{ asset('btn.png') }}" alt="" width="48px">
                    </div>
                    <div class="d-flex gap-2">
                        <img src="{{ asset('bumn-school.png') }}" alt="" width="48px">
                        <img src="{{ asset('forumhuman.png') }}" alt="" width="48px">
                    </div>
                </div>
                <div class="position-absolute d-flex justify-content-center" style="top: 15%; left:20%">
                    <img src="{{ asset('logo.png') }}" alt="BUMN Learning Festival" class="mb-3" width="260px">
                </div>
                <div class="pe-4 ps-4">
                    <span class="text-uppercase" style="font-weight: 1000; font-size: 30px">{{ $participant->name }}</span><br>
                    <span class="text-uppercase" style="font-weight: 800; font-size: 25px">{{ $participant->instansi->name }}</span>
                </div>
    
                <div class="qr-code-container text-end pe-4 ps-4 pb-4">
                    <img id="qrCodeImg" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $participant->qrcode }}" alt="QR Code" width="200px" height="200px">
                </div>
            </div>
        </div>
    
        <div class="d-flex justify-content-center gap-2 text-center my-4">
            <a href="#" id="downloadBtn" class="btn btn-primary">Download Image</a>
            <form id="sendImageForm" action="{{ route('registration.sendImage', $participant->token) }}" method="POST" class="m-0">
                @csrf
                <input type="hidden" name="imageData" id="imageData">
                <button type="submit" id="sendImageBtn" class="btn btn-success">Kirim Foto via Email</button>
            </form>
        </div>
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

        document.getElementById('sendImageBtn').addEventListener('click', async function (e) {
            e.preventDefault(); // Mencegah form disubmit langsung
            const qrCodeUrl = document.getElementById('qrCodeImg').src;
            
            try {
                const qrCodeDataUrl = await downloadQRCode(qrCodeUrl);
                const card = document.getElementById('card');
                
                // Buat canvas untuk kartu
                const cardCanvas = await html2canvas(card);
                const combinedCanvas = document.createElement('canvas');
                combinedCanvas.width = cardCanvas.width;
                combinedCanvas.height = cardCanvas.height;

                const combinedCtx = combinedCanvas.getContext('2d');
                combinedCtx.drawImage(cardCanvas, 0, 0);

                const qrCodeImg = new Image();
                qrCodeImg.src = qrCodeDataUrl;

                qrCodeImg.onload = () => {
                    const qrCodeWidth = 200;  // Ukuran QR code tetap
                    const qrCodeHeight = 200; // Ukuran QR code tetap
                    const qrCodePositionX = cardCanvas.width - qrCodeWidth - 10; // Posisi QR code
                    const qrCodePositionY = cardCanvas.height - qrCodeHeight - 10; // Posisi QR code

                    // Menggambar QR code di canvas dengan ukuran yang benar
                    combinedCtx.drawImage(qrCodeImg, qrCodePositionX, qrCodePositionY, qrCodeWidth, qrCodeHeight);
                    
                    // Dapatkan URL gambar data
                    const imageDataUrl = combinedCanvas.toDataURL('image/jpeg', 0.9);
                    document.getElementById('imageData').value = imageDataUrl; // Setel nilai input tersembunyi
                    
                    // Submit form untuk mengirim email dengan gambar
                    document.getElementById('sendImageForm').submit();
                };
            } catch (err) {
                console.error('Error capturing card:', err);
            }
        });

    
        // Function to download the card as an image and save it to the server
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

                qrCodeImg.onload = async () => {
                    // Calculate the position for the QR code
                    const qrCodeWidth = 200; 
                    const qrCodeHeight = 200; 
                    const qrCodePositionX = cardCanvas.width - qrCodeWidth - 10; 
                    const qrCodePositionY = cardCanvas.height - qrCodeHeight - 10; 

                    combinedCtx.drawImage(qrCodeImg, qrCodePositionX, qrCodePositionY, qrCodeWidth, qrCodeHeight);

                    const imageDataUrl = combinedCanvas.toDataURL('image/jpeg', 0.9);

                    // Download the image
                    const link = document.createElement('a');
                    link.download = '{{ $participant->qrcode }}.jpg';
                    link.href = imageDataUrl;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Send image data to the server
                    await saveImageToServer(imageDataUrl);
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

    <!-- Tabler Core -->
    <script src="{{ asset('tabler/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js?1692870487') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <script type="text/javascript">
      $(document).ready( function () {
        $('form').on('submit', function() {
          $.LoadingOverlay("show");
      
          setTimeout(function(){
              $.LoadingOverlay("hide");
          }, 100000);
        });
      });
    </script>
  </body>
</html>
