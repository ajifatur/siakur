@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Jadwal')

@section('content')

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
                                        <?php $jadwal = \App\Models\Jadwal::where('jp_id','=',$j->id)->where('rombel_id','=',$r->id)->where('ta_id','=',tahun_akademik()->id)->where('hari','=',$i)->first(); ?>
                                        @if($jadwal)
                                            <td width="30">
                                                <a href="#" class="btn-detail" data-bs-toggle="tooltip" title="Detail Jadwal" data-hari="{{ hari($i) }}" data-jam="{{ $j->jam_mulai }}-{{ $j->jam_selesai }}" data-rombel="{{ $r->nama }}" data-kode="{{ $jadwal->guru_mapel->mapel->kode }}" data-nama="{{ $jadwal->guru_mapel->mapel->nama }}" data-guru="{{ $jadwal->guru_mapel->guru->nama }}">{{ $jadwal->guru_mapel->mapel->kode }}</a>
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

<div class="modal fade" id="modal-detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Jadwal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>Hari:</strong><br><span class="hari"></span></p>
                        <p><strong>Jam:</strong><br><span class="jam"></span></p>
                        <p><strong>Rombel:</strong><br><span class="rombel"></span></p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Kode Mata Pelajaran:</strong><br><span class="kode"></span></p>
                        <p><strong>Nama Mata Pelajaran:</strong><br><span class="nama"></span></p>
                        <p><strong>Guru:</strong><br><span class="guru"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hari</label>
                        <select name="hari" class="form-select form-select-sm" disabled>
                            <option value="" disabled selected>--Pilih--</option>
                            @for($i=1;$i<=6;$i++)
                            <option value="{{ $i }}">{{ hari($i) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam</label>
                        <select name="jam" class="form-select form-select-sm" disabled>
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($jp as $j)
                            <option value="{{ $j->id }}">{{ $j->jam_mulai }}-{{ $j->jam_selesai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rombel</label>
                        <select name="rombel" class="form-select form-select-sm" disabled>
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($rombel as $r)
                            <option value="{{ $r->id }}">{{ $r->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mata Pelajaran</label>
                        <select name="mapel" class="form-select form-select-sm">
                            <option value="" disabled selected>--Pilih--</option>
                            @foreach($guru_mapel as $gm)
                            <option value="{{ $gm->id }}">{{ $gm->mapel->nama }} - {{ $gm->guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" disabled>Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    $(document).on("click", ".btn-detail", function(e) {
        e.preventDefault();
        $("#modal-detail .hari").text($(this).data("hari"));
        $("#modal-detail .jam").text($(this).data("jam"));
        $("#modal-detail .rombel").text($(this).data("rombel"));
        $("#modal-detail .kode").text($(this).data("kode"));
        $("#modal-detail .nama").text($(this).data("nama"));
        $("#modal-detail .guru").text($(this).data("guru"));
        Spandiv.Modal("#modal-detail").show();
    });

    $(document).on("click", ".btn-add", function(e) {
        e.preventDefault();
        $("#modal-form select[name=hari]").val($(this).data("hari"));
        $("#modal-form select[name=jam]").val($(this).data("jam"));
        $("#modal-form select[name=rombel]").val($(this).data("rombel"));
        Spandiv.Modal("#modal-form").show();
    });
</script>

@endsection

@section('css')

<style>
    .table {min-width: 100vw;}
    .table thead tr th, .table tbody tr td {text-align: center; font-size: .75rem!important;}
</style>

@endsection