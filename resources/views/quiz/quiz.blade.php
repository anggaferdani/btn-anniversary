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
      <h2 class="h2 text-center mb-4" id="countdownTimer">{{ gmdate('i:s', $setting->max_waktu_pengerjaan) }}</h2>

      @if($existsInScores)
      <div class="alert alert-important alert-danger" role="alert">Sudah mengisi kuis ini sebelumnya</div>
      @endif

      <form action="{{ route('quiz.post', ['token' => $token]) }}" method="post">
        @csrf

        <input type="hidden" name="waktu_pengerjaan" id="waktuPengerjaan" value="">

          {{--        @foreach($quizzes as $quiz)--}}
          {{--          <div class="mb-3">--}}
          {{--            <label class="form-label">{{ $loop->iteration }}. {{ $quiz->soal }}</label>--}}
          {{--            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">--}}
          {{--              <label class="form-selectgroup-item flex-fill">--}}
          {{--                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_a }}" class="form-selectgroup-input">--}}
          {{--                <div class="form-selectgroup-label d-flex align-items-center p-3">--}}
          {{--                  <div class="me-3">--}}
          {{--                    <span class="form-selectgroup-check"></span>--}}
          {{--                  </div>--}}
          {{--                  <div>{{ $quiz->jawaban_a }}</div>--}}
          {{--                </div>--}}
          {{--              </label>--}}
          {{--              <label class="form-selectgroup-item flex-fill">--}}
          {{--                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_b }}" class="form-selectgroup-input">--}}
          {{--                <div class="form-selectgroup-label d-flex align-items-center p-3">--}}
          {{--                  <div class="me-3">--}}
          {{--                    <span class="form-selectgroup-check"></span>--}}
          {{--                  </div>--}}
          {{--                  <div>{{ $quiz->jawaban_b }}</div>--}}
          {{--                </div>--}}
          {{--              </label>--}}
          {{--              <label class="form-selectgroup-item flex-fill">--}}
          {{--                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_c }}" class="form-selectgroup-input">--}}
          {{--                <div class="form-selectgroup-label d-flex align-items-center p-3">--}}
          {{--                  <div class="me-3">--}}
          {{--                    <span class="form-selectgroup-check"></span>--}}
          {{--                  </div>--}}
          {{--                  <div>{{ $quiz->jawaban_c }}</div>--}}
          {{--                </div>--}}
          {{--              </label>--}}
          {{--              <label class="form-selectgroup-item flex-fill">--}}
          {{--                <input type="radio" name="jawaban[{{ $quiz->id }}]" value="{{ $quiz->jawaban_d }}" class="form-selectgroup-input">--}}
          {{--                <div class="form-selectgroup-label d-flex align-items-center p-3">--}}
          {{--                  <div class="me-3">--}}
          {{--                    <span class="form-selectgroup-check"></span>--}}
          {{--                  </div>--}}
          {{--                  <div>{{ $quiz->jawaban_d }}</div>--}}
          {{--                </div>--}}
          {{--              </label>--}}
          {{--            </div>--}}
          {{--          </div>--}}

          <div id="quiz-container" class="mb-3">
          </div>


        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100" @if($existsInScores) disabled @endif>Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
  $(document).ready(function() {
      const quizzes = @json($quizzes);
      const quizContainer = document.getElementById('quiz-container');
      const pusherKey = "{{ env('PUSHER_APP_KEY') }}";
      const pusherCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
      let quizIndex = 0;

      function displayQuiz(index) {
          if (index < quizzes.length) {
              const quiz = quizzes[index];
              let answersHtml = '';
              ['a', 'b', 'c', 'd'].forEach(option => {
                  const answer = quiz[`jawaban_${option}`];
                  if (answer) {
                      answersHtml += `
                    <label class="form-selectgroup-item flex-fill">
                        <input type="radio" name="jawaban[${quiz.id}]" value="${answer}" class="form-selectgroup-input">
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div>${answer}</div>
                        </div>
                    </label>
                `;
                  }
              });

              quizContainer.innerHTML = `
            <label class="form-label fs-2">${quiz.id}. ${quiz.soal}</label>
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                ${answersHtml}
            </div>
        `;
          } else {
              quizContainer.innerHTML = `<label class="form-label fs-2">No more quizzes available.</label>`;
          }
      }

      function initializePusher() {
          const pusher = new Pusher(pusherKey, {
              cluster: pusherCluster,
              encrypted: true,
          });

          const changeQuiz = pusher.subscribe('quiz-index');
          changeQuiz.bind('quiz-index', function (data) {
              quizIndex = data.quizIndex;
              displayQuiz(quizIndex);
          });
      }

      function showAlert(type, title, text, timer = null) {
          Swal.fire({
              icon: type,
              title: title,
              text: text,
              timer: timer,
              confirmButtonText: 'OK',
              showCancelButton: false,
              allowOutsideClick: false,
              showConfirmButton: !timer
          });
      }

      function checkSessionMessages() {
          @if(session('success'))
          showAlert('success', 'Success', "{{ session('success') }}");
          @endif

          @if(session('error'))
          showAlert('error', 'Error', "{{ session('error') }}", 2000);
          @endif
      }

      if (quizzes.length > 0) {
          displayQuiz(quizIndex);
      }

      initializePusher();
      checkSessionMessages();
  });
</script>
@endpush
