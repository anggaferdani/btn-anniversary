<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=378, initial-scale=1, maximum-scale=1, user-scalable=no"/>
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
            height: auto; /* Tinggi otomatis */
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        #card {
            width: 378px; /* Ukuran tetap */
            height: auto; /* Sesuaikan tinggi dengan konten */
            max-width: 378px; /* Mencegah kartu menjadi lebih besar dari 378px */
            min-width: 378px; /* Mencegah kartu menjadi lebih kecil dari 378px */
            overflow: hidden; /* Pastikan konten tidak keluar dari batas */
            margin: auto; /* Pusatkan kartu */
        }

        /* Gaya untuk QR Code */
        #qrCodeImg {
            width: 100%; /* Ukuran tetap untuk QR Code */
            height: auto; /* Ukuran tetap untuk QR Code */
        }
    </style>
</head>
<body class="d-flex flex-column">
    <script src="/tabler/dist/js/demo-theme.min.js?1692870487"></script>
    @if(Session::get('success'))
        <div class="alert alert-important alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if(Session::get('error'))
        <div class="alert alert-important alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="container my-4">
        <div id="card" class="border rounded" style="background-color: white">
            <div class="position-relative">
                <!-- Aksen Bawah -->
                <div class="position-absolute d-flex justify-content-center" style="bottom: 0; left:0; z-index: 1;">
                    <img src="/AKSEN2.png" alt="BUMN Learning Festival" width="220px" style="z-index: 1;">
                </div>

                <!-- Bagian ID -->
                <span class="d-flex align-items-end justify-content-end mb-2 pe-4 ps-4 pt-4 pb-2" style="z-index: 3; position: relative;">
                    <h3 class="m-0 me-2" style="font-size:25px; font-weight: 700">ID</h3>
                    <h1 class="m-0" style="font-size: 35px; font-weight:700">{{ $participant->qrcode }}</h1>
                </span>

                <!-- Logo dan lainnya -->
                <div class="d-flex justify-content-between align-items-center gap-2 pe-4 ps-4" style="margin-bottom: 190px; z-index: 2;">
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
                <div class="position-absolute d-flex justify-content-center" style="top: 9%; left:20%; z-index: 2;">
                    <img src="/logo.png" alt="BUMN Learning Festival" class="mb-3" width="240px">
                </div>

                <!-- Nama dan Instansi -->
                <div class="pe-5 ps-5" style="z-index: 3; position: relative;">
                    <span class="text-uppercase" style="font-weight: 1000; font-size: 24px">{{ $participant->name }}</span><br>
                    <span class="text-uppercase" style="font-weight: 800; font-size: 18px">{{ $participant->instansi->name }}</span>
                </div>

                <!-- QR Code -->
                <div class="d-flex justify-content-end ms-auto col-md-7 z-2">
                    <img src="/qrcodes/{{ $participant->token }}.png" alt="QR Code" id="qrCodeImg" width="200px" height="200px">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center gap-2 text-center my-4">
            <a href="#" id="downloadBtn" class="btn btn-primary">Download Image</a>
            <form id="sendImageForm" action="{{ route('registration.sendImage', $participant->token) }}" method="POST" class="m-0" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="imageData" id="imageData">
                <button type="submit" id="sendImageBtn" class="btn btn-success">Kirim Foto via Email</button>
            </form>
        </div>
    </div>

    <!-- Libs JS -->
    <script src="tabler/dist/js/tabler.min.js" defer></script>
    <script src="tabler/dist/js/demo.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#downloadBtn').on('click', function (e) {
                e.preventDefault();
                downloadCard(); // Panggil fungsi downloadCard langsung
            });

            $('#sendImageBtn').on('click', async function (e) {
                e.preventDefault(); // Mencegah form disubmit langsung
                html2canvas(document.querySelector("#card"), { useCORS: true })
                .then(canvas => {
                    const image = canvas.toDataURL('image/png', 1.0);
                    document.getElementById('imageData').value = image; // Menyimpan gambar ke input hidden
                    document.getElementById('sendImageForm').submit(); // Mengirim form
                });
            });
        });

        async function downloadCard() {
            const canvas = await html2canvas(document.querySelector("#card"), {
                useCORS: true,
            });
            const image = canvas.toDataURL('image/png');
            const a = document.createElement('a');
            a.setAttribute('download', 'qrcode.png');
            a.setAttribute('href', image);
            a.click();
        }

        $(document).ready(function () {
            $('form').on('submit', function () {
                $.LoadingOverlay("show");
                setTimeout(function () {
                    $.LoadingOverlay("hide");
                }, 100000);
            });
        });
    </script>

</body>
</html>
