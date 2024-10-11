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
          <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.dashboard') ? 'fw-bold' : '' }}" href="{{ route('admin.dashboard') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-house"></i></span><span class="nav-link-title">Dashboard</span></a></li>
          <li class="nav-item {{ Route::is('admin.leaderboard') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.leaderboard') ? 'fw-bold' : '' }}" href="{{ route('admin.leaderboard') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-tag"></i></span><span class="nav-link-title">Leaderboard</span></a></li>
          <li class="nav-item {{ Route::is('admin.zoom.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.zoom.*') ? 'fw-bold' : '' }}" href="{{ route('admin.zoom.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-tag"></i></span><span class="nav-link-title">Zoom</span></a></li>
          <li class="nav-item {{ Route::is('admin.instansi.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.instansi.*') ? 'fw-bold' : '' }}" href="{{ route('admin.instansi.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-tag"></i></span><span class="nav-link-title">Instansi</span></a></li>
          <li class="nav-item {{ Route::is('admin.admin.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.admin.*') ? 'fw-bold' : '' }}" href="{{ route('admin.admin.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Admin</span></a></li>
          <li class="nav-item {{ Route::is('admin.receptionist.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.receptionist.*') ? 'fw-bold' : '' }}" href="{{ route('admin.receptionist.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Receptionist</span></a></li>
          <li class="nav-item {{ Route::is('admin.tenant.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.tenant.*') ? 'fw-bold' : '' }}" href="{{ route('admin.tenant.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Tenant</span></a></li>
          <li class="nav-item {{ Route::is('admin.participant.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.participant.*') ? 'fw-bold' : '' }}" href="{{ route('admin.participant.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Participant</span></a></li>
          <li class="nav-item {{ Route::is('admin.attendance-participant.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.attendance-participant.*') ? 'fw-bold' : '' }}" href="{{ route('admin.attendance-participant.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Attendance Participant</span></a></li>
          <li class="nav-item {{ Route::is('admin.history') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.history') ? 'fw-bold' : '' }}" href="{{ route('admin.history') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Point History</span></a></li>
        @endif
        @if(auth()->user()->role == 2)
          <li class="nav-item {{ Route::is('receptionist.dashboard') ? 'active' : '' }}"><a class="nav-link {{ Route::is('receptionist.dashboard') ? 'fw-bold' : '' }}" href="{{ route('receptionist.dashboard') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-house"></i></span><span class="nav-link-title">Dashboard</span></a></li>
          <li class="nav-item {{ Route::is('receptionist.participant.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('receptionist.participant.*') ? 'fw-bold' : '' }}" href="{{ route('receptionist.participant.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Participant</span></a></li>
          <li class="nav-item {{ Route::is('receptionist.scan') ? 'active' : '' }}"><a class="nav-link {{ Route::is('receptionist.scan') ? 'fw-bold' : '' }}" href="{{ route('receptionist.scan') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-expand"></i></span><span class="nav-link-title">Scan</span></a></li>
          <li class="nav-item {{ Route::is('receptionist.attendance-participant.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('receptionist.attendance-participant.*') ? 'fw-bold' : '' }}" href="{{ route('receptionist.attendance-participant.index') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Attendance Participant</span></a></li>
          @endif
          @if(auth()->user()->role == 3)
          <li class="nav-item {{ Route::is('tenant.dashboard') ? 'active' : '' }}"><a class="nav-link {{ Route::is('tenant.dashboard') ? 'fw-bold' : '' }}" href="{{ route('tenant.dashboard') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-house"></i></span><span class="nav-link-title">Dashboard</span></a></li>
          <li class="nav-item {{ Route::is('tenant.scan') ? 'active' : '' }}"><a class="nav-link {{ Route::is('tenant.scan') ? 'fw-bold' : '' }}" href="{{ route('tenant.scan') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-expand"></i></span><span class="nav-link-title">Scan</span></a></li>
          <li class="nav-item {{ Route::is('tenant.history') ? 'active' : '' }}"><a class="nav-link {{ Route::is('tenant.history') ? 'fw-bold' : '' }}" href="{{ route('tenant.history') }}" ><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fa-solid fa-user"></i></span><span class="nav-link-title">Point History</span></a></li>
        @endif
      </ul>
    </div>
  </div>
</aside>