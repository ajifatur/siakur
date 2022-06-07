@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit Kurikulum')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit Kurikulum</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.kurikulum.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $kurikulum->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="nama" class="form-control form-control-sm {{ $errors->has('nama') ? 'border-danger' : '' }}" value="{{ $kurikulum->nama }}" autofocus>
                            @if($errors->has('nama'))
                            <div class="small text-danger">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-1" value="1" {{ $kurikulum->status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-1">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-0" value="0" {{ $kurikulum->status == '0' ? 'checked' : '' }}>
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
                            <a href="{{ route('admin.kurikulum.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection