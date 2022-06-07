@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Guru Mata Pelajaran')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Guru Mata Pelajaran</h1>
    <div class="btn-group">
        <a href="{{ route('admin.guru-mapel.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Guru Mata Pelajaran</a>
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
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th width="60">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru_mapel as $gm)
                            <tr>
                                <td align="center"><input type="checkbox" class="form-check-input checkbox-one"></td>
                                <td>{{ $gm->mapel ? $gm->mapel->nama : '-' }}</td>
                                <td>{{ $gm->guru ? $gm->guru->nama : '-' }}</td>
                                <td align="center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.guru-mapel.edit', ['id' => $gm->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $gm->id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
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

<form class="form-delete d-none" method="post" action="{{ route('admin.guru-mapel.delete') }}">
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