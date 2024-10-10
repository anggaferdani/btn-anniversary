@extends('backend.templates.pages')
@section('title', 'Scan')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        Scan
      </h2>
    </div>
    <div class="col-auto">
      <div class="btn-list">
        
      </div>
    </div>
  </div>
</div>
@endsection
@section('content')
<div class="container-xl">
  <div class="row">
    <div class="col-6 m-auto">
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
      <div id="reader" style="width: 500px;"></div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  $(document).ready(function() {
      var html5QrCode = new Html5Qrcode("reader");
      var isScanning = false;
      var scannedDataBuffer = "";

      function onScanSuccess(decodedText, decodedResult) {
          if (!isScanning) {
              isScanning = true;
              updateAttendance(decodedText);
              
              setTimeout(function() {
                  isScanning = false;
              }, 3000);
          }
      }

      function updateAttendance(qrcode) {
          $.ajax({
              url: "{{ route('tenant.point', ':qrcode') }}".replace(':qrcode', qrcode),
              method: 'GET',
              success: function(response) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: response.success,
                      html: `<b>${response.success}<br>
                             <b>Name :</b> ${response.name}<br>
                             <b>QRCode :</b> ${response.qrcode}<br>
                             <b>Email :</b> ${response.email}<br>
                             <b>Phone Number :</b> ${response.phone}<br>
                             <b>Points :</b> ${response.point}`,
                      timer: 2000,
                      showConfirmButton: false
                  });
              },
              error: function(xhr) {
                  var errorMsg = xhr.responseJSON ? xhr.responseJSON.error : 'An error occurred';
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: errorMsg,
                      timer: 2000,
                      showConfirmButton: false
                  });
              }
          });
      }

      html5QrCode.start(
          { facingMode: "environment" },
          {
              fps: 10,
              qrbox: { width: 250, height: 250 }
          },
          onScanSuccess)
          .catch(err => {
              console.error(err);
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