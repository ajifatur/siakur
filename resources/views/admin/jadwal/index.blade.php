@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Jadwal')

@section('content')

@include('admin/partials/tahun-akademik')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Jadwal</h1>
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
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th rowspan="2"></th>
                                @for($i=1;$i<=6;$i++)
                                <th colspan="{{ count($rombel) }}">{{ hari($i) }}</th>
                                @endfor
                            </tr>
                            <tr>
                                @for($i=1;$i<=6;$i++)
                                    @foreach($rombel as $r)
                                    <th>{{ $r->nama }}</th>
                                    @endforeach
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jp as $j)
                            <tr>
                                <td width="30"><small>{{ $j->jam_mulai }}-{{ $j->jam_selesai }}</small></td>
                                @for($i=1;$i<=6;$i++)
                                    @foreach($rombel as $r)
                                        <?php $jadwal = \App\Models\Jadwal::where('ta_id','=',tahun_akademik()->id)->where('jp_id','=',$j->id)->where('rombel_id','=',$r->id)->where('ta_id','=',session()->get('taa'))->where('hari','=',$i)->first(); ?>
                                        @if($jadwal)
                                            <td width="30">
                                                <a href="#" class="btn-detail" data-bs-toggle="tooltip" title="Detail Jadwal" data-id="{{ $jadwal->id }}" data-hari="{{ $i }}" data-jam="{{ $j->id }}" data-rombel="{{ $r->id }}" data-mapel="{{ $jadwal->gurumapel_id }}">{{ $jadwal->guru_mapel->mapel->kode }}</a>
                                            </td>
                                        @else
                                            <td width="30">
                                                <a href="#" class="btn btn-sm btn-add text-danger" data-bs-toggle="tooltip" title="Tambah Jadwal" data-hari="{{ $i }}" data-jam="{{ $j->id }}" data-rombel="{{ $r->id }}"><i class="bi-plus-circle"></i></a>
                                            </td>
                                        @endif
                                    @endforeach
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.jadwal.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<div class="modal fade" id="modal-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.jadwal.store') }}">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" value="{{ old('id') }}">
                    <input type="hidden" name="type" value="{{ old('type') }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hari</label>
                        <select name="hari" class="form-select form-select-sm" disabled>
                            <option value="" disabled selected>--Pilih--</option>
                            @for($i=1;$i<=6;$i++)
                            <option value="{{ $i }}" {{ old('hari') == $i ? 'selected' : '' }}>{{ hari($i) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam</label>
                        <select name="jam" class="form-select form-select-sm" disabled>
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($jp as $j)
                            <option value="{{ $j->id }}" {{ old('jam') == $j->id ? 'selected' : '' }}>{{ $j->jam_mulai }}-{{ $j->jam_selesai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rombel</label>
                        <select name="rombel" class="form-select form-select-sm" disabled>
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($rombel as $r)
                            <option value="{{ $r->id }}" {{ old('rombel') == $r->id ? 'selected' : '' }}>{{ $r->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mata Pelajaran</label>
                        <select name="mapel" class="form-select form-select-sm {{ $errors->has('mapel') ? 'border-danger' : '' }}">
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($guru_mapel as $gm)
                            <option value="{{ $gm->id }}" {{ old('mapel') == $gm->id ? 'selected' : '' }}>{{ $gm->mapel->nama }} - {{ $gm->guru->nama }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('mapel'))
                        <div class="small text-danger">{{ $errors->first('mapel') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    $(document).on("click", ".btn-add", function(e) {
        e.preventDefault();
        reset_form();
        $("#modal-form .modal-title").text("Tambah Jadwal");
        $("#modal-form input[name=type]").val("create");
        $("#modal-form select[name=hari]").val($(this).data("hari"));
        $("#modal-form select[name=jam]").val($(this).data("jam"));
        $("#modal-form select[name=rombel]").val($(this).data("rombel"));
        Spandiv.Modal("#modal-form").show();
    });

    $(document).on("click", ".btn-detail", function(e) {
        e.preventDefault();
        reset_form();
        $("#modal-form .modal-title").text("Detail Jadwal");
        $("#modal-form input[name=id]").val($(this).data("id"));
        $("#modal-form input[name=type]").val("update");
        $("#modal-form select[name=hari]").val($(this).data("hari"));
        $("#modal-form select[name=jam]").val($(this).data("jam"));
        $("#modal-form select[name=rombel]").val($(this).data("rombel"));
        $("#modal-form select[name=mapel]").val($(this).data("mapel"));
        $("#modal-form .btn-delete").attr("data-id", $(this).data("id"));
        $("#modal-form .btn-delete").removeClass("d-none");
        Spandiv.Modal("#modal-form").show();
    });

    function reset_form() {
        $("#modal-form .btn-delete").addClass("d-none");
        $("#modal-form select").each(function(key,elem) {
            $(elem).val(null);
            $(elem).removeClass("border-danger");
        });
        $("#modal-form .small.text-danger").each(function(key,elem) {
            $(elem).addClass("d-none");
        });
    }

    $(document).on("click", "#modal-form button[type=submit]", function(e) {
        e.preventDefault();
        $("#modal-form select").each(function(key,elem) {
            $(elem).removeAttr("disabled");
        });
        $("#modal-form form").submit();
    });

    Spandiv.ButtonDelete(".btn-delete", ".form-delete");
</script>

@if($errors->has('mapel') && old('type') == 'create')
<script>
    $("#modal-form .modal-title").text("Tambah Jadwal");
    Spandiv.Modal("#modal-form").show();
</script>
@endif

@if($errors->has('mapel') && old('type') == 'update')
<script>
    $("#modal-form .modal-title").text("Detail Jadwal");
    Spandiv.Modal("#modal-form").show();
</script>
@endif

@endsection

@section('css')

<style>
    .table {min-width: 100vw;}
    .table thead tr th, .table tbody tr td {text-align: center; font-size: .75rem!important;}
</style>

@endsection