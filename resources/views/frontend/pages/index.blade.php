@extends('frontend.templates.pages')
@section('title', 'Home')
@section('content')
<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 100px">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('assets/frontend/home/LandingPage.png') }}" class="d-block w-100" alt="...">
        </div>
    </div>
</div>
<div class="container" style="margin-bottom: 70px; max-width: 1170px">
    <div class="d-flex justify-content-center mb-3">
        <h1 style="font-weight: 900; font-size:25px; color: #006CA7;">Final Event BUMN Learning Festival</h1>
    </div>
    <p class="text-center" style="font-size: 16px; line-height: 20px; color: #303030">
        Join us at the BUMN Learning Festival, where we ignite a movement toward a sustainable learning culture. Under
        the theme "Building Sustainable Learning Culture," this event brings together thought leaders and experts to
        explore key topics such as <b style="color: #004266">AKHLAK, Artificial Intelligence, Employee Well-Being,
            Sustainability, and Critical Thinking</b>.
    </p>
    <p class="text-center" style="font-size: 16px; line-height: 20px; color: #303030">
        This festival is designed to inspire employees to continuously learn, grow, and adapt in a rapidly evolving
        world. Through engaging discussions and interactive sessions, you'll gain valuable insights and tools to improve
        both professionally and personally. Don't miss this opportunity to be part of a learning revolution that shapes
        the future of work!
    </p>
</div>
<div class="container my-5" style="margin-bottom: 70px; max-width: 1180px">
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; height: 336px; width: 570px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s;">
                <img src="{{ asset('AKSEN.png')}}" alt="BUMN Learning Festival" width="336px" class="position-absolute d-flex justify-content-center z-2" style="bottom: 0%; right:-5%">
                <div class="p-5">
                    <img src="{{ asset('bumn-learning-festival.png') }}" width="160px" alt="" class="pb-3">
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: #003E64">Pendaftaran Peserta</h5>
                    <h6 class="card-subtitle mb-3" style="font-size: 33px; font-weight: 800; color: #666; color: #003E64">ONLINE</h6>
                    <a href="{{ route('registration.index.online') }}" class="btn"
                        style="background-color: #003E64; color: white; font-weight: bold; border-radius: 5px; padding: 10px 20px; font-size: 20px">Registrasi</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; height: 336px; width: 570px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s;">
                <img src="{{ asset('AKSEN.png')}}" alt="BUMN Learning Festival" width="336px" class="position-absolute d-flex justify-content-center z-2" style="bottom: 0%; right:-5%">
                <div class="p-5">
                    <img src="{{ asset('bumn-learning-festival.png') }}" width="160px" alt="" class="pb-3">
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: #0566AE">Pendaftaran Peserta</h5>
                    <h6 class="card-subtitle mb-3" style="font-size: 33px; font-weight: 800; color: #0566AE">ON SITE</h6>
                    <a href="{{ route('registration.index') }}" class="btn"
                        style="background-color: #0566AE; color: white; font-weight: bold; border-radius: 5px; padding: 10px 20px; font-size: 20px">Registrasi</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
