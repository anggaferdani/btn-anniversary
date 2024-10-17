@extends('backend.templates.pages')
@section('title', 'History Tenant Visitor')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        History
      </h2>
    </div>
    <div class="col-auto">
      <div class="btn-list">
        {{-- <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Create</a> --}}
        <a href="{{ route('admin.history', array_merge(request()->query(), ['export' => 'excel'])) }}" class="btn btn-success">Export Excel</a>
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
              @if (auth()->user()->role == 1)
                <form action="{{ route('admin.history') }}" class="">
              @else
                <form action="{{ route('tenant.history') }}" class="">
              @endif
              <div class="d-flex gap-1">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
                <button type="submit" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
                @if (auth()->user()->role == 1)
                  <a href="{{ route('admin.history') }}" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
                @else
                  <a href="{{ route('tenant.history') }}" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
                @endif
              </div>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>QRCode</th>
                @if (auth()->user()->role == 1)
                  <th>Tenant</th>
                @endif
                <th>Participant</th>
                <th>Instansi</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Point Earned</th>
                <th>Points Left</th>
                <th>Created At</th>
                {{-- <th>Action</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($userParticipants as $userParticipant)
                <tr>
                  <td>{{ ($userParticipants->currentPage() - 1) * $userParticipants->perPage() + $loop->iteration }}</td>
                  <td>{{ $userParticipant->participant->qrcode }}</td>
                  @if (auth()->user()->role == 1)
                    <td>{{ $userParticipant->user->name }}</td>
                  @endif
                  <td>{{ $userParticipant->participant->name }}</td>
                  <td>{{ $userParticipant->participant->instansi->name }}</td>
                  <td>{{ $userParticipant->participant->email }}</td>
                  <td>{{ $userParticipant->participant->phone_number }}</td>
                  <td>1</td>
                  <td>{{ $userParticipant->total_points }}</td>
                  <td>{{ $userParticipant->created_at }}</td>
                  {{-- <td>
                    <button type="button" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $userParticipant->id }}"><i class="fa-solid fa-pen"></i></button>
                    <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $userParticipant->id }}"><i class="fa-solid fa-trash"></i></button>
                  </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer d-flex align-items-center">
          <ul class="pagination m-0 ms-auto">
            @if($userParticipants->hasPages())
              {{ $userParticipants->appends(request()->query())->links('pagination::bootstrap-4') }}
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

@foreach ($userParticipants as $userParticipant)
<div class="modal modal-blur fade" id="edit{{ $userParticipant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.attendance-participant.update', $userParticipant->id) }}" method="POST" class="">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $userParticipant->name }}" autocomplete="off">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $userParticipant->email }}" autocomplete="off">
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Phone Number</label>
            <input type="number" class="form-control" name="phone_number" placeholder="Phone Number" value="{{ $userParticipant->phone_number }}" autocomplete="off">
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

@foreach ($userParticipants as $userParticipant)
<div class="modal modal-blur fade" id="delete{{ $userParticipant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-danger"></div>
      <form action="{{ route('admin.attendance-participant.destroy', $userParticipant->id) }}" method="POST">
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