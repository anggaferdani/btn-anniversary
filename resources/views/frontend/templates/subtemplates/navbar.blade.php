<nav class="navbar navbar-expand-lg bg-body-tertiary px-lg-5 px-md-4 px-sm-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('bumn-logo-final.png') }}" alt="BUMN Learning Festival" width="92px" height="62px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-center">
                {{-- <li class="nav-item">
                    <a href="{{ route('registration.index.online') }}" class="text-uppercase"
                        style="color: #01436F; padding-right: 20px; font-size: 20px; text-decoration: none">Registrasi Online</a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('registration.index') }}" class="text-uppercase"
                        style="color: #0566AE; font-size: 20px; text-decoration: none">Registrasi </a>
                </li>
                <div class="d-lg-flex d-sm-none " style="height: 30px; padding-left: 30px; padding-right: 30px">
                    <div class="vr"></div>
                </div>
                <li class="nav-item d-sm-hidden">
                    <!-- Trigger modal -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#liveStreamModal"
                        style="background: linear-gradient(90deg, #E82036, #750002); padding: 10px 20px; color: white; font-weight: bold; border-radius: 5px; font-size: 20px; height: 38px; width: 147px; text-decoration: none">Live Stream</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="liveStreamModal" tabindex="-1" aria-labelledby="liveStreamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="liveStreamModalLabel">Live Stream</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Embed YouTube Video -->
        <div class="ratio ratio-16x9">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/DOOrIxw5xOw?si=wy-kbNmfs2mNBFpz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>