@extends('backend.templates.scan')
@section('title', 'Register')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center mb-4">
    <a href="" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('btn.png') }}" width="100" height="" alt="" class="">
    </a>
  </div>
  <div class="card card-md">
    <div class="card-body">
      <h2 class="h2 text-center mb-4">Register</h2>

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

      <form action="{{ route('post.register') }}" method="post">
        @csrf
        <div class="mb-3">
          <label class="form-label">ID</label>
          <input type="text" class="form-control" name="qrcode" placeholder="ID" value="{{ old('qrcode') }}">
          @error('qrcode')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label required">Name</label>
          <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required>
          @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label required">Instansi</label>
          <select class="selectpicker border rounded" data-live-search="true" name="instansi_id" style="width: 100% !important;" required>
            <option disabled selected value="">Pilih</option>
            @foreach($instansis as $instansi)
                <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>{{ $instansi->name }}</option>
            @endforeach
          </select>
          @error('instansi')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label required">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
          @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <input type="hidden" class="form-control" name="kehadiran" placeholder="" value="onsite">
        <input type="hidden" class="form-control" name="kendaraan" placeholder="" value="mobil">
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Hadir</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection