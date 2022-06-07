@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit Wali Kelas')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit Wali Kelas</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.wali-kelas.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $wali_kelas->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Rombel <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="rombel" class="form-select form-select-sm {{ $errors->has('rombel') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($rombel as $r)
                                <option value="{{ $r->id }}" {{ $wali_kelas->rombel_id == $r->id ? 'selected' : '' }}>{{ $r->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('rombel'))
                            <div class="small text-danger">{{ $errors->first('rombel') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Guru <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="guru" class="form-select form-select-sm {{ $errors->has('guru') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($guru as $g)
                                <option value="{{ $g->id }}" {{ $wali_kelas->guru_id == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('guru'))
                            <div class="small text-danger">{{ $errors->first('guru') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.wali-kelas.index') }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
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
    Spandiv.Select2("select[name=guru]"); 
</script>

@endsection