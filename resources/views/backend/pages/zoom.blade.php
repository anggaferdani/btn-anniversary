@extends('backend.templates.pages')
@section('title', 'Zoom')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        Zoom
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
            <form action="" class="">
              <div class="d-flex gap-1">
                <input disabled type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
                <button type="submit" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
                <a href="" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
              </div>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Link</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($zooms as $zoom)
                <tr>
                  <td>1</td>
                  <td>BTN Anniversary Learning Festival</td>
                  <td>{{ $zoom->link ?? '-' }}</td>
                  <td>
                    <button type="button" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $zoom->id }}"><i class="fa-solid fa-pen"></i></button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer d-flex align-items-center">
          <ul class="pagination m-0 ms-auto">
            <li class="page-item">No more records</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

@foreach ($zooms as $zoom)
<div class="modal modal-blur fade" id="edit{{ $zoom->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.zoom.update', $zoom->id) }}" method="POST" class="">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Link</label>
            <input type="text" class="form-control" name="link" placeholder="Link" value="{{ $zoom->link }}" autocomplete="off">
            @error('link')<div class="text-danger">{{ $message }}</div>@enderror
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
@endsection