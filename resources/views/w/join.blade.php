@extends('quiz.templates.pages')
@section('title', 'Join Quiz')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center">
    <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('logobaru.png') }}" width="250" height="" alt="" class="">
    </a>
  </div>
  <div class="p-5 justify-content-center">
    <h1 class="h1 text-center mb-4" style="color: white">Join Quiz</h1>
    <form action="{{ route('join.post') }}" method="post">
      @csrf
      <div class="mb-3 text-center">
        <label class="form-label required" style="color:white">Email</label>
        <input type="email" class="form-control text-center border-2 p-3 border-light" style="color: white; background-color: #02263F;" name="email" placeholder="Masukan Email terdaftar">
      </div>
      <div class="mb-3 text-center">
        <label class="form-label required" style="color:white">Pin</label>
        <input type="number" class="form-control text-center border-2 p-3 border-light" style="color: white; background-color: #02263F;" name="pin" placeholder="Masukan Pin untuk join Quiz">
      </div>
      <div class="form-footer">
        <button type="submit" class="btn w-100 border-0" style="background-color: #FFCE20; height: 60px; font-size: 24px; font-weight: 800; color: white">JOIN</button>
      </div>
    </form>
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