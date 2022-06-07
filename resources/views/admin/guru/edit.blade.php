@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit Guru')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit Guru</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.guru.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $guru->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="nama" class="form-control form-control-sm {{ $errors->has('nama') ? 'border-danger' : '' }}" value="{{ $guru->nama }}" autofocus>
                            @if($errors->has('nama'))
                            <div class="small text-danger">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">NIP/NUPTK <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="nomor_identitas" class="form-control form-control-sm {{ $errors->has('nomor_identitas') ? 'border-danger' : '' }}" value="{{ $guru->nomor_identitas }}">
                            @if($errors->has('nomor_identitas'))
                            <div class="small text-danger">{{ $errors->first('nomor_identitas') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            @foreach(gender() as $gender)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender-{{ $gender['key'] }}" value="{{ $gender['key'] }}" {{ $guru->jenis_kelamin == $gender['key'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender-{{ $gender['key'] }}">
                                    {{ $gender['name'] }}
                                </label>
                            </div>
                            @endforeach
                            @if($errors->has('jenis_kelamin'))
                            <div class="small text-danger">{{ $errors->first('jenis_kelamin') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="tempat_lahir" class="form-control form-control-sm {{ $errors->has('tempat_lahir') ? 'border-danger' : '' }}" value="{{ $guru->tempat_lahir }}">
                            @if($errors->has('tempat_lahir'))
                            <div class="small text-danger">{{ $errors->first('tempat_lahir') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="tanggal_lahir" class="form-control form-control-sm {{ $errors->has('tanggal_lahir') ? 'border-danger' : '' }}" value="{{ date('d/m/Y', strtotime($guru->tanggal_lahir)) }}" autocomplete="off">
                                <span class="input-group-text"><i class="bi-calendar2"></i></span>
                            </div>
                            @if($errors->has('tanggal_lahir'))
                            <div class="small text-danger">{{ $errors->first('tanggal_lahir') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">No. Telepon <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="nomor_telepon" class="form-control form-control-sm {{ $errors->has('nomor_telepon') ? 'border-danger' : '' }}" value="{{ $guru->nomor_telepon }}">
                            @if($errors->has('nomor_telepon'))
                            <div class="small text-danger">{{ $errors->first('nomor_telepon') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Alamat <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="alamat" class="form-control form-control-sm {{ $errors->has('alamat') ? 'border-danger' : '' }}" rows="3">{{ $guru->alamat }}</textarea>
                            @if($errors->has('alamat'))
                            <div class="small text-danger">{{ $errors->first('alamat') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection

@section('js')

<script type="text/javascript">    
    // Datepicker
    Spandiv.DatePicker("input[name=tanggal_lahir]");
</script>

@endsection