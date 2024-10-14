@extends('backend.templates.pages')
@section('title', 'Participant')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        Participant
      </h2>
    </div>
    <div class="col-auto">
      <div class="btn-list">
        @if(auth()->user()->role == 1)
          <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Create</a>
        @endif
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
            @if(auth()->user()->role == 1)
              <form action="{{ route('admin.participant.index') }}" class="">
            @elseif(auth()->user()->role == 2)
              <form action="{{ route('receptionist.participant.index') }}" class="">
            @endif
              <div class="d-flex gap-1">
                <select class="form-select" name="instansi">
                  <option disabled selected value="">Instansi</option>
                  <option value="">Semua</option>
                  @foreach($instansis as $instansi)
                      <option value="{{ $instansi->id }}" {{ request('instansi') == $instansi->id ? 'selected' : '' }}>
                          {{ $instansi->name }}
                      </option>
                  @endforeach
                </select>
                <select class="form-select" name="kehadiran">
                    <option disabled selected value="">Kehadiran</option>
                    <option value="onsite" {{ request('kehadiran') == 'onsite' ? 'selected' : '' }}>Offline</option>
                    <option value="online" {{ request('kehadiran') == 'online' ? 'selected' : '' }}>Online</option>
                </select>
                <select class="form-select" name="status">
                    <option disabled selected value="">Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Verified</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Not Verified</option>
                </select>
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
                <button type="submit" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
                @if(auth()->user()->role == 1)
                  <a href="{{ route('admin.participant.index') }}" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
                @elseif(auth()->user()->role == 2)
                  <a href="{{ route('receptionist.participant.index') }}" class="btn btn-icon btn-dark-outline"><i class="fa-solid fa-times"></i></a>
                @endif
              </div>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>QRCode</th>
                <th>Token</th>
                <th>Name</th>
                <th>Instansi</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Kehadiran</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($participants as $participant)
                <tr>
                  <td>{{ ($participants->currentPage() - 1) * $participants->perPage() + $loop->iteration }}</td>
                  <td>{{ $participant->qrcode }}</td>
                  <td>{{ $participant->token }}</td>
                  <td>{{ $participant->name }}</td>
                  <td>{{ $participant->instansi->name }}</td>
                  <td>{{ $participant->email }}</td>
                  <td>{{ $participant->phone_number }}</td>
                  <td>
                    @if($participant->kehadiran == 'onsite')
                      <span class="badge bg-success text-white">Offline</span>
                    @else
                      <span class="badge bg-primary text-white">Online</span>
                    @endif
                  </td>
                  <td>
                    @if($participant->verification == 1)
                      <span class="badge bg-primary text-white">Verified</span>
                    @else
                      <span class="badge bg-danger text-white">Not Verified</span>
                    @endif
                  </td>
                  <td>
                    <div class="d-flex gap-1">
                      @if(auth()->user()->role == 1)
                        @if($participant->verification == 2)
                          <a href="{{ route('admin.resend-email-verification', $participant->token) }}" class="btn btn-primary"><i class="fa-solid fa-share me-1"></i> <span class="small">Email Verification</span></a>
                        @else
                          <a href="{{ route('admin.download.id', $participant->token) }}" class="btn btn-primary"><i class="fa-solid fa-download me-1"></i> <span class="small">Download ID</span></a>
                          <a href="{{ route('admin.download.qr', $participant->token) }}" class="btn btn-primary"><i class="fa-solid fa-download me-1"></i> <span class="small">Download QR</span></a>
                        @endif
                        {{-- <form action="{{ route('registration.sendImage', $participant->token) }}" method="POST" class="" enctype="multipart/form-data">
                          @csrf
                          <button type="submit" class="btn btn-success"><i class="fa-solid fa-share me-1"></i> <span class="small">Email Invitation</span></button>
                        </form> --}}
                        <button type="button" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $participant->id }}"><i class="fa-solid fa-pen"></i></button>
                        {{-- <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $participant->id }}"><i class="fa-solid fa-trash"></i></button> --}}
                      @elseif(auth()->user()->role == 2)
                        @if($participant->verification == 2)
                          <a href="{{ route('receptionist.resend-email-verification', $participant->token) }}" class="btn btn-primary"><i class="fa-solid fa-share me-1"></i> <span class="small">Email Verification</span></a>
                        @endif
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer d-flex align-items-center">
          <ul class="pagination m-0 ms-auto">
            @if($participants->hasPages())
              {{ $participants->appends(request()->query())->links('pagination::bootstrap-4') }}
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
      <form action="{{ route('admin.participant.store') }}" method="POST" class="">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Create</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" autocomplete="off">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Instansi</label>
            <select id="instansiSelect" class="selectpicker border rounded" data-live-search="true" name="instansi_id" style="width: 100% !important;">
              <option disabled selected value="">Pilih</option>
              @foreach($instansis as $instansi)
                  @php
                    $currentCount = $instansi->participants->where('verification', 1)->where('kehadiran', 'onsite')->count();
                    $maxCount = $instansi->max_participant;
                    $isOnline = $instansi->status_kehadiran == 'online';
                  @endphp
                  <option value="{{ $instansi->id }}" data-status-kehadiran="{{ $instansi->status_kehadiran }}" 
                      @if(!$isOnline && $currentCount >= $maxCount) 
                          disabled 
                      @endif
                  >
                      {{ $instansi->name }} 
                      @if($isOnline)
                          (Online)
                      @else
                          ({{ $currentCount }}/{{ $maxCount }})
                      @endif
                  </option>
              @endforeach
            </select>
            @error('instansi_id')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" autocomplete="off">
            @error('jabatan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off">
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Phone Number</label>
            <input type="number" class="form-control" name="phone_number" placeholder="Phone Number" autocomplete="off">
            @error('phone_number')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <input type="hidden" class="form-control" id="kehadiranInput" name="kehadiran" placeholder="" value="" autocomplete="off">
          <div id="kendaraanDiv" style="display:none;" class="mb-3">
            <label class="form-label">Apakah membawa kendaraan pribadi?</label>
            <select class="form-select" name="kendaraan">
              <option disabled selected value="">Pilih</option>
              <option value="mobil">Mobil</option>
              <option value="motor">Motor</option>
            </select>
            @error('kendaraan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div id="kendaraanDiv" style="display:none;" class="mb-3">
            <label class="form-label">Apakah membawa kendaraan pribadi?</label>
            <select class="form-select" name="kendaraan">
              <option disabled selected value="">Pilih</option>
              <option value="mobil">Mobil</option>
              <option value="motor">Motor</option>
            </select>
            @error('kendaraan')<div class="text-danger">{{ $message }}</div>@enderror
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

@foreach ($participants as $participant)
<div class="modal modal-blur fade" id="edit{{ $participant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.participant.update', $participant->id) }}" method="POST" class="">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $participant->name }}" autocomplete="off">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Instansi</label>
            <select id="instansiSelect{{ $participant->id }}" class="selectpicker border rounded" data-live-search="true" name="instansi_id" style="width: 100% !important;">
              <option disabled selected value="">Pilih</option>
              @foreach($instansis as $instansi)
                @php
                    $currentCount = $instansi->participants->where('verification', 1)->where('kehadiran', 'onsite')->count();
                    $maxCount = $instansi->max_participant;
                    $isParticipant = $participant->instansi_id == $instansi->id;
                @endphp
                <option value="{{ $instansi->id }}" data-status-kehadiran="{{ $instansi->status_kehadiran }}"  
                    @if($currentCount >= $maxCount && !$isParticipant) 
                        disabled 
                    @endif
                    @if($isParticipant) 
                        selected 
                    @endif
                >
                    {{ $instansi->name }} 
                    ({{ $currentCount }}/{{ $maxCount }})
                </option>
            @endforeach
            </select>
            @error('instansi_id')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="{{ $participant->jabatan }}" autocomplete="off">
            @error('jabatan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $participant->email }}" autocomplete="off">
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label required">Phone Number</label>
            <input type="number" class="form-control" name="phone_number" placeholder="Phone Number" value="{{ $participant->phone_number }}" autocomplete="off">
            @error('phone_number')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <input type="hidden" class="form-control" id="kehadiranInput{{ $participant->id }}" name="kehadiran" placeholder="" value="" autocomplete="off">
          <div class="mb-3" id="kendaraanDiv{{ $participant->id }}" style="display:none;">
            <label class="form-label" id="label-kendaraan{{ $participant->id }}">Apakah membawa kendaraan pribadi?</label>
            <select class="form-select" name="kendaraan" id="kendaraan{{ $participant->id }}">
                <option disabled selected value="">Pilih</option>
                <option value="mobil" @if($participant->kendaraan == 'mobil') @selected(true) @endif>Mobil</option>
                <option value="motor" @if($participant->kendaraan == 'motor') @selected(true) @endif>Motor</option>
            </select>
            @error('kendaraan')<div class="text-danger">{{ $message }}</div>@enderror
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

@foreach ($participants as $participant)
<div class="modal modal-blur fade" id="delete{{ $participant->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-danger"></div>
      <form action="{{ route('admin.participant.destroy', $participant->id) }}" method="POST">
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
@push('scripts')
<script>
    $(document).ready(function() {
      function handleInstansiChange(participantId) {
        $('#instansiSelect' + participantId).on('change', function() {
          var statusKehadiran = $(this).find(':selected').data('status-kehadiran');
          
          $('#kehadiranInput' + participantId).val('');
          $('#kendaraan' + participantId).val('');
          
          $('#kehadiranInput' + participantId).val(statusKehadiran);
          
          if (statusKehadiran === 'hybrid') {
            $('#kendaraanDiv' + participantId).show();
          } else {
            $('#kendaraanDiv' + participantId).hide();
          }
        });
      }

      @foreach ($participants as $participant)
        handleInstansiChange({{ $participant->id }});

        var initialStatusKehadiran{{ $participant->id }} = $('#instansiSelect{{ $participant->id }}').find(':selected').data('status-kehadiran');
        if (initialStatusKehadiran{{ $participant->id }} === 'hybrid') {
          $('#kendaraanDiv{{ $participant->id }}').show();
        } else {
          $('#kendaraanDiv{{ $participant->id }}').hide();
        }
      @endforeach
    });
    $(document).ready(function() {
        $('#instansiSelect').on('change', function() {
            var statusKehadiran = $(this).find(':selected').data('status-kehadiran');

            $('#kehadiranInput').val('');
            $('select[name="kendaraan"]').val('');
            
            $('#kehadiranInput').val(statusKehadiran);
            
            if (statusKehadiran === 'hybrid') {
              $('#kendaraanDiv').show();
            } else {
              $('#kendaraanDiv').hide();
            }
        });
    });
    document.getElementById('kehadiran').addEventListener('change', function () {
        const kehadiran = this.value;
        const kendaraanSelect = document.getElementById('kendaraan');
        const kendaraanLabel = document.getElementById('label-kendaraan');

        if (kehadiran === 'onsite') {
            kendaraanSelect.setAttribute('required', 'required');
            kendaraanLabel.classList.add('required');
        } else {
            kendaraanSelect.removeAttribute('required');
            kendaraanLabel.classList.remove('required');
            kendaraanSelect.value = "";
        }
    });

    @foreach ($participants as $participant)
    document.getElementById('kehadiran{{ $participant->id }}').addEventListener('change', function () {
        const kehadiran = this.value;
        const kendaraanSelect = document.getElementById('kendaraan{{ $participant->id }}');
        const kendaraanLabel = document.getElementById('label-kendaraan{{ $participant->id }}');

        if (kehadiran === 'onsite') {
            kendaraanSelect.setAttribute('required', 'required');
            kendaraanLabel.classList.add('required');
        } else {
            kendaraanSelect.removeAttribute('required');
            kendaraanLabel.classList.remove('required');
            kendaraanSelect.value = "";
        }
    });
    @endforeach
</script>
@endpush