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
        <div class="d-flex align-items-center justify-content-center mb-2" style="color: #003E64; font-weight: 900;">
            <h1>REGISTRASI</h1>
        </div>
    </div>
    <form class="card card-md border-0 bg-transparent border" action="{{ route('registration.store') }}" method="POST" id="registrationForm" autocomplete="off" novalidate>
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
    

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label required" style="color:#005CA4; font-size: 18px;">Nama</label>
                    <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap anda" height="60px" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label required" style="color:#005CA4; font-size: 18px;">Nomor telepon</label>
                    <input type="number" class="form-control" name="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" required />
                    @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        
            <div class="row mb-3">
                <div class="col">
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
                <div class="col">
                    <label class="form-label" style="color:#005CA4; font-size: 18px;">Jabatan <small class="text-muted">(optional)</small>:</label>
                    <input type="text" class="form-control" name="jabatan" placeholder="Nama Jabatan" value="{{ old('jabatan') }}">
                    @error('jabatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        
            <div class="mb-3">
                <label class="form-label required" style="color:#005CA4; font-size: 18px;">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Masukkan alamat email valid anda" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="form-footer">
                <button type="button" id="submit-button" class="btn w-100 rounded-full text-uppercase mb-2" style="background-color: #0566AE; color: white;" onclick="submitForm('registration.store')">On Site</button>
                <button type="button" class="btn w-100 rounded-full" style="background-color: #003E64; color: white;" onclick="submitForm('registration.store.online')">Online</button>
                {{-- {{ route('registration.store.online') }} --}}
            </div>
        </div>
    </form>

    <script>
        function updateButtonVisibility() {
            const select = document.getElementById('instansi_id');
            const selectedOption = select.options[select.selectedIndex];
            const maxParticipants = parseInt(selectedOption.getAttribute('data-max'));
            const currentParticipants = parseInt(selectedOption.getAttribute('data-current-participants') || '0');

            const submitButton = document.getElementById('submit-button');
            const quotaMessage = document.getElementById('quota-message');

            if (currentParticipants >= maxParticipants) {
                submitButton.style.display = 'none';
                quotaMessage.style.display = 'block'; // Tampilkan pesan kuota penuh
            } else {
                submitButton.style.display = 'block';
                quotaMessage.style.display = 'none'; // Sembunyikan pesan kuota penuh
            }
        }

        // Call the function on page load to set the initial visibility
        window.onload = updateButtonVisibility;

    </script>

    <script>
        function submitForm(route) {
            const form = document.getElementById('registrationForm');
            if (route === 'registration.store') {
                form.action = "{{ route('registration.store') }}";
            } else if (route === 'registration.store.online') {
                form.action = "{{ route('registration.store.online') }}";
            }
            form.submit();
        }
    </script>
    

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
