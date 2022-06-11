@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Rapor')

@section('content')

@include('admin/partials/tahun-akademik')

@if($wali_kelas)
<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Rapor: {{ $wali_kelas->rombel->nama }}</h1>
</div>
@endif
<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-body">
                @if($wali_kelas)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th width="20">No</th>
                                    <th>Nama</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggota_rombel as $ar)
                                <tr>
                                    <td align="right">{{ $ar->no_urut }}</td>
                                    <td>{{ $ar->siswa ? $ar->siswa->nama : '-' }}</td>
                                    <td align="center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.rapor.detail', ['id' => $ar->siswa_id]) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Atur Rapor"><i class="bi-wrench"></i></a>
                                            <a href="{{ route('admin.rapor.detail', ['id' => $ar->siswa_id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Cetak Rapor"><i class="bi-printer"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        <div class="alert-message">Tidak ada rombel yang diampu.</div>
                    </div>
                @endif
            </div>
		</div>
	</div>
</div>

@endsection

@section('css')

<style>
    .table thead tr th {text-align: center; vertical-align: middle;}
</style>

@endsection