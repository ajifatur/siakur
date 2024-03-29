@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola '.$jenis_file->nama)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola {{ $jenis_file->nama }}</h1>
    <div class="btn-group">
        <a href="{{ route('admin.file.create', ['id' => $jenis_file->id]) }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah {{ $jenis_file->nama }}</a>
    </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="datatable">
                        <thead class="bg-light">
                            <tr>
                                <th width="30"><input type="checkbox" class="form-check-input checkbox-all"></th>
                                @if(Auth::user()->role_id == role('super-admin') || Auth::user()->guru && Auth::user()->guru->waka_kurikulum->where('ta_id','=',tahun_akademik()->id)->count() > 0)
                                <th>Guru</th>
                                @endif
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th width="60">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($file as $f)
                            <tr>
                                <td align="center"><input type="checkbox" class="form-check-input checkbox-one"></td>
                                @if(Auth::user()->role_id == role('super-admin') || Auth::user()->guru && Auth::user()->guru->waka_kurikulum->where('ta_id','=',tahun_akademik()->id)->count() > 0)
                                <td>{{ $f->guru_mapel->guru->nama }}</td>
                                @endif
                                <td>{{ $f->guru_mapel->mapel->nama }}</td>
                                <td>{{ $f->kelas->nama }}</td>
                                <td align="center">
                                    <div class="btn-group">
                                        <a href="{{ asset('uploads/'.$f->file) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Download" target="_blank"><i class="bi-download"></i></a>
                                        <a href="{{ route('admin.file.edit', ['id' => $f->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $f->id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.file.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

@endsection

@section('js')

<script type="text/javascript">
    // DataTable
    Spandiv.DataTable("#datatable");

    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");
</script>

@endsection