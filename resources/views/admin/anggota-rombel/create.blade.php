@extends('faturhelper::layouts/admin/main')

@section('title', 'Tambah Anggota Rombel: '.$rombel->nama)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Tambah Anggota Rombel: {{ $rombel->nama }}</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.anggota-rombel.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="rombel" value="{{ $rombel->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Siswa <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <select name="siswa" class="form-select form-select-sm {{ $errors->has('siswa') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ old('siswa') == $s->id ? 'selected' : '' }}>{{ $s->nomor_identitas }} - {{ $s->nama }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('siswa'))
                            <div class="small text-danger">{{ $errors->first('siswa') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.rombel.detail', ['id' => $rombel->id]) }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
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
</script>

@endsection