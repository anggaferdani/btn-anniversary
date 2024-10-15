@extends('backend.templates.scan')
@section('title', 'Participant')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center mb-4">
    <a href="" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('btn.png') }}" width="100" height="" alt="" class="">
    </a>
  </div>
  <div class="card card-md">
    <div class="card-body">
      <h2 class="h2 text-center mb-4">Participant</h2>

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

      <div class="d-flex justify-content-center mb-3">
        <div id="reader" style="width: 310px;" class=""></div>
      </div>

      <form action="{{ route('post.hadir') }}" method="post">
        @csrf
        <div class="mb-3">
          <label class="form-label">ID</label>
          <input type="text" class="form-control" name="qrcode" placeholder="ID" value="{{ old('qrcode') }}">
          @error('qrcode')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label required">Nama</label>
          <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{ old('nama') }}">
          @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Instansi</label>
          <select class="selectpicker border rounded" data-live-search="true" name="instansi" style="width: 100% !important;">
            <option disabled selected value="">Pilih</option>
            @foreach($instansis as $instansi)
                <option value="{{ $instansi->name }}" {{ old('instansi') == $instansi->name ? 'selected' : '' }}>{{ $instansi->name }}</option>
            @endforeach
          </select>
          @error('instansi')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Hadir</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    var html5QrCode = new Html5Qrcode("reader");
    var isScanning = false;
    var scannedDataBuffer = "";

    function onScanSuccess(decodedText, decodedResult) {
        if (!isScanning) {
            isScanning = true;
            showParticipantAlert(decodedText);
            
            setTimeout(function() {
                isScanning = false;
            }, 3000);
        }
    }

    function showParticipantAlert(qrcode) {
        $.ajax({
            url: "{{ route('check', ':qrcode') }}".replace(':qrcode', qrcode),
            method: 'GET',
            success: function(response) {
                Swal.fire({
                    icon: 'info',
                    title: 'Participant',
                    html: `
                        <b>ID :</b> ${response.qrcode}<br>
                        <b>Nama :</b> ${response.nama}<br>
                        <b>Instansi :</b> ${response.instansi}
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Hadir',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        checkOk(qrcode);
                    } else {
                        $('#search').val('');
                        $('#result').html('');
                    }
                });
            },
            error: function(xhr) {
                var errorMsg = xhr.responseJSON ? xhr.responseJSON.error : 'Error';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    timer: 2000,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }
        });
    }

    function checkOk(qrcode) {
        $.ajax({
            url: "{{ route('check.ok', ':qrcode') }}".replace(':qrcode', qrcode),
            method: 'GET',
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success,
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                }).then(() => {
                    $('#search').val('');
                    $('#result').html('');
                });
            },
            error: function(xhr) {
                var errorMsg = xhr.responseJSON ? xhr.responseJSON.error : 'An error occurred';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    timer: 2000,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }
        });
    }

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 210, height: 210 }
        },
        onScanSuccess)
        .catch(err => {
            console.error(err);
        });

    $(document).on('click', '.hadirButton', function() {
        var qrcode = $(this).data('id');
        showParticipantAlert(qrcode);
    });

    $(document).on('keypress', function(e) {
        if (e.which === 13 && scannedDataBuffer.length > 0) {
            e.preventDefault();
            onScanSuccess(scannedDataBuffer);
            scannedDataBuffer = "";
        } else {
            scannedDataBuffer += String.fromCharCode(e.which);
        }
    });
});
</script>
@endpush