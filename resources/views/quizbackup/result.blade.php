@extends('quiz.templates.pages')
@section('title', 'Result')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center mb-4">
    <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('btn.png') }}" width="100" height="" alt="" class="">
    </a>
  </div>
  <div class="card card-md">
    <div class="card-body">
      <h2 class="h2 text-center text-danger mb-4">{{ $score->score }}</h2>
      <div>ID : {{ $participant->qrcode }}</div>
      <div>Nama : {{ $participant->name }}</div>
      <div>Email : {{ $participant->email }}</div>
      <div>Waktu Pengerjaan : {{ gmdate('i:s', $score->waktu_pengerjaan) }}</div>
    </div>
  </div>
</div>
@endsection