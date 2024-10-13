@extends('backend.templates.pages')
@section('title', 'Dashboard')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        Dashboard
      </h2>
    </div>
  </div>
</div>
@endsection
@section('content')
<div class="container-xl">
  <div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
      <div class="page-body">
        <div class="container-xl">
          <div class="row row-deck row-cards">
            <div class="col-sm-6 col-lg-3">
              <div class="card position-relative overflow-hidden p-2">
                <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="subheader"style="font-size: 11px">Jumlah Registrasi</div>
                  </div>
                  <div class="d-flex align-items-baseline">
                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsCount ?? "0" }}</div>
                  </div>
                  <div id="chart-new-clients" class="chart-sm"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card position-relative overflow-hidden p-2">
                  <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0">
                  <div class="card-body">
                      <div class="d-flex align-items-center mb-3">
                          <div class="subheader">Partisipan Terverifikasi</div>
                      </div>
                      <div class="d-flex align-items-baseline">
                          <div class="h1 me-2" style="font-size: 40px">{{ $participantsVerifiedCount ?? "0" }}</div>
                      </div>
                  <div id="chart-new-clients" class="chart-sm"></div>
                </div>
            </div>
          </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card position-relative overflow-hidden p-2">
                <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="subheader">HADIR (Offline)</div>
                  </div>
                  <div class="d-flex align-items-baseline">
                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsVerifiedOfflineCountHadir ?? "0" }}</div>
                  </div>
                  <div id="chart-new-clients" class="chart-sm"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card position-relative overflow-hidden p-2">
                <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="subheader">BELUM HADIR (Offline)</div>
                  </div>
                  <div class="d-flex align-items-baseline">
                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsVerifiedOfflineCountNotHadir ?? "0" }}</div>
                  </div>
                  <div id="chart-new-clients" class="chart-sm"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-6">
              <div class="card position-relative overflow-hidden p-2">
                <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="390" style="right: 0; bottom:0">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="subheader">Jumlah Partisipan Offline</div>
                  </div>
                  <div class="d-flex align-items-baseline">
                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsOfflineCount ?? "0" }}</div>
                  </div>
                  <div id="chart-new-clients" class="chart-sm"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-6">
              <div class="card position-relative overflow-hidden p-2">
                <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="390" style="right: 0; bottom:0">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="subheader">Jumlah Partisipan Online</div>
                  </div>
                  <div class="d-flex align-items-baseline">
                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsOnlineCount ?? "0" }}</div>
                  </div>
                  <div id="chart-new-clients" class="chart-sm"></div>
                </div>
              </div>
            </div>
            <div class="col-12">
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
              <div class="card">
                <div class="card-header">
                  <div class="ms-auto">
                    <form action="{{ route('admin.dashboard') }}" class="">
                      <div class="d-flex gap-1">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
                        <button type="submit" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-vcenter card-table table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Instansi</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        {{-- <th>Action</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($attendanceParticipants as $attendanceParticipant)
                        <tr>
                          <td>{{ ($attendanceParticipants->currentPage() - 1) * $attendanceParticipants->perPage() + $loop->iteration }}</td>
                          <td>{{ $attendanceParticipant->qrcode }}</td>
                          <td>{{ $attendanceParticipant->name }}</td>
                          <td>{{ $attendanceParticipant->instansi->name }}</td>
                          <td>{{ $attendanceParticipant->email }}</td>
                          <td>{{ $attendanceParticipant->phone_number }}</td>
                          {{-- <td>
                            @if($attendanceParticipant->verification == 1)
                              <span class="badge bg-primary text-white">Verified</span>
                            @else
                              <span class="badge bg-danger text-white">Not Verified</span>
                            @endif
                          </td> --}}
                          {{-- <td>
                            <button type="button" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $attendanceParticipant->id }}"><i class="fa-solid fa-pen"></i></button>
                            <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $attendanceParticipant->id }}"><i class="fa-solid fa-trash"></i></button>
                          </td> --}}
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                  <ul class="pagination m-0 ms-auto">
                    @if($attendanceParticipants->hasPages())
                      {{ $attendanceParticipants->appends(request()->query())->links('pagination::bootstrap-4') }}
                    @else
                      <li class="page-item">No more records</li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
</script>
@endsection