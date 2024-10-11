
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Kartu QR Code | BTN Festival 2024</title>

    <link rel="icon" type="image/x-icon" href="/btn.png">
    <link href="/tabler/dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="/tabler/dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="/tabler/dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="/tabler/dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="/tabler/dist/css/demo.min.css?1692870487" rel="stylesheet"/>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
      	    --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
      	    font-feature-settings: "cv03", "cv04", "cv11";
        }

        #card {
            width: 378px !important; /* Ukuran tetap */
            height: auto; /* Sesuaikan tinggi dengan konten */
            max-width: 378px; /* Mencegah kartu menjadi lebih besar dari 378px */
            min-width: 378px; /* Mencegah kartu menjadi lebih kecil dari 378px */
            overflow: hidden; /* Pastikan konten tidak keluar dari batas */
        }

        /* Menonaktifkan responsivitas di seluruh halaman */
        body, html {
            width: 100%;
            height: 100%;
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        /* Cegah scaling pada mobile */
        meta[name="viewport"] {
            content: "width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no";
        }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="/tabler/dist/js/demo-theme.min.js?1692870487"></script>

    
        
    <div class="container my-4">
        <div id="card" class="border rounded" style="width: 378px; margin: auto; background-color:white">
            <div class="position-relative">
                <!-- Aksen Bawah -->    
                <div class="position-absolute d-flex justify-content-center" style="bottom: 0; left:0; z-index: 1 !important;"> <!-- z-index lebih rendah -->
                    <img src="/AKSEN2.png" alt="BUMN Learning Festival" width="220px">
                </div>
            
                <!-- Bagian ID -->
                <span class="d-flex align-items-end justify-content-end mb-2 pe-4 ps-4 pt-4 pb-2" style="z-index: 3; position: relative;"> <!-- Tambah position relative dan z-index -->
                    <h3 class="m-0 me-2" style="font-size:25px; font-weight: 700">ID</h3>
                    <h1 class="m-0" style="font-size: 35px; font-weight:700">{{ $participant->qrcode }}</h1>
                </span>
            
                <!-- Logo dan lainnya -->
                <div class="d-flex justify-content-between align-items-center gap-2 pe-4 ps-4" style="margin-bottom: 190px; z-index: 2 !important; position: relative;"> <!-- z-index dan relative -->
                    <div class="d-flex gap-2">
                        <img src="/bumn-indonesia.png" alt="" width="48px">
                        <img src="/btn.png" alt="" width="48px">
                    </div>
                    <div class="d-flex gap-2">
                        <img src="/bumn-school.png" alt="" width="48px">
                        <img src="/forumhuman.png" alt="" width="48px">
                    </div>
                </div>
            
                <!-- Gambar Logo -->
                <div class="position-absolute d-flex justify-content-center" style="top: 9%; left:20%; z-index: 2; "> <!-- z-index lebih tinggi dari aksen -->
                    <img src="/logo.png" alt="BUMN Learning Festival" class="mb-3" width="240px">
                </div>
            
                <!-- Nama dan Instansi -->
                <div class="pe-5 ps-5" style="z-index: 3; position: relative; padding-bottom: 60px"> <!-- position relative dan z-index -->
                    <span class="text-uppercase" style="font-weight: 1000; font-size: 24px">{{ $participant->name }}</span><br>
                    <span class="text-uppercase" style="font-weight: 800; font-size: 18px">{{ $participant->instansi->name }}</span>
                </div>
            
                <!-- QR Code -->
                <div style="text-align: right; padding-right: 1rem; padding-left: 1rem; padding-bottom: 1rem; z-index: 2; position: relative;">
                    <div class="w-100" id="qrCodeImg" alt="QR Code" style="padding-left: 180px"></div>
                </div>
            </div>
            
        </div>
        <div class="d-flex justify-content-center gap-2 text-center my-4">
            <a href="#" id="downloadBtn" class="btn btn-primary">Download Image</a>
            <form id="sendImageForm" action="{{ route('registration.sendImage', $participant->token) }}" method="POST"
                  class="m-0" enctype="multipart/form-data">
                <input type="hidden" name="imageData" id="imageData">
                <button type="submit" id="sendImageBtn" class="btn btn-success">Kirim Foto via Email</button>
            </form>
        </div>
    </div>

    <!-- Libs JS -->
    <script src="tabler/dist/js/tabler.min.js" defer></script>
    <script src="tabler/dist/js/demo.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
            integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var qrcode = new QRCode("qrCodeImg", {
            text: "{{ $participant->qrcode }}",
            width: 300,
            height: 300,
        });

        async function downloadCard() {
            html2canvas(document.querySelector("#card"), {
                    useCORS: true,
                }
            ).then(canvas => {
                canvas.style.display = 'none'
                document.body.appendChild(canvas)
                return canvas
            }).then(canvas => {
                const image = canvas.toDataURL('image/png')
                const a = document.createElement('a')
                a.setAttribute('download', 'my-image.png')
                a.setAttribute('href', image)
                a.click()
                canvas.remove()
            });
        }


        document.getElementById('sendImageBtn').addEventListener('click', async function (e) {
            e.preventDefault(); // Mencegah form disubmit langsung
            const qrCodeUrl = document.getElementById('qrCodeImg').src;

            try {
                html2canvas(document.querySelector("#card"), {
                        useCORS: true,
                    }
                ).then(canvas => {
                    canvas.style.display = 'none'
                    document.body.appendChild(canvas)
                    return canvas
                }).then(canvas => {
                    const image = canvas.toDataURL('image/jpeg', 0.9);
                    // const a = document.createElement('a')
                    // a.setAttribute('download', 'my-image.png')
                    // a.setAttribute('href', image)
                    // a.click()
                    // canvas.remove()
                    document.getElementById('imageData').value = image;
                    document.getElementById('sendImageForm').submit();
                });


            } catch (err) {
                console.error('Error capturing card:', err);
            }
        });


        document.getElementById('downloadBtn').addEventListener('click', function (e) {
            e.preventDefault();
            downloadCard();
        });
    </script>
    
    

    <!-- Include html2canvas library for screenshot functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Tabler Core -->
    <script src="/tabler/dist/js/tabler.min.js?1692870487" defer></script>
    <script src="/tabler/dist/js/demo.min.js?1692870487" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <script type="text/javascript">
      $(document).ready( function () {
        $('form').on('submit', function() {
          $.LoadingOverlay("show");

            setTimeout(function () {
              $.LoadingOverlay("hide");
          }, 100000);
        });
      });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#downloadBtn').on('click', function(e) {
            e.preventDefault(); // Mencegah aksi default dari link
            $.LoadingOverlay("show");
      
            // Simulasi waktu untuk mendownload atau memproses
            setTimeout(function () {
              $.LoadingOverlay("hide");
              history.back(); // Mengembalikan pengguna ke halaman sebelumnya
            }, 3000); // Durasi loading (dalam milidetik)
          });
        });
    </script>
  </body>
</html>
