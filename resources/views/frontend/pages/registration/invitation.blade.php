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


                <div style="text-align: right; padding-right: 1rem; padding-left: 1rem; padding-bottom: 1rem;">
                    <div id="qrCodeImg" alt="QR Code" style="padding-bottom: 20px; padding-left: 200px"></div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2 text-center my-4">
            <a href="#" id="downloadBtn" class="btn btn-primary">Download Image</a>
            <form id="sendImageForm" action="{{ route('registration.sendImage', $participant->token) }}" method="POST"
                  class="m-0" enctype="multipart/form-data">
                @csrf
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
            text: "{{$participant->qrcode}}",
            width: 200,
            height: 200,
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
    <script src="{{ asset('tabler/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js?1692870487') }}" defer></script>
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
  </body>
</html>
