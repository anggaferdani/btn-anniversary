@extends('quiz.templates.pages')
@section('title', 'Countdown')
@section('content')
    <div class="container py-4">
        {{--        <div class="text-center mb-4">--}}
        {{--            <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark">--}}
        {{--                <img src="{{ asset('btn.png') }}" width="100" height="" alt="" class="">--}}
        {{--            </a>--}}
        {{--        </div>--}}
        {{--        --}}
        <div id="start-text" class="text-center mb-3" style="font-size: 60px;">
            Menunggu Peserta
        </div>
        <div>
            <div id="quiz-container" class="mb-3">
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        let quizIndex = -1;
        const quizzes = @json($quizzes);
        const quizContainer = document.getElementById('quiz-container');
        const startText = document.getElementById('start-text');

        document.addEventListener('keydown', handleKeyDown);

        if (quizzes.length > 0) {
            displayStartText();
        }

        function handleKeyDown(event) {
            if (event.key === 'ArrowRight') {
                if (quizIndex == -1) {
                    quizIndex = 0;
                } else {
                    quizIndex += 1;
                }

                changeQuizIndex();
            } else if (event.key === ' ') {
                if (quizIndex == -1) {
                    quizIndex = 0;
                } else {
                    quizIndex += 1;
                }

                startQuiz();
                changeQuizIndex();
            } else if (event.key === 'ArrowLeft') {
                if (!(quizIndex < 0)) {
                    quizIndex -= 1;
                }
                changeQuizIndex();


            }

        }

        function startQuiz() {
            startText.style.display = 'none';
            quizContainer.style.display = 'block';

            // changeQuizIndex();

        }

        function changeQuizIndex() {

            $.ajax({
                url: '{{ route('admin.quiz.changeIndex') }}',
                method: 'POST',
                data: {
                    quizIndex: quizIndex,
                    _token: "{{ csrf_token() }}",
                },
                success: updateQuizIndex,
                error: handleError
            });
        }

        function updateQuizIndex(data) {


            if (quizIndex < quizzes.length) {
                displayQuiz(quizIndex);
            } else {
                displayNoMoreQuizzes();
            }
        }

        function handleError(xhr, status, error) {
            console.error(error);
        }

        function displayQuiz(index) {
            quizContainer.innerHTML = `
            <label style="font-size: 60px" class="form-label text-center">
                ${quizzes[index].id}. ${quizzes[index].soal}
            </label>`;
        }

        function displayNoMoreQuizzes() {
            quizContainer.innerHTML = `
            <label style="font-size: 60px" class="form-label text-center">
                No more quizzes available.
            </label>`;
        }

        function displayStartText() {
            startText.style.display = 'block';
            quizContainer.style.display = 'none';
        }
    </script>
@endpush
