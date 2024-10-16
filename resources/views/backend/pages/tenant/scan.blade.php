@extends('backend.templates.scan')
@section('title', 'Scan Tambah Point')
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
      <div class="text-center fs-1 fw-bold mb-3 text-primary">Scan Tambah Point</div>
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
    $('#search').on('keyup', function() {
        var search = $(this).val();
        console.log(search);
        
        if (search.trim() === '') {
            $('#result').html('');
            return;
        }

        $.ajax({
            url: '/tenant/participant/autocomplete',
            type: 'GET',
            data: { search: search },
            success: function(data) {
                console.log(data);
                $('#result').html('');

                if (data.participants.length > 0) {
                    var table = '<div class="table-responsive mt-3"><table class="table table-bordered"><thead><tr><th>QR Code</th><th>Name</th><th>Instansi</th><th>Points</th><th>Action</th></tr></thead><tbody>';

                    data.participants.forEach(function(participant) {
                        table += '<tr>';
                        table += '<td class="align-middle">' + participant.qrcode + '</td>';
                        table += '<td class="align-middle">' + participant.name + '</td>';
                        table += '<td class="align-middle">' + participant.instansi + '</td>';
                        table += '<td class="align-middle">' + participant.point + '</td>';
                        if (participant.disableButton) {
                            table += '<td class="align-middle"><button class="btn btn-success hadirButton" data-id="' + participant.qrcode + '" disabled>Tambah</button></td>';
                        } else {
                            table += '<td class="align-middle"><button class="btn btn-success hadirButton" data-id="' + participant.qrcode + '">Tambah</button></td>';
                        }
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

    var html5QrCode = new Html5Qrcode("reader");
    var isScanning = false;
    var scannedDataBuffer = "";

    function onScanSuccess(decodedText, decodedResult) {
        if (!isScanning) {
            isScanning = true;
            showPointAlert(decodedText);

            setTimeout(function() {
                isScanning = false;
            }, 3000);
        }
    }

    function showPointAlert(qrcode) {
        $.ajax({
            url: "{{ route('tenant.point', ':qrcode') }}".replace(':qrcode', qrcode),
            method: 'GET',
            success: function(response) {
                Swal.fire({
                    icon: 'info',
                    title: 'Participant Details',
                    html: `
                        <b>Name :</b> ${response.name}<br>
                        <b>QRCode :</b> ${response.qrcode}<br>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Tambah Point',
                    cancelButtonText: 'Cancel',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        pointOk(qrcode);
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

    function pointOk(qrcode) {
        $.ajax({
            url: "{{ route('tenant.point.ok', ':qrcode') }}".replace(':qrcode', qrcode),
            method: 'GET',
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success,
                    confirmButtonText: 'OK',
                    showConfirmButton: true,
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
        showPointAlert(qrcode);
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