@extends('faturhelper::layouts/admin/main')

@section('title', 'Tambah Tahun Akademik')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Tambah Tahun Akademik</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.tahun-akademik.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="tahun" class="form-select form-select-sm {{ $errors->has('tahun') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @for($y=date('Y');$y>=2020;$y--)
                                <option value="{{ $y }}" {{ old('tahun') == $y ? 'selected' : '' }}>{{ $y.'/'.($y + 1) }}</option>
                                @endfor
                            </select>
                            @if($errors->has('tahun'))
                            <div class="small text-danger">{{ $errors->first('tahun') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Semester <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="semester" id="semester-1" value="1" {{ old('semester') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="semester-1">
                                    Ganjil
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="semester" id="semester-2" value="2" {{ old('semester') == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="semester-2">
                                    Genap
                                </label>
                            </div>
                            @if($errors->has('semester'))
                            <div class="small text-danger">{{ $errors->first('semester') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-1" value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-1">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-0" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-0">
                                    Tidak Aktif
                                </label>
                            </div>
                            @if($errors->has('status'))
                            <div class="small text-danger">{{ $errors->first('status') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.tahun-akademik.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection