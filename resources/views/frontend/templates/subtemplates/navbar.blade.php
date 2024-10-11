<nav class="navbar navbar-expand-lg bg-body-tertiary px-lg-5 px-md-4 px-sm-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('bumn-learning-festival1.png') }}" alt="BUMN Learning Festival" width="92px" height="62px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item me-lg-2">
                    <a href="{{ route('registration.index') }}" class="btn"
                        style="background-color: #0566AE; color: white; font-weight: bold; border-radius: 5px; padding: 10px 20px; font-size: 20px">Registrasi</a>
                </li>
                <li class="nav-item d-sm-hidden">
                    <a href="https://www.youtube.com/@bankbtn" class="btn"
                        style="background: linear-gradient(90deg, #E82036, #750002); color: white; font-weight: bold; border-radius: 5px; padding: 10px 20px; font-size: 20px">Live Stream</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
