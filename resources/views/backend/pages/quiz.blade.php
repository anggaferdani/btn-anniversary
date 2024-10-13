@extends('backend.templates.pages')
@section('title', 'Quiz')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        Quiz
      </h2>
    </div>
    <div class="col-auto">
      <div class="btn-list">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Create</a>
      </div>
    </div>
  </div>
</div>
@endsection
@section('content')
<div class="container-xl">
  <div class="row">
    <div class="col-12">
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
      <div class="card">
        <div class="card-header">
          <div class="ms-auto">
            <form action="{{ route('admin.quiz.index') }}" class="">
              <div class="d-flex gap-1">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
                <button type="submit" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
                <a href="{{ route('admin.quiz.index') }}" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
              </div>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>Soal</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($quizzes as $quiz)
                <tr>
                  <td>{{ ($quizzes->currentPage() - 1) * $quizzes->perPage() + $loop->iteration }}</td>
                  <td>{{ $quiz->soal }}</td>
                  <td>
                    <button type="button" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $quiz->id }}"><i class="fa-solid fa-pen"></i></button>
                    <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $quiz->id }}"><i class="fa-solid fa-trash"></i></button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer d-flex align-items-center">
          <ul class="pagination m-0 ms-auto">
            @if($quizzes->hasPages())
              {{ $quizzes->appends(request()->query())->links('pagination::bootstrap-4') }}
            @else
              <li class="page-item">No more records</li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.quiz.store') }}" method="POST" class="">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Create</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Soal</label>
            <input type="text" class="form-control" name="soal" placeholder="Soal" autocomplete="off">
            @error('soal')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban A</label>
                <input type="text" class="form-control" name="jawaban_a" placeholder="Jawaban A" autocomplete="off">
                @error('jawaban_a')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban B</label>
                <input type="text" class="form-control" name="jawaban_b" placeholder="Jawaban B" autocomplete="off">
                @error('jawaban_b')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban C</label>
                <input type="text" class="form-control" name="jawaban_c" placeholder="Jawaban C" autocomplete="off">
                @error('jawaban_c')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban D</label>
                <input type="text" class="form-control" name="jawaban_d" placeholder="Jawaban D" autocomplete="off">
                @error('jawaban_d')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Jawaban</label>
            <select class="form-select required" name="jawaban">
              <option disabled selected value="">Pilih</option>
              <option value="a">A</option>
              <option value="b">B</option>
              <option value="c">C</option>
              <option value="d">D</option>
            </select>
            @error('jawaban')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Cancel
          </a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach ($quizzes as $quiz)
<div class="modal modal-blur fade" id="edit{{ $quiz->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.quiz.update', $quiz->id) }}" method="POST" class="">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Soal</label>
            <input type="text" class="form-control" name="soal" placeholder="Soal" autocomplete="off" value="{{ $quiz->soal }}">
            @error('soal')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban A</label>
                <input type="text" class="form-control" name="jawaban_a" placeholder="Jawaban A" autocomplete="off" value="{{ $quiz->jawaban_a }}">
                @error('jawaban_a')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban B</label>
                <input type="text" class="form-control" name="jawaban_b" placeholder="Jawaban B" autocomplete="off" value="{{ $quiz->jawaban_b }}">
                @error('jawaban_b')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban C</label>
                <input type="text" class="form-control" name="jawaban_c" placeholder="Jawaban C" autocomplete="off" value="{{ $quiz->jawaban_c }}">
                @error('jawaban_c')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label required">Jawaban D</label>
                <input type="text" class="form-control" name="jawaban_d" placeholder="Jawaban D" autocomplete="off" value="{{ $quiz->jawaban_d }}">
                @error('jawaban_d')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Jawaban</label>
            <select class="form-select" name="jawaban">
              <option disabled selected value="">Pilih</option>
              <option value="a" @if($quiz->jawaban == 'a') @selected(true) @endif>A</option>
              <option value="b" @if($quiz->jawaban == 'b') @selected(true) @endif>B</option>
              <option value="c" @if($quiz->jawaban == 'c') @selected(true) @endif>C</option>
              <option value="d" @if($quiz->jawaban == 'd') @selected(true) @endif>D</option>
            </select>
            @error('jawaban')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Cancel
          </a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@foreach ($quizzes as $quiz)
<div class="modal modal-blur fade" id="delete{{ $quiz->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-danger"></div>
      <form action="{{ route('admin.quiz.destroy', $quiz->id) }}" method="POST">
        @csrf
        @method('Delete')
        <div class="modal-body text-center py-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
          <h3>Are you sure?</h3>
          <div class="text-secondary">Are you sure you want to delete this? This action cannot be undone.</div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
              <div class="col"><button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">Delete</button></div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection