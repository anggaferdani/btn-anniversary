@extends('backend.templates.scan')
@section('title', 'Scan Kehadiran Participant')
@section('content')
<div class="container" style="transform: scale(1); transform-origin: top center;">
  <div class="col-md-4 m-auto mb-3">
    <div class="text-center mb-3">
      <img src="{{ asset('assets/final-event.png') }}" class="" width="100">
    </div>
    <div class="text-center mb-3">
      <img src="{{ asset('assets/partner.png') }}" class="" width="150">
    </div>
    <div class="text-center fs-1 fw-bold mb-3 text-primary">Leaderboard</div>
  </div>
  <div class="d-flex justify-content-center gap-1" id="leaderboardContainer" style="width: 100%;"></div>
</div>
<style>
  .truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 150px; /* Adjust the width as needed */
  }
</style>

@endsection
@push('scripts')
<script>
  function fetchLeaderboard() {
    $.ajax({
      url: "{{ route('admin.ajax.leaderboard') }}",
      type: 'GET',
      success: function(response) {
        let html = '';
        let participants = response;
        const tableSize = 10;

        // Loop to create tables based on range 1-10, 11-20, etc.
        for (let i = 0; i < participants.length; i += tableSize) {
          html += `
            <div class="bg-white border border-3 border-primary">
              <table class="table table-striped m-0">
                <thead>
                  <tr>
                    <th class="small p-1">No.</th>
                    <th class="small p-1">ID</th>
                    <th class="small p-1">Name</th>
                    <th class="small p-1">Points</th>
                  </tr>
                </thead>
                <tbody>
            `;

          // Add rows to the current table
          for (let j = i; j < i + tableSize && j < participants.length; j++) {
            html += `
              <tr>
                <td class="small p-1">${j + 1}</td>
                <td class="small p-1 fw-bold text-primary">${participants[j].qrcode}</td>
                <td class="small p-1 fw-bold truncate">${participants[j].name}</td>
                <td class="small p-1 fw-bold text-primary">${participants[j].point}</td>
              </tr>
            `;
          }

          html += `
                  </tbody>
                </table>
              </div>
            `;
        }

        // Inject HTML into leaderboardContainer
        $('#leaderboardContainer').html(html);
      }
    });
  }

  // Initial fetch and refresh every 3 seconds
  $(document).ready(function() {
    fetchLeaderboard();
    setInterval(fetchLeaderboard, 3000); // 3000 ms = 3 seconds
  });
</script>
@endpush
