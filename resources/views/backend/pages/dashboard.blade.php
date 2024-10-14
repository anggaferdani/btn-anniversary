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
                      <div class="col-sm-6 col-lg-4">
                        <div class="card position-relative overflow-hidden p-2">
                            <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0; opacity: 15%;">
                            <img src="{{ asset('assets/backend/dashboard/edit.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader" style="font-size: 11px">Jumlah Registrasi</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsCount ?? "0" }}</div>
                                </div>
                            </div>
                        </div>
                      </div>

                    <div class="col-sm-6 col-lg-4">
                      <div class="card position-relative overflow-hidden p-2">
                          <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0; opacity: 15%;">
                          <img src="{{ asset('assets/backend/dashboard/edit.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                          <div class="card-body">
                              <div class="d-flex align-items-center mb-3">
                                  <div class="subheader" style="font-size: 11px">Jumlah Registrasi Offline</div>
                              </div>
                              <div class="d-flex align-items-baseline">
                                  <div class="h1 me-2" style="font-size: 40px">{{ $participantsCountOfflineRegister ?? "0" }}</div>
                              </div>
                          </div>
                      </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                      <div class="card position-relative overflow-hidden p-2">
                          <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0; opacity: 15%;">
                          <img src="{{ asset('assets/backend/dashboard/edit.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                          <div class="card-body">
                              <div class="d-flex align-items-center mb-3">
                                  <div class="subheader" style="font-size: 11px">Jumlah Registrasi Online</div>
                              </div>
                              <div class="d-flex align-items-baseline">
                                  <div class="h1 me-2" style="font-size: 40px">{{ $participantsCountOnlineRegister ?? "0" }}</div>
                              </div>
                          </div>
                      </div>
                    </div>
                
                    <!-- Partisipan Terverifikasi -->
                    <div class="col-sm-6 col-lg-6">
                        <div class="card position-relative overflow-hidden p-2">
                            <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0; opacity: 15%;">
                            <img src="{{ asset('assets/backend/dashboard/verify.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">Partisipan Terverifikasi</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsVerifiedCount ?? "0" }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Partisipan Belum Terverifikasi -->
                    <div class="col-sm-6 col-lg-6">
                        <div class="card position-relative overflow-hidden p-2">
                            <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0; opacity: 15%;">
                            <img src="{{ asset('assets/backend/dashboard/document.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">Partisipan Belum Terverifikasi</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsUnverifiedCount ?? "0" }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Partisipan HADIR (Offline) -->
                    <div class="col-sm-6 col-lg-6">
                        <div class="card position-relative overflow-hidden p-2">
                            <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0; opacity: 15%;">
                            <img src="{{ asset('assets/backend/dashboard/attendance.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">HADIR (Offline)</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsVerifiedOfflineCountHadir ?? "0" }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Partisipan BELUM HADIR (Offline) -->
                    <div class="col-sm-6 col-lg-6">
                        <div class="card position-relative overflow-hidden p-2">
                            <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="200" style="right: 0; bottom:0; opacity: 15%;">
                            <img src="{{ asset('assets/backend/dashboard/absence.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">BELUM HADIR (Offline)</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsVerifiedOfflineCountNotHadir ?? "0" }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Jumlah Partisipan Offline -->
                    <div class="col-sm-6 col-lg-6">
                        <div class="card position-relative overflow-hidden p-2">
                            <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="420" style="right: 0; bottom:0; opacity: 15%;">
                            <img src="{{ asset('assets/backend/dashboard/job.png') }}" alt="" class="position-absolute" width="60" style="right: 10%; bottom:25%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">Jumlah Partisipan Offline</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsOfflineCount ?? "0" }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Jumlah Partisipan Online -->
                    <div class="col-sm-6 col-lg-6">
                        <div class="card position-relative overflow-hidden p-2">
                            <img src="{{ asset('AKSEN.png') }}" alt="" class="position-absolute" width="390" style="right: 0; bottom:0; opacity: 15%;">
                            <img src="{{ asset('assets/backend/dashboard/zoom.png') }}" alt="" class="position-absolute" width="120" style="right: 10%; bottom:10%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">Jumlah Partisipan Online</div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 me-2" style="font-size: 40px">{{ $participantsOnlineCount ?? "0" }}</div>
                                </div>
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
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.exportExcel') }}" class="py-1 px-5 btn btn-icon btn-success">Export</a>
                                            <input type="text" class="form-control" name="search"
                                                value="{{ request('search') }}" placeholder="Search Nama Instansi">
                                            <button type="submit" class="btn btn-icon btn-dark-outline"><i
                                                    class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="btn btn-icon btn-dark-outline"><i
                                                    class="fa-solid fa-times"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Instansi</th>
                                            <th>Registrasi</th>
                                            <th>Registrasi Offline</th>
                                            <th>Registrasi Online</th>
                                            <th>Terverifikasi</th>
                                            <th>Belum Terverifikasi</th>
                                            <th>Partisipan Online</th>
                                            <th>Partisipan Offline</th>
                                            <th>Partisipan Hadir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($instansis as $instansi) --}}
                                        {{-- <tr>
                          <td>{{ ($instansis->currentPage() - 1) * $instansis->perPage() + $loop->iteration }}</td>
                                        <td>{{ $instansi->name }}</td>
                                        <td>{{ $instansi->participants->name }}</td> --}}
                                        {{-- <td>
                            @if($attendanceParticipant->verification == 1)
                              <span class="badge bg-primary text-white">Verified</span>
                            @else
                              <span class="badge bg-danger text-white">Not Verified</span>
                            @endif
                          </td> --}}
                                        {{-- <td>
                            <button type="button" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $attendanceParticipant->id }}"><i
                                            class="fa-solid fa-pen"></i></button>
                                        <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $attendanceParticipant->id }}"><i
                                                class="fa-solid fa-trash"></i></button>
                                        </td> --}}
                                        {{-- </tr>
                      @endforeach --}}
                                        @foreach ($instansis as $instansi)
                                        <tr>
                                            <td>{{ ($instansis->currentPage() - 1) * $instansis->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $instansi->name }}</td>

                                            <!-- Menampilkan jumlah peserta terkait instansi -->
                                            <td>{{ $instansi->participants->where('status', 1)->count() }}</td>
                                            <td>{{ $instansi->participants->where('kehadiran', 'onsite')->where('status', 1)->count() }}</td>
                                            <td>{{ $instansi->participants->where('kehadiran', 'online')->where('status', 1)->count() }}</td>
                                            <td>{{ $instansi->participants->where('verification', 1)->where('status', 1)->count() }}
                                            </td>
                                            <td>{{ $instansi->participants->where('verification', 2)->where('status', 1)->count() }}
                                            </td>
                                            <td>{{ $instansi->participants->where('verification', 1)->where('kehadiran', 'online')->where('status', 1)->count() }}
                                            </td>
                                            <td>{{ $instansi->participants->where('verification', 1)->where('kehadiran', 'onsite')->where('status', 1)->count() }}
                                            </td>
                                            <td>{{ $instansi->participants->where('verification', 1)->where('kehadiran', 'onsite')->where('attendance', 1)->where('status', 1)->count() }}
                                            </td>

                                            {{-- <td>
                                  @if($attendanceParticipant->verification == 1)
                                      <span class="badge bg-primary text-white">Verified</span>
                                  @else
                                      <span class="badge bg-danger text-white">Not Verified</span>
                                  @endif
                              </td> --}}
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex align-items-center">
                                <ul class="pagination m-0 ms-auto">
                                    @if($instansis->hasPages())
                                    {{ $instansis->appends(request()->query())->links('pagination::bootstrap-4') }}
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
    $(document).ready(function () {
        $('.datatable').DataTable();
    });

</script>
@endsection
