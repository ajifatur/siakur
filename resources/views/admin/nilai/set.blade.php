@extends('faturhelper::layouts/admin/main')

@section('title', 'Atur Nilai')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Atur Nilai</h1>
    <div class="btn-group">
        <!-- <a href="{{ route('admin.rombel.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Rombel</a> -->
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
                                <th rowspan="2" width="20">No</th>
                                <th rowspan="2">Nama</th>
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
                                <td align="right">{{ $ar->no_urut }}</td>
                                <td>{{ $ar->siswa ? $ar->siswa->nama : '-' }}</td>
                                @foreach($ulangan as $u)
                                <td width="50"><input type="text" class="form-control form-control-sm score"></td>
                                @endforeach
                                <td width="50" align="center"><span class="fw-bold">0</span></td>
                                @foreach($ulangan as $u)
                                <td width="50"><input type="text" class="form-control form-control-sm score"></td>
                                @endforeach
                                <td width="50" align="center"><span class="fw-bold">0</span></td>
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

<script type="text/javascript">
    $(document).on("keyup", ".score", function() {
        if(isNaN($(this).val()) || $(this).val() == '')
            $(this).val(0);
        else
            $(this).val(parseInt($(this).val()));

        var value = $(this).val();
        if(value < 0) $(this).val(0);
        else if(value > 100) $(this).val(100);
    });
</script>

@endsection