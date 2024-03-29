@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Mata Pelajaran')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Mata Pelajaran</h1>
    <div class="btn-group">
        <a href="{{ route('admin.mapel.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Mata Pelajaran</a>
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
                                <th width="100">Kode</th>
                                <th>Nama</th>
                                <th width="60">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mapel as $m)
                            <tr data-url="{{ route('admin.mapel.detail', ['id' => $m->id]) }}">
                                <td align="center"><input type="checkbox" class="form-check-input checkbox-one"></td>
                                <td>{{ $m->kode }}</td>
                                <td>{{ $m->nama }}</td>
                                <td align="center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.mapel.edit', ['id' => $m->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $m->id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
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

<form class="form-delete d-none" method="post" action="{{ route('admin.mapel.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

@endsection

@section('js')

<script type="text/javascript">
    // DataTable
    Spandiv.DataTable("#datatable");

    // DataTable rows clicked
    $(document).on("click", "#datatable tbody tr td:not([align])", function(e) {
        e.preventDefault();
        var selection = getSelection().toString();
        if(selection == '') {
            var url = $(this).parents('tr').data("url");
            window.location.href = url;
        }
    });

    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");
</script>

@endsection

@section('css')

<style>
    #datatable tbody tr td:not([align]) {cursor: pointer;}
</style>

@endsection