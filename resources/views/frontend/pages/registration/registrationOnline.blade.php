@extends('frontend.templates.registration')
@section('title', 'Registration | BTN Anniversary')
@section('content')
<div class="container container-sm py-4" style="max-width: 900px; margin: auto;">
    <div class="text-center mb-4">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark me-3">
                <img src="{{ asset('bumn-learning-festival.png') }}" width="200" alt="btn">
            </a>
        </div>
    </div>
    <form class="card card-md" action="{{ route('registration.store.online') }}" method="POST" autocomplete="off" novalidate>
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
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="mb-3">
                <label class="form-label required">Instansi</label>
                <select class="form-control" name="instansi_id" required id="instansi_id" onchange="updateButtonVisibility()">
                    <option value="">Pilih Instansi</option>
                    @foreach ($instansis as $instansi)
                        <option value="{{ $instansi->id }}">
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
            
        
            <div class="mb-3">
                <label class="form-label">Jabatan <small class="text-muted">(optional)</small>:</label>
                <input type="text" class="form-control" name="jabatan" placeholder="Nama Jabatan" value="{{ old('jabatan') }}">
                @error('jabatan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="mb-3">
                <label class="form-label required">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan alamat email valid anda" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="mb-3">
                <label class="form-label required">Nomor telepon</label>
                <input type="number" class="form-control" name="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" required />
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="form-footer">
                <button type="submit" class="btn btn-success w-100 rounded-full">Online</button>
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
