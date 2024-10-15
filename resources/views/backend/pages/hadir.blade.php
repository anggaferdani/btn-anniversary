@extends('backend.templates.scan')
@section('title', 'Participant')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center mb-4">
    <a href="" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('btn.png') }}" width="100" height="" alt="" class="">
    </a>
  </div>
  <div class="card card-md">
    <div class="card-body">
      <h2 class="h2 text-center mb-4">Participant</h2>

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

      <form action="{{ route('post.hadir') }}" method="post">
        @csrf
        <div class="mb-3">
          <label class="form-label">ID</label>
          <input type="text" class="form-control" name="qrcode" placeholder="ID" value="{{ old('qrcode') }}">
          @error('qrcode')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label required">Nama</label>
          <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{ old('nama') }}">
          @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label required">Instansi</label>
          <select class="selectpicker border rounded" data-live-search="true" name="instansi_id" style="width: 100% !important;">
            <option disabled selected value="">Pilih</option>
            @foreach($instansis as $instansi)
                <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>{{ $instansi->name }}</option>
            @endforeach
          </select>
          @error('instansi_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Hadir</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection