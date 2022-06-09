@extends('faturhelper::layouts/admin/main')

@section('title', 'Detail Rombel: '.$rombel->nama)

@section('content')

@include('admin/partials/tahun-akademik')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Detail Rombel: {{ $rombel->nama }}</h1>
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
                <a href="{{ route('admin.anggota-rombel.create', ['id' => $rombel->id]) }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi-plus me-1"></i>Tambah Anggota</a>
                <br>
                @if(count($anggota_rombel) > 0)
                    <p class="fst-italic small text-muted"><i class="bi-info-circle me-1"></i> Tekan dan geser data di bawah ini untuk mengurutkannya.</p>
                    <div class="row">
                        <div class="col-auto">
                            @foreach($anggota_rombel as $key=>$ar)
                                <div style="height: 44px; line-height: 44px; font-weight: bold;">{{ $key+1 }}</div>
                            @endforeach
                        </div>
                        <div class="col">
                            <div class="list-group sortable" data-url="{{ route('admin.anggota-rombel.sort') }}">
                                @csrf
                                @foreach($anggota_rombel as $ar)
                                    <div class="list-group-item d-flex justify-content-between align-items-center p-2" data-id="{{ $ar->id }}">
                                        <div>
                                            <span>{{ $ar->siswa ? $ar->siswa->nama : '-' }}</span>
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-outline-secondary btn-delete" data-id="{{ $ar->id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <em class="text-danger">Belum ada anggota.</em>
                @endif
            </div>
		</div>
	</div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.anggota-rombel.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 d-none">
    <div class="toast align-items-center text-white bg-success border-0" id="toast-sort" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");

    // Sortable
    Spandiv.Sortable(".sortable");
</script>

@endsection