<nav class="navbar navbar-expand-lg navbar-light ftco_navbar bg-transparent ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ asset('bumn-learning-festival.png')}}" alt="Logo" style="height: 60px; margin-right: 8px;">
        </a>
        <button class="navbar-toggler text-dark" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#detailacara" class="nav-link">Detail Acara</a></li>
                <li class="nav-item"><a href="#jadwalacara" class="nav-link">Jadwal Acara</a></li>
                <li class="nav-item cta mr-md-2"><a href="{{ route('registration.index') }}" class="nav-link">Registrasi</a></li>
                <li class="nav-item cta mr-md-2"><a href="{{ route('registration.index.online') }}" class="nav-link">Registrasi Online</a></li>
            </ul>
        </div>
    </div>
</nav>