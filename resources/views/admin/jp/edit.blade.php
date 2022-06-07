@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit Jam Pelajaran')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit Jam Pelajaran</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.jp.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $jp->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Jam Mulai <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="jam_mulai" class="form-control form-control-sm {{ $errors->has('jam_mulai') ? 'border-danger' : '' }}" value="{{ $jp->jam_mulai }}" autocomplete="off">
                                <span class="input-group-text"><i class="bi-alarm"></i></span>
                            </div>
                            @if($errors->has('jam_mulai'))
                            <div class="small text-danger">{{ $errors->first('jam_mulai') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Jam Selesai <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="jam_selesai" class="form-control form-control-sm {{ $errors->has('jam_selesai') ? 'border-danger' : '' }}" value="{{ $jp->jam_selesai }}" autocomplete="off">
                                <span class="input-group-text"><i class="bi-alarm"></i></span>
                            </div>
                            @if($errors->has('jam_selesai'))
                            <div class="small text-danger">{{ $errors->first('jam_selesai') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.jp.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
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
    // ClockPicker
    Spandiv.ClockPicker("input[name=jam_mulai]");
    Spandiv.ClockPicker("input[name=jam_selesai]");
</script>

@endsection