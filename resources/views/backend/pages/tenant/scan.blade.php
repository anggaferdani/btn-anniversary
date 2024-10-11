@extends('backend.templates.scan')
@section('title', 'Scan Tukar Point')
@section('content')
<div class="container-xl" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
  <div class="row w-100">
    <div class="col-6 m-auto">
      <div class="text-center mb-3">
        <img src="{{ asset('bumn-learning-festival.png') }}" class="" width="150">
      </div>
      <div class="text-center fs-1 fw-bold mb-3">Scan Tukar Point</div>
      <div class="d-flex justify-content-center">
        <div id="reader" style="width: 400px;" class=""></div>
      </div>
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