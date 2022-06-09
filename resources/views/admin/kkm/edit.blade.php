@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit KKM')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit KKM</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.kkm.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $kkm->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kelas <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="kelas" class="form-select form-select-sm {{ $errors->has('kelas') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ $kkm->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kelas'))
                            <div class="small text-danger">{{ $errors->first('kelas') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="mapel" class="form-select form-select-sm {{ $errors->has('mapel') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($mapel as $m)
                                <option value="{{ $m->id }}" {{ $kkm->mapel_id == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('mapel'))
                            <div class="small text-danger">{{ $errors->first('mapel') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Jenis <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="jenis-1" value="1" {{ $kkm->jenis == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jenis-1">
                                    Pengetahuan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="jenis-2" value="2" {{ $kkm->jenis == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jenis-2">
                                    Keterampilan
                                </label>
                            </div>
                            @if($errors->has('jenis'))
                            <div class="small text-danger">{{ $errors->first('jenis') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">KKM <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="number" name="kkm" class="form-control form-control-sm score {{ $errors->has('kkm') ? 'border-danger' : '' }}" value="{{ $kkm->kkm }}">
                            @if($errors->has('kkm'))
                            <div class="small text-danger">{{ $errors->first('kkm') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Predikat A <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="deskripsi_a" class="form-control form-control-sm {{ $errors->has('deskripsi_a') ? 'border-danger' : '' }}" rows="3">{{ $kkm->deskripsi_a }}</textarea>
                            @if($errors->has('deskripsi_a'))
                            <div class="small text-danger">{{ $errors->first('deskripsi_a') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Predikat B <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="deskripsi_b" class="form-control form-control-sm {{ $errors->has('deskripsi_b') ? 'border-danger' : '' }}" rows="3">{{ $kkm->deskripsi_b }}</textarea>
                            @if($errors->has('deskripsi_b'))
                            <div class="small text-danger">{{ $errors->first('deskripsi_b') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Predikat C <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="deskripsi_c" class="form-control form-control-sm {{ $errors->has('deskripsi_c') ? 'border-danger' : '' }}" rows="3">{{ $kkm->deskripsi_c }}</textarea>
                            @if($errors->has('deskripsi_c'))
                            <div class="small text-danger">{{ $errors->first('deskripsi_c') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Predikat D <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="deskripsi_d" class="form-control form-control-sm {{ $errors->has('deskripsi_d') ? 'border-danger' : '' }}" rows="3">{{ $kkm->deskripsi_d }}</textarea>
                            @if($errors->has('deskripsi_d'))
                            <div class="small text-danger">{{ $errors->first('deskripsi_d') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.kkm.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
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
    $(document).on("keyup", ".score", function() {
        $(this).val(parseInt($(this).val()));
        var value = $(this).val();
        if(value < 0) $(this).val(0);
        else if(value > 100) $(this).val(100);
    });
</script>

@endsection