@extends('frontend.templates.registration')
@section('title', 'Registration | BTN Anniversary')
@section('content')
<div class="container container-sm py-4" style="max-width: 1092px; margin: auto; position: relative;">
    <!-- Logo kiri -->
    

    <!-- Konten Form Registrasi -->
    <div class="text-center mb-4">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark me-3">
                <img src="{{ asset('bumn-logo-final.png') }}" class="responsive-logo" alt="btn">
            </a>
        </div>
        
        <style>
            .responsive-logo {
                margin-top: 40%; /* Default margin for large screens */
                width: 223px;
            }
        
            @media (max-width: 768px) {
                .responsive-logo {
                    margin-top: 20%; /* Margin-top for small screens */
                    width: 137px;id
                }
            }
        </style>
        
        <div class="d-flex align-items-center justify-content-center mb-0" style="color: #0566AE; font-weight: 1000;">
            <h1 class="responsive-title" style="color: #0566AE; font-weight: 800;">REGISTRASI OFFLINE</h1>

            <style>
                .responsive-title {
                    font-size: 40px; /* Default size for large screens */
                }

                @media (max-width: 768px) {
                    .responsive-title {
                        font-size: 25px; /* Size for small screens */
                    }
                }
            </style>
        </div>
    </div>
    
    <!-- Form Registrasi -->
    <form class="border-0 bg-transparent border" action="{{ route('registration.store') }}" method="POST" id="registrationForm" autocomplete="off" novalidate>
        @csrf
        <div class="card-body">
            {{-- Notifikasi Sukses dan Error --}}
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

            <!-- Nama dan Nomor Telepon -->
            <div class="row mb-3">
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label required" style="color:#005CA4; font-size: 18px;">Nama</label>
                    <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap anda" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label required" style="color:#005CA4; font-size: 18px;">Nomor telepon</label>
                    <input type="number" class="form-control" name="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" required />
                    @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Instansi dan Jabatan -->
            <div class="row mb-3">
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label required" style="color:#005CA4; font-size: 18px;">Instansi</label>
                    <select class="form-control mb-2" name="instansi_id" required id="instansi_id" onchange="updateButtonVisibility()">
                        <option value="">Pilih Instansi</option>
                        @foreach ($instansis as $instansi)
                            <option value="{{ $instansi->id }}" 
                                    data-max="{{ $instansi->max_participant }}" 
                                    data-current-participants="{{ $instansi->participants_count }}">
                                {{ $instansi->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('instansi_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <!-- Pesan jika kuota penuh -->
                    <div id="quota-message" class="text-danger" style="display:none;">
                        Kuota pendaftaran on-site Instansi Anda telah maksimal. Anda dapat melakukan pendaftaran Online
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label" style="color:#005CA4; font-size: 18px;">Jabatan <small class="text-muted">(optional)</small>:</label>
                    <input type="text" class="form-control" name="jabatan" placeholder="Nama Jabatan" value="{{ old('jabatan') }}">
                    @error('jabatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label required" style="color:#005CA4; font-size: 18px;">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan alamat email valid anda" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="form-footer">
                <button type="submit" id="submit-button" class="btn w-100 rounded-full text-uppercase mb-2" style="background-color: #0566AE; color: white;">Submit</button>
            </div>
        </div>
    </form>
</div>

<style>
    .form-control {
        border-radius: 4px; /* Rounded corners */
        border: 1px solid #ccc; /* Light border */
        padding: 12px; /* Increased padding */
        font-size: 16px; /* Increased font size */
    }

    .btn {
        padding: 12px; /* Increase button padding */
        font-size: 16px; /* Match font size */
        border-radius: 4px; /* Match rounded corners */
    }

    .alert {
        margin-bottom: 20px; /* Spacing for alerts */
    }
</style>

@endsection
