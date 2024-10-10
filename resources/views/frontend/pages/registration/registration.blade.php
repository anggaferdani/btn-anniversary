@extends('frontend.templates.registration')
@section('title', 'Registration | BTN Anniversary')
@section('content')
<div class="container container-tight py-4">
    <div class="text-center mb-4">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <!-- Gambar di sebelah kiri -->
            <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark me-3">
                <img src="{{ asset('bumn-learning-festival.png') }}" width="200" alt="btn">
            </a>
        </div>
    </div>
    <form class="card card-md" action="{{ route('registration.store') }}" method="POST" autocomplete="off" novalidate>
        @csrf
        <div class="card-body">
            
            {{-- Notif --}}
            @if(Session::get('success'))
                <div class="alert alert-important alert-success" role="alert">
                {{ Session::get('success') }}
                </div>
            @endif
            @if(Session::get('error'))
                <div class="alert alert-important alert-danger" role="alert">
                {{ Session::get('error') }}
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label required">Nama Lengkap</label>
                <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap anda" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div> <!-- Display error message for name -->
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label required">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan alamat email valid anda" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div> <!-- Display error message for email -->
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label required">Nomor telepon</label>
                <input type="number" class="form-control" name="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" required />
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div> <!-- Display error message for phone number -->
                @enderror
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Registrasi</button>
            </div>
        </div>
    </form>
</div>
@endsection
