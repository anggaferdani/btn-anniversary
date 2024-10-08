<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark">
      <a href=".">
        <img src="{{ asset('btn.png') }}" width="70" height="" alt="" class="img-fluid">
      </a>
    </h1>
    <div class="navbar-nav flex-row d-lg-none">
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm">{{ substr(auth()->user()->email, 0, 1) }}</span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ auth()->user()->email }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">
        @if(auth()->user()->role == 1)
          <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}"><a class="nav-link {{ Route::is('dashboard') ? 'fw-bold' : '' }}" href="{{ route('dashboard') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-house"></i></span><span class="nav-link-title">Dashboard</span></a></li>
        @endif
      </ul>
    </div>
  </div>
</aside>