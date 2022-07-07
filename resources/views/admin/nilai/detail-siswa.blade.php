@extends('faturhelper::layouts/admin/main')

@section('title', 'Lihat Nilai')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Lihat Nilai</h1>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">Mata Pelajaran:</span>
                        <span>{{ $guru_mapel->mapel->nama }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">Rombel:</span>
                        <span>{{ $rombel->nama }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">KKM Pengetahuan:</span>
                        <span>{{ $kkm_p ? $kkm_p->kkm : '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">KKM Keterampilan:</span>
                        <span>{{ $kkm_k ? $kkm_k->kkm : '-' }}</span>
                    </li>
                </ul>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th colspan="{{ count($ulangan) + 1 }}">Pengetahuan</th>
                                <th colspan="{{ count($ulangan) + 1 }}">Keterampilan</th>
                            </tr>
                            <tr>
                                @foreach($ulangan as $u)
                                <th>{{ $u }}</th>
                                @endforeach
                                <th>Total</th>
                                @foreach($ulangan as $u)
                                <th>{{ $u }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggota_rombel as $ar)
                            <tr>
                                @foreach($ulangan as $u)
                                <td width="50">
                                    <input type="text" class="form-control form-control-sm score" value="{{ nilai($ar->siswa_id, $guru_mapel->id, 1, $u) }}" data-siswa="{{ $ar->siswa_id }}" data-jenis="1" data-ulangan="{{ $u }}" disabled>
                                </td>
                                @endforeach
                                <td width="50" align="center">
                                    <span class="fw-bold total-p" data-id="{{ $ar->siswa_id }}">{{ total_nilai($ar->siswa_id, $guru_mapel->id, 1) }}</span>
                                </td>
                                @foreach($ulangan as $u)
                                <td width="50">
                                    <input type="text" class="form-control form-control-sm score" value="{{ nilai($ar->siswa_id, $guru_mapel->id, 2, $u) }}" data-siswa="{{ $ar->siswa_id }}" data-jenis="2" data-ulangan="{{ $u }}" disabled>
                                </td>
                                @endforeach
                                <td width="50" align="center">
                                    <span class="fw-bold total-k" data-id="{{ $ar->siswa_id }}">{{ total_nilai($ar->siswa_id, $guru_mapel->id, 2) }}</span>
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

@endsection

@section('css')

<style>
    .table thead tr th {text-align: center; vertical-align: middle;}
    .table .score {text-align: center;}
</style>

@endsection

@section('js')

@endsection