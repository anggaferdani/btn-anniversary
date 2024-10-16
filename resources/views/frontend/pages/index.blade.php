@extends('frontend.templates.pages')
@section('title', 'Home')
@section('content')
<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 100px">
    <div class="">
        <div class="">
            <img src="{{ asset('assets/frontend/home/kv-new.png') }}" class="d-block w-100" alt="...">
        </div>
    </div>
</div>
<div class="container text-start" style="margin-bottom: 70px; max-width: 1170px;">
    {{-- Schedule --}}
    <div class="row" style="margin-bottom: 121px">
      <div class="col-12 col-lg-4 mb-4">
        <div class="card" style="width: 100%; height: 244px; background: #4298C5;">
          <div class="card-body m-0 pl-5 py-4 d-flex flex-column justify-content-between">
            <h5 class="card-title m-0" style="font-size: 30px; font-weight: 700; color: white; padding-bottom: 16px;">
              <img src="{{ asset('assets/frontend/home/jam.png') }}" alt="Icon 1" style="width: 41.67px;" class="me-2"> 
              Waktu
            </h5>
            <h6 class="card-subtitle m-0" style="font-size: 20px; font-weight: 400; color: white;">Selasa</h6>
            <p class="card-text m-0" style="font-size: 20px; font-weight: 600; color: white; padding-bottom: 44px;">15 Oktober 2024</p>
            <p class="card-link m-0" style="font-size: 20px; font-weight: 600; color: white;">08.00 - 12.00 WIB</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4 mb-4">
        <div class="card" style="width: 100%; height: 244px; background: #4298C5;">
          <div class="card-body m-0 pl-5 py-4 d-flex flex-column justify-content-between">
            <h5 class="card-title m-0" style="font-size: 30px; font-weight: 700; color: white; padding-bottom: 16px;">
              <img src="{{ asset('assets/frontend/home/gedung.png') }}" alt="Icon 1" style="width: 41.67px;" class="me-2"> 
              Hybrid
            </h5>
            <h6 class="card-subtitle m-0" style="font-size: 20px; font-weight: 600; color: white;">Offline:</h6>
            <p class="card-text m-0" style="font-size: 20px; font-weight: 400; color: white; padding-bottom: 10px;">
              Menara 1 BTN, Jalan Gajah
              Mada No. 1, Jakarta Pusat.
            </p>
            <h6 class="card-subtitle m-0" style="font-size: 20px; font-weight: 600; color: white;">Online:</h6>
            <p class="card-text m-0" style="font-size: 20px; font-weight: 400; color: white;">Zoom Webinar</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4 mb-4">
        <div class="card" style="width: 100%; height: 244px; background: #4298C5;">
          <div class="card-body m-0 pl-5 py-4 d-flex flex-column justify-content-between">
            <h5 class="card-title m-0" style="font-size: 30px; font-weight: 700; color: white;">
              <img src="{{ asset('assets/frontend/home/baju.png') }}" alt="Icon 1" style="width: 41.67px;" class="me-2"> 
              Dresscode <br><br>
              <span class="card-text m-0" style="font-size: 20px; font-weight: 400; color: white;">
                Atasan Kemeja Putih, <br> Bawahan Jeans
              </span>
            </h5>
            
          </div>
        </div>
      </div>
    </div>
    {{-- Text --}}
    <div class="text-center justify-content-center">
        <h1 style="font-weight: 900; font-size: 25px; color: #006CA7;">Final Event BUMN Learning Festival</h1>
    </div>
    <p class="text-center" style="font-size: 16px; line-height: 20px; color: #303030;">
        Join us at the BUMN Learning Festival, where we ignite a movement toward a sustainable learning culture. Under
        the theme "Building Sustainable Learning Culture," this event brings together thought leaders and experts to
        explore key topics such as <b style="color: #004266">AKHLAK, Artificial Intelligence, Employee Well-Being,
            Sustainability, and Critical Thinking</b>.
    </p>
    <p class="text-center" style="margin-bottom: 87px; font-size: 16px; line-height: 20px; color: #303030;">
        This festival is designed to inspire employees to continuously learn, grow, and adapt in a rapidly evolving
        world. Through engaging discussions and interactive sessions, you'll gain valuable insights and tools to improve
        both professionally and personally. Don't miss this opportunity to be part of a learning revolution that shapes
        the future of work!
    </p>
</div>

<style>
    @media (max-width: 768px) {
        h1 {
            font-size: 22px;
            /* Mengurangi ukuran font pada layar kecil */
        }

        p {
            font-size: 14px;
            /* Mengurangi ukuran font paragraf */
            line-height: 18px;
            /* Mengurangi line height untuk teks lebih rapat */
        }
    }
</style>

<div class="container-fluid mt-5 m-auto d-flex align-items-center justify-content-center"
    style="background-color: #01436F;">
    <div class="row" style="max-width: 1200px; padding-top: 97px; padding-bottom: 107px">
        <!-- Phone Image -->
        <div class="col-md-4 d-flex justify-content-center align-items-baseline">
            <img src="{{ asset('assets/frontend/home/registrasi_1.png') }}" alt="Phone" class="d-none d-md-flex">
        </div>

        <!-- Steps Content -->
        <div class="col-md-8">
            <h1 style="font-size: 30px; font-weight: 900; color: #fff;">Panduan Langkah Registrasi</h1>
            <p style="font-size: 18px; color: #fff; margin-bottom: 70px;">Final Event BUMN Learning Festival</p>

            <!-- Row for splitting Steps 1-3 and 4-6 -->
            <div class="row">
                <!-- Steps 1-3 -->
                <div class="col-md-5">
                    <div class="row mb-5 mb-lg-5">
                        <div class="col-2">
                            <div
                                style="background-color: white; color: #01436F; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                1
                            </div>
                        </div>
                        <div class="col-10" style="color:white">
                            Pilih Registrasi, <b>ONLINE atau OFFLINE</b>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-2">
                            <div
                                style="background-color: white; color: #01436F; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                2
                            </div>
                        </div>
                        <div class="col-10" style="color:white">
                            Isi Formulir data diri anda dengan lengkap, lalu <b>"Submit"</b>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-2">
                            <div
                                style="background-color: white; color: #01436F; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                3
                            </div>
                        </div>
                        <div class="col-10" style="color:white">
                            Kemudian anda akan mendapatkan <b>Digital Card Image</b>
                        </div>
                    </div>
                </div>

                <!-- Steps 4-6 -->
                <div class="col-md-6">
                    <div class="row mb-5 mb-lg-3">
                        <div class="col-2">
                            <div
                                style="background-color: white; color: #01436F; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                4
                            </div>
                        </div>
                        <div class="col-10" style="color:white">
                            Di halaman Digital Card Image, Anda bisa memilih untuk <b>Download</b> atau <b>Kirim Via
                                Email</b>
                        </div>
                    </div>

                    <div class="row mb-5 mb-lg-4">
                        <div class="col-2">
                            <div
                                style="background-color: white; color: #01436F; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                5
                            </div>
                        </div>
                        <div class="col-10" style="color:white">
                            Di dalam Digital Card Image terdapat <b>ID Number dan QR Code</b>, untuk memasuki acara
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-2">
                            <div
                                style="background-color: white; color: #01436F; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                6
                            </div>
                        </div>
                        <div class="col-10" style="color:white">
                            Saat hadir di lokasi acara, peserta diwajibkan menuju <b>Counter Check-In</b> sesuai dengan
                            Kode Huruf yang tertera di ID Card Online dan mendapatkan ID Card Fisik.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid h-auto" style="margin-bottom: 70px; background-color: #4298C5">
    <div class="row m-auto gap-lg-0 gap-4 " style="max-width: 1130px; padding-top: 88px; padding-bottom: 87px">
        <div class="col-md-4 d-flex align-items-center">
            <div>
                <h1 style="color:white; font-size: 40px; font-weight: 800;">Registrasi</h1>
                <p style="color:white;font-size: 25px; font-weight: 400; max-width: 250px;">Final Event BUMN Learning
                  Festival
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative card overflow-hidden" style="border-radius: 28px; height: auto; width: 100%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background: url('{{ asset('assets/frontend/home/bg-card.png') }}') no-repeat; background-size: cover;">
                <img src="{{ asset('AKSEN.png')}}" alt="BUMN Learning Festival" class="position-absolute d-flex justify-content-center z-1" style="bottom: 0; right: -5%; width: 290px;">
                <div class="p-lg-5 p-3 z-2">
                    <img src="{{ asset('bumn-logo-final.png') }}" width="160px" alt="" class="pb-3">
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: #003E64;">Pendaftaran Peserta
                    </h5>
                    <h6 class="card-subtitle mb-3" style="font-size: 30px; font-weight: 800; color: #003E64;">ONLINE</h6>
                    {{-- <a href="{{ route('registration.index.online') }}" class="btn"
                        style="background-color: #003E64; color: white; font-weight: bold; border-radius: 5px; padding: 10px 20px; font-size: 20px;">Klik Disini
                    </a> --}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-relative card overflow-hidden" style="border-radius: 28px; height: auto; width: 100%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background: url('{{ asset('assets/frontend/home/bg-card.png') }}') no-repeat; background-size: cover;">
                <img src="{{ asset('AKSEN.png')}}" alt="BUMN Learning Festival" class="position-absolute d-flex justify-content-center z-1" style="bottom: 0; right: -5%; width: 290px;">
                <div class="p-lg-5 p-3 z-2">
                    <img src="{{ asset('bumn-logo-final.png') }}" width="160px" alt="" class="pb-3">
                    <h5 class="card-title font-weight-lighter text-success m-0" style="font-size: 20px;">Pendaftaran Peserta
                    </h5>
                    <h6 class="card-subtitle mb-3 text-success" style="font-size: 30px; font-weight: 800;">OFFLINE</h6>
                    {{-- <a href="{{ route('registration.index') }}" class="btn bg-success"
                        style="color: white; font-weight: bold; border-radius: 5px; padding: 10px 20px; font-size: 20px;">Klik Disini
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mb-5" style="max-width: 1170px;px; margin: auto; padding: 20px; text-align: center;">
    <h2 style="margin-bottom: 20px; font-size: 40px ; font-weight:800; color: #01436F">Rundown</h2>
    <h5 style="font-size: 25px ; font-weight: 500; color: #01436F">Final Event BUMN Learning Festival</h5>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-lg-4 mt-4">
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0"
                        style="font-size: 20px; color: white; max-width: 120px">MC Opening</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">08.45</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden"
                style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1"
                    style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0"
                        style="font-size: 20px; color: white; max-width: 136px">Opening Speech Ketua Umum FHCI</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">09.05</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0"
                        style="font-size: 20px; color: white; max-width: 136px">Keynote Speech</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">09.15</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0"
                        style="font-size: 20px; color: white; max-width: 227px">Talkshow Sesi 1 " How To Cultivate
                        AKHLAK To Achieve " Indonesia Emas 2045" As Insan BUMN</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">09.30</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white; max-width: 227px">Expert Session Linkedin</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">10.00</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white; max-width: 165px">Talkshow Sesi 2
                        "How To Embed Continuous Learning into Lifestyle"
                    </h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">10.30</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden"
                style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 14px; color: white; max-width: 270px">Pengumuman Kompetisi Challenge Kategori Perusahaan dengan Tema <b style="font-size: 14px">"AKHLAKIN KALEIDOSCOPE: 4 YEARS OF SOLID TRANSFORMATION"</b> <br> dan Kategori Individu dengan Tema <b style="font-size: 14px">"A DAY IN MY LIFE WITH AKHLAK"</b></h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">11.35</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0"
                        style="font-size: 20px; color: white; max-width: 165px">Pengumuman Super Learner Award</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">11.45</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white; max-width: 165px">Ceremonial Komitmen Bersama</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">11.55</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 pb-lg-0 pb-3 text-start">
            <div class="position-relative card overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 270px; height: 270px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s; background-color: #01436F; margin: 0 auto;">
                <img src="{{ asset('AKSEN.png') }}" alt="BUMN Learning Festival" class="position-absolute z-1" style="bottom: 0; right: -5%; width: 270px; opacity: 0.3;">
                <div class="d-flex flex-column justify-content-between h-100 p-4 z-2">
                    <h5 class="card-title font-weight-lighter m-0"
                        style="font-size: 20px; color: white; max-width: 165px">Artist Performance</h5>
                    <h5 class="card-title font-weight-lighter m-0" style="font-size: 20px; color: white;">12.00</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection