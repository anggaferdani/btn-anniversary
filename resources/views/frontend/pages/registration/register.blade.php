@extends('backend.templates.scan')
@section('title', 'REGISTRASI BUMN LEARNING FESTIVAL 2024')
@section('content')
<div class="container">
  <div class="col-md-6 m-auto mb-3">
    <div class="text-center">
      <img src="{{ asset('assets/partner.png') }}" class="" width="200">
    </div>
    <div class="text-center mb-3">
      <img src="{{ asset('logobaru.png') }}" class="" width="150">
    </div>
    <form action="{{ route('registration.store') }}" method="POST" class="">
      @csrf
      <div class="card">
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label required">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" autocomplete="off">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Instansi</label>
            <select id="instansiSelect" class="selectpicker border rounded" data-live-search="true" name="instansi_id" style="width: 100% !important;">
              <option disabled selected value="">Pilih</option>
              @foreach($instansis as $instansi)
                  @php
                      $currentCount = $instansi->participants->where('verification', 1)->count();
                      $maxCount = $instansi->max_participant;
                      $isOnline = $instansi->status_kehadiran == 'online';
                  @endphp
                  <option value="{{ $instansi->id }}" data-status-kehadiran="{{ $instansi->status_kehadiran }}" 
                      @if(!$isOnline && $currentCount >= $maxCount) 
                          disabled 
                      @endif
                  >
                      {{ $instansi->name }} 
                      @if($isOnline)
                          (Online)
                      @else
                          ({{ $currentCount }}/{{ $maxCount }})
                      @endif
                  </option>
              @endforeach
            </select>
            @error('instansi_id')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" autocomplete="off">
            @error('jabatan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off">
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Phone Number</label>
            <input type="number" class="form-control" name="phone_number" placeholder="Phone Number" autocomplete="off">
            @error('phone_number')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div id="kehadiranDiv" style="display:none;" class="mb-3">
            <label class="form-label required">Pilih metode kehadiran?</label>
            <div class="form-selectgroup-boxes row g-2 mb-3">
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="kehadiran" value="onsite" class="form-selectgroup-input" checked="">
                  <span class="form-selectgroup-label d-flex align-items-center p-3 border border-3 border-success">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1 text-success fw-bold">Offline</span>
                      <span class="d-block text-secondary">Mengikuti kegiatan secara offline ditempat</span>
                    </span>
                  </span>
                </label>
              </div>
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="kehadiran" value="online" class="form-selectgroup-input">
                  <span class="form-selectgroup-label d-flex align-items-center p-3 border border-3 border-primary">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1 text-primary fw-bold">Online</span>
                      <span class="d-block text-secondary">Mengikuti kegiatan secara daring melalui zoom</span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
          </div>
          <div id="kendaraanDiv" style="display:none;" class="mb-3">
            <label class="form-label">Apakah membawa kendaraan pribadi?</label>
            <select class="form-select" name="kendaraan">
              <option disabled selected value="">Pilih</option>
              <option value="mobil">Mobil</option>
              <option value="motor">Motor</option>
            </select>
            @error('kendaraan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('scripts')
<script>
  $(document).ready(function() {
    @if(session('success'))
      Swal.fire({
          icon: 'success',
          title: 'Success',
          text: "{{ session('success') }}",
          confirmButtonText: 'OK',
          showCancelButton: false,
          allowOutsideClick: false
      })
    @endif

    @if(session('error'))
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: "{{ session('error') }}",
          timer: 2000,
          showConfirmButton: false
      });
    @endif
  });
</script>
<script>
  $(document).ready(function() {
    $('#instansiSelect').on('change', function() {
        var statusKehadiran = $(this).find(':selected').data('status-kehadiran');

        $('#kehadiranInput').val('');
        $('input[name="kehadiran"]').prop('checked', false);
        $('select[name="kendaraan"]').val('');
        
        $('#kehadiranInput').val(statusKehadiran);
        
        if (statusKehadiran === 'hybrid') {
            $('#kehadiranDiv').show();
            $('#kendaraanDiv').hide(); // hide by default
            $('input[name="kehadiran"]').attr('required', true);
        } else if (statusKehadiran === 'online') {
            $('#kehadiranDiv').hide();
            $('#kendaraanDiv').hide();
            $('input[name="kehadiran"][value="online"]').prop('checked', true);
            $('input[name="kehadiran"]').removeAttr('required');
        } else {
            $('#kehadiranDiv').hide();
            $('#kendaraanDiv').hide();
            $('input[name="kehadiran"]').removeAttr('required');
        }
    });

    // Add event listener for the 'kehadiran' radio buttons
    document.querySelectorAll('input[name="kehadiran"]').forEach(function (element) {
        element.addEventListener('change', function () {
            const kehadiran = this.value;

            if (kehadiran === 'onsite') {
                $('#kendaraanDiv').show(); // Show kendaraanDiv when onsite is selected
                $('select[name="kendaraan"]').attr('required', true);
            } else {
                $('#kendaraanDiv').hide(); // Hide kendaraanDiv for other options
                $('select[name="kendaraan"]').removeAttr('required');
                $('select[name="kendaraan"]').val(''); // Clear selection
            }
        });
    });
});
</script>
@endpush