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
                                                <a href="#">{{ $jadwal->guru_mapel->mapel->kode }}</a>
                                            </td>
                                        @else
                                            <td width="30">
                                                <a href="#" class="btn btn-sm text-danger" data-bs-toggle="tooltip" title="Tambah Jadwal"><i class="bi-plus-circle"></i></a>
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

@endsection

@section('css')

<style>
    .table {min-width: 100vw;}
    .table thead tr th, .table tbody tr td {text-align: center; font-size: .75rem!important;}
</style>

@endsection