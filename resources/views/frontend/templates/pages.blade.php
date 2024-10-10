<!DOCTYPE html>
<html lang="en">

<head>
    <title>BTN Anniversary | @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('eventtalk/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('eventtalk/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('eventtalk/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('eventtalk/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('eventtalk/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('eventtalk/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('eventtalk/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('eventtalk/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('eventtalak/css/jquery.timepicker.css') }}">


    <link rel="stylesheet" href="{{ asset('eventtalk/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('eventtalk/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('eventtalk/css/style.css') }}">
</head>

<body>

    @include('frontend.templates.subtemplates.navbar')
    
    @yield('content')
    
    @include('frontend.templates.subtemplates.footer')


    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00" /></svg></div>


    <script src="{{ asset('eventtalk/js/jquery.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/popper.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('eventtalk/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/aos.js') }}"></script>
    <script src="{{ asset('eventtalk/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('eventtalk/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('eventtalk/js/scrollax.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false">
    </script>
    <script src="{{ asset('eventtalk/js/google-map.js') }}"></script>
    <script src="{{ asset('eventtalk/js/main.js') }}"></script>

</body>

</html>