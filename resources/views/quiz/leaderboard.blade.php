@extends('backend.templates.scan')
@section('title', 'Scan Kehadiran Participant')
@section('content')
<div class="container" style="transform: scale(1.3); transform-origin: top center;">
  <div class="col-md-4 m-auto mb-3">
    <div class="text-center mb-3">
      <img src="{{ asset('assets/final-event.png') }}" class="" width="100">
    </div>
    <div class="text-center mb-3">
      <img src="{{ asset('assets/partner.png') }}" class="" width="150">
    </div>
    <div class="text-center fs-1 fw-bold mb-3 text-primary">Quiz Leaderboard</div>
  </div>
  <div class="d-flex justify-content-center gap-1" id="leaderboardContainer" style="width: 100%;"></div>
</div>
<style>
  .truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 150px;
  }
</style>

@endsection
@push('scripts')
<script>
  function fetchLeaderboard() {
    $.ajax({
      url: "{{ route('admin.ajax.leaderboard.quiz') }}",
      type: 'GET',
      success: function(response) {
        let html = '';
        let participants = response;
        const tableSize = 10;

        for (let i = 0; i < participants.length; i += tableSize) {
          html += `
            <div class="bg-white border border-3 border-primary">
              <table class="table table-striped m-0">
                <thead>
                  <tr>
                    <th class="small p-1">No.</th>
                    <th class="small p-1">ID</th>
                    <th class="small p-1">Name</th>
                    <th class="small p-1">Score</th>
                    <th class="small p-1">Waktu Pengerjaan</th>
                  </tr>
                </thead>
                <tbody>
            `;

          for (let j = i; j < i + tableSize && j < participants.length; j++) {
            html += `
              <tr>
                <td class="small p-1">${j + 1}</td>
                <td class="small p-1 fw-bold text-primary">${participants[j].qrcode}</td>
                <td class="small p-1 fw-bold truncate">${participants[j].name}</td>
                <td class="small p-1 fw-bold text-primary text-center">${participants[j].score}</td>
                <td class="small p-1 fw-bold text-primary text-center">${participants[j].waktu_pengerjaan}</td>
              </tr>
            `;
          }

          html += `
                  </tbody>
                </table>
              </div>
            `;
        }

        $('#leaderboardContainer').html(html);
      }
    });
  }

  $(document).ready(function() {
    fetchLeaderboard();
    setInterval(fetchLeaderboard, 3000);
  });
</script>
@endpush
