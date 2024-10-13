@extends('quiz.templates.pages')
@section('title', 'Login')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center mb-4">
    <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('btn.png') }}" width="100" height="" alt="" class="">
    </a>
  </div>
  <div class="card card-md">
    <div class="card-body">
      <h2 class="h2 text-center mb-4">Join</h2>
      <form action="{{ route('join.post') }}" method="post">
        @csrf
        <div class="mb-3">
          <label class="form-label required">Masukan</label>
          <input type="email" class="form-control" name="email" placeholder="Masukan Email terdaftar">
        </div>
        <div class="mb-3">
          <label class="form-label required">Pin</label>
          <input type="number" class="form-control" name="pin" placeholder="Masukan Pin untuk join quiz">
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Join</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  $(document).ready(function() {
    @if(session('success'))
      Swal.fire({
          icon: 'success',
          title: 'Success',
          text: "{{ session('success') }}",
          confirmButtonText: 'OK',
          showCancelButton: false,
          allowOutsideClick: false
      })
    @endif

    @if(session('error'))
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: "{{ session('error') }}",
          timer: 2000,
          showConfirmButton: false
      });
    @endif
  });
</script>
@endpush