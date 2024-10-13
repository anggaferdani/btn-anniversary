@extends('quiz.templates.pages')
@section('title', 'Kuis')
@section('content')
<div class="container container-tight py-4">
    <div class="text-center">
        <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark">
            <img src="{{ asset('logobaru.png') }}" width="200" alt="" class="">
        </a>
    </div>
    <div class="p-5 justify-content-center">
        <h1 class="h1 text-center mb-4" style="color: white">Kuis</h1>
        <form action="" method="post">
            @csrf

            <!-- Pertanyaan 1 -->
            <div class="mb-4">
                <h3 style="color: white">Siapa pembuat lampu pertama?</h3>
            </div>
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                <label class="form-selectgroup-item flex-fill">
                    <input type="radio" name="form-payment" value="thomas_edison" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            Thomas Edison
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="radio" name="form-payment" value="nikola_tesla" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            Nikola Tesla
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="radio" name="form-payment" value="alexander_lodygin" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            Alexander Lodygin
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="radio" name="form-payment" value="joseph_swan" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            Joseph Swan
                        </div>
                    </div>
                </label>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn w-100 border-0" style="background-color: #FFCE20; height: 60px; font-size: 24px; font-weight: 800; color: white">NEXT</button>
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
            });
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
