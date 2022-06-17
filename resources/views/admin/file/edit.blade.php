@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit '.$file->jenis_file->nama)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit {{ $file->jenis_file->nama }}</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.file.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $file->id }}">
                    <input type="hidden" name="jenis_file" value="{{ $file->jenis_file->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="guru_mapel" class="form-select form-select-sm {{ $errors->has('guru_mapel') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($guru_mapel as $g)
                                <option value="{{ $g->id }}" {{ $file->gurumapel_id == $g->id ? 'selected' : '' }}>{{ $g->mapel->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('guru_mapel'))
                            <div class="small text-danger">{{ $errors->first('guru_mapel') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kelas <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="kelas" class="form-select form-select-sm {{ $errors->has('kelas') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ $file->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kelas'))
                            <div class="small text-danger">{{ $errors->first('kelas') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.file.index', ['id' => $file->jenis_file->id]) }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection