@extends('backend.templates.pages')
@section('title', 'Attendance Participant')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        Attendance Participant
      </h2>
    </div>
    <div class="col-auto">
      <div class="btn-list">
        <a href="{{ route('admin.attendance-participant.index', array_merge(request()->query(), ['export' => 'excel'])) }}" class="btn btn-success">Export Excel</a>
      </div>
    </div>
  </div>
</div>
@endsection
@section('content')
<div class="container-xl">
  <div class="row">
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
            <form action="{{ route('admin.attendance-participant.index') }}" class="">
              <div class="d-flex gap-1">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
                <button type="submit" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
                <a href="{{ route('admin.attendance-participant.index') }}" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
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
                <th>Email</th>
                <th>Phone Number</th>
                <th>Point</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($attendanceParticipants as $attendanceParticipant)
                <tr>
                  <td>{{ ($attendanceParticipants->currentPage() - 1) * $attendanceParticipants->perPage() + $loop->iteration }}</td>
                  <td>{{ $attendanceParticipant->qrcode }}</td>
                  <td>{{ $attendanceParticipant->name }}</td>
                  <td>{{ $attendanceParticipant->email }}</td>
                  <td>{{ $attendanceParticipant->phone_number }}</td>
                  <td>{{ $attendanceParticipant->point }}</td>
                  <td>
                    @if($attendanceParticipant->verification == 1)
                      <span class="badge bg-primary text-white">Verified</span>
                    @else
                      <span class="badge bg-danger text-white">Not Verified</span>
                    @endif
                  </td>
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

{{-- <div class="modal modal-blur fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.attendance-participant.store') }}" method="POST" class="">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Create</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" autocomplete="off">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
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
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Cancel
          </a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach ($attendanceParticipants as $attendanceParticipant)
<div class="modal modal-blur fade" id="edit{{ $attendanceParticipant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.attendance-participant.update', $attendanceParticipant->id) }}" method="POST" class="">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $attendanceParticipant->name }}" autocomplete="off">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $attendanceParticipant->email }}" autocomplete="off">
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Phone Number</label>
            <input type="number" class="form-control" name="phone_number" placeholder="Phone Number" value="{{ $attendanceParticipant->phone_number }}" autocomplete="off">
            @error('phone_number')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Cancel
          </a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@foreach ($attendanceParticipants as $attendanceParticipant)
<div class="modal modal-blur fade" id="delete{{ $attendanceParticipant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-danger"></div>
      <form action="{{ route('admin.attendance-participant.destroy', $attendanceParticipant->id) }}" method="POST">
        @csrf
        @method('Delete')
        <div class="modal-body text-center py-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
          <h3>Are you sure?</h3>
          <div class="text-secondary">Are you sure you want to delete this? This action cannot be undone.</div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
              <div class="col"><button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">Delete</button></div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach --}}
@endsection