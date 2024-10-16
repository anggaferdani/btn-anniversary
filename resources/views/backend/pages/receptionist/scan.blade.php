@extends('backend.templates.scan')
@section('title', 'Scan Kehadiran Participant')
@section('content')
<div class="container-xl" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
  <div class="w-100">
    <div class="col-md-4 m-auto mb-3">
      <div class="text-center mb-3">
        <img src="{{ asset('assets/final-event.png') }}" class="" width="150">
      </div>
      <div class="text-center mb-3">
        <img src="{{ asset('assets/partner.png') }}" class="" width="200">
      </div>
      <div class="text-center fs-1 fw-bold mb-3 text-primary">Scan Kehadiran Participant</div>
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <div id="reader" style="width: 310px;" class=""></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-7 m-auto">
      <div class="card">
        <div class="card-body">
          <input type="text" class="form-control" placeholder="Search" id="search">
          <div id="result"></div>
        </div>
      </div>
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
            url: "{{ route('receptionist.attendance', ':qrcode') }}".replace(':qrcode', qrcode),
            method: 'GET',
            success: function(response) {
                Swal.fire({
                    icon: 'info',
                    title: 'Participant Details',
                    html: `
                        <b>Name :</b> ${response.name}<br>
                        <b>QRCode :</b> ${response.qrcode}<br>
                        <b>Email :</b> ${response.email}<br>
                        <b>Phone Number :</b> ${response.phone_number}<br>
                        <b>Points :</b> ${response.point}
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Absen',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        attendanceOk(qrcode);
                    } else {
                        $('#search').val('');
                        $('#result').html('');
                    }
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

    function attendanceOk(qrcode) {
        $.ajax({
            url: "{{ route('receptionist.attendance.ok', ':qrcode') }}".replace(':qrcode', qrcode),
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

    $('#search').on('keyup', function () {
        var search = $(this).val();
        console.log(search);
        
        if (search.trim() === '') {
            $('#result').html('');
            return;
        }

        $.ajax({
            url: '/receptionist/participant/autocomplete',
            type: 'GET',
            data: { search: search },
            success: function (data) {
                console.log(data);
                $('#result').html('');

                if (data.length > 0) {
                    var table = '<div class="table-responsive mt-3"><table class="table table-bordered"><thead><tr><th>QR Code</th><th>Name</th><th>Email</th><th>Phone Number</th><th>Action</th></tr></thead><tbody>';

                    data.forEach(function(participant) {
                        table += '<tr>';
                        table += '<td class="align-middle">' + participant.qrcode + '</td>';
                        table += '<td class="align-middle">' + participant.name + '</td>';
                        table += '<td class="align-middle">' + participant.email + '</td>';
                        table += '<td class="align-middle">' + participant.phone_number + '</td>';
                        table += '<td class="align-middle"><button class="btn btn-primary hadirButton" data-id="' + participant.qrcode + '">Hadir</button></td>';
                        table += '</tr>';
                    });

                    table += '</tbody></table></div>';
                    $('#result').append(table);
                } else {
                    $('#result').append('<div class="table-responsive mt-3"><table class="table table-bordered"><tr><td colspan="5" class="text-center align-middle">No participant found</td></tr></table></div>');
                }
            },
            error: function() {
                $('#result').html('<div class="table-responsive mt-3"><table class="table table-bordered"><tr><td colspan="5" class="text-center align-middle">No participant found</td></tr></table></div>');
            }
        });
    });

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