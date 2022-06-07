@extends('faturhelper::layouts/admin/main')

@section('title', 'Tambah Mutasi Siswa')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Tambah Mutasi Siswa</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.mutasi-siswa.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Siswa <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="siswa" class="form-select form-select-sm {{ $errors->has('siswa') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ old('siswa') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('siswa'))
                            <div class="small text-danger">{{ $errors->first('siswa') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Sekolah Tujuan <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="tujuan" class="form-control form-control-sm {{ $errors->has('tujuan') ? 'border-danger' : '' }}" value="{{ old('tujuan') }}">
                            @if($errors->has('tujuan'))
                            <div class="small text-danger">{{ $errors->first('tujuan') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Per Tanggal <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="tanggal" class="form-control form-control-sm {{ $errors->has('tanggal') ? 'border-danger' : '' }}" value="{{ old('tanggal') }}" autocomplete="off">
                                <span class="input-group-text"><i class="bi-calendar2"></i></span>
                            </div>
                            @if($errors->has('tanggal'))
                            <div class="small text-danger">{{ $errors->first('tanggal') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.mutasi-siswa.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
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
    // Select2
    Spandiv.Select2("select[name=siswa]"); 

    // Datepicker
    Spandiv.DatePicker("input[name=tanggal]");
</script>

@endsection