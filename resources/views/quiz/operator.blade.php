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
            Mulai!!
        </div>
        <div>
            <div id="quiz-container" class="mb-3">
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        let quizIndex = 0;
        const quizzes = @json($quizzes);
        const quizContainer = document.getElementById('quiz-container');
        const startText = document.getElementById('start-text');

        document.addEventListener('keydown', handleKeyDown);

        if (quizzes.length > 0) {
            displayStartText();
        }

        function handleKeyDown(event) {
            if (event.key === 'ArrowRight') {
                changeQuizIndex();
            } else if (event.key === ' ') {
                startQuiz();

            }

        }

        function startQuiz() {
            startText.style.display = 'none';
            quizContainer.style.display = 'block';
            displayQuiz(quizIndex);
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
            quizIndex += 1;
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
