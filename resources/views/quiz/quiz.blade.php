@extends('quiz.templates.pages')
@section('title', 'Countdown')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center mb-4">
    <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('btn.png') }}" width="100" height="" alt="" class="">
    </a>
  </div>
  <div class="card card-md">
    <div class="card-body">
      <h2 class="h2 text-center mb-4" id="countdownTimer">7:00</h2>

      <form action="{{ route('quiz.post', ['token' => $token]) }}" method="post">
        @csrf
        
        <input type="hidden" name="waktu_pengerjaan" id="waktuPengerjaan" value="">
        
        @foreach($quizzes as $quiz)
          <div class="mb-3">
            <label class="form-label">{{ $loop->iteration }}. {{ $quiz->soal }}</label>
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_a }}" class="form-selectgroup-input">
                <div class="form-selectgroup-label d-flex align-items-center p-3">
                  <div class="me-3">
                    <span class="form-selectgroup-check"></span>
                  </div>
                  <div>{{ $quiz->jawaban_a }}</div>
                </div>
              </label>
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_b }}" class="form-selectgroup-input">
                <div class="form-selectgroup-label d-flex align-items-center p-3">
                  <div class="me-3">
                    <span class="form-selectgroup-check"></span>
                  </div>
                  <div>{{ $quiz->jawaban_b }}</div>
                </div>
              </label>
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_c }}" class="form-selectgroup-input">
                <div class="form-selectgroup-label d-flex align-items-center p-3">
                  <div class="me-3">
                    <span class="form-selectgroup-check"></span>
                  </div>
                  <div>{{ $quiz->jawaban_c }}</div>
                </div>
              </label>
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_d }}" class="form-selectgroup-input">
                <div class="form-selectgroup-label d-flex align-items-center p-3">
                  <div class="me-3">
                    <span class="form-selectgroup-check"></span>
                  </div>
                  <div>{{ $quiz->jawaban_d }}</div>
                </div>
              </label>
            </div>
          </div>
        @endforeach

        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  let timeLeft = 420;
  let countdownElement = document.getElementById('countdownTimer');

  const updateCountdown = () => {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    seconds = seconds < 10 ? '0' + seconds : seconds;

    countdownElement.innerHTML = `${minutes}:${seconds}`;
    
    timeLeft--;

    if (timeLeft < 0) {
        clearInterval(countdownInterval);
        Swal.fire({
            icon: 'success',
            title: 'Waktu pengerjaan habis',
            confirmButtonText: 'OK',
            showCancelButton: false,
            allowOutsideClick: false
        })
        document.getElementById('waktuPengerjaan').value = 0;
        document.querySelector('form').submit();
    } else {
        document.getElementById('waktuPengerjaan').value = timeLeft;
    }
};

  let countdownInterval = setInterval(updateCountdown, 1000);
</script>
@endpush