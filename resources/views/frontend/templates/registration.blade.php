<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('bumn-logo-final.png') }}">

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
            margin: 0; /* Menghilangkan margin default */
            height: 100vh; /* Membuat tinggi body 100vh */
            overflow: hidden; /* Menghindari scroll */
        }
        .background {
            background: url('{{ asset('assets/frontend/registration/Background.png') }}') no-repeat center center;
            background-size: cover; /* Pastikan gambar mengisi seluruh area */
            height: 100vh; /* Pastikan tinggi div 100vh */
            width: 100%; /* Pastikan lebar div 100% */
        }
        .logo {
            width: 294px; /* Default width for large screens */
        }
    </style>
</head>
<body class="d-flex flex-column position-relative">

    <div class="position-absolute" style="top: 0; left: 0; padding-left: 135px">
        <img src="{{ asset('assets/frontend/registration/LOGOLOGO1.png') }}" class="m-5 logo" alt="btn">
    </div>

    <div class="position-absolute" style="top: 0; right: 0; padding-right: 135px">
        <img src="{{ asset('assets/frontend/registration/LOGOLOGO2.png') }}" class="m-5 logo" alt="btn">
    </div>

    <div class="background">
        @yield('content')
    </div>

    <script src="{{ asset('tabler/dist/js/demo-theme.min.js?1692870487') }}"></script>
    <script src="{{ asset('tabler/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js?1692870487') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <!-- Include CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Include JS Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
