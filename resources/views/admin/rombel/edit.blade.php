@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit Rombel')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit Rombel</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.rombel.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $rombel->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kelas <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="kelas" class="form-select form-select-sm {{ $errors->has('kelas') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ $rombel->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kelas'))
                            <div class="small text-danger">{{ $errors->first('kelas') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Jurusan <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="jurusan" class="form-select form-select-sm {{ $errors->has('jurusan') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($jurusan as $j)
                                <option value="{{ $j->id }}" {{ $rombel->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('jurusan'))
                            <div class="small text-danger">{{ $errors->first('jurusan') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="nama" class="form-control form-control-sm {{ $errors->has('nama') ? 'border-danger' : '' }}" value="{{ $rombel->nama }}">
                            @if($errors->has('nama'))
                            <div class="small text-danger">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.rombel.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection