@extends('faturhelper::layouts/admin/main')

@section('title', 'Rapor')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Rapor</h1>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">Nama:</span>
                        <span>{{ $anggota_rombel->siswa->nama }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">NIS:</span>
                        <span>{{ $anggota_rombel->siswa->nomor_identitas }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">Rombel:</span>
                        <span>{{ $anggota_rombel->rombel->nama }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">Semester:</span>
                        <span>{{ $tahun_akademik->semester == 1 ? 'Ganjil' : 'Genap' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-1">
                        <span class="fw-bold">Tahun Ajaran:</span>
                        <span>{{ $tahun_akademik->tahun.'/'.($tahun_akademik->tahun+1) }}</span>
                    </li>
                </ul>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th rowspan="2" width="20">No</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="3">Pengetahuan</th>
                                <th colspan="3">Keterampilan</th>
                            </tr>
                            <tr>
                                <th>KKM</th>
                                <th>Nilai</th>
                                <th>Predikat</th>
                                <th>KKM</th>
                                <th>Nilai</th>
                                <th>Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mapel as $key=>$m)
                            <?php
                                $kkm_p = kkm($anggota_rombel->rombel->kelas_id, $m->id, 1);
                                $kkm_k = kkm($anggota_rombel->rombel->kelas_id, $m->id, 2);
                                $nilai_p = count($m->gm) > 0 ? total_nilai($anggota_rombel->siswa_id, $m->gm[0], 1) : 0;
                                $nilai_k = count($m->gm) > 0 ? total_nilai($anggota_rombel->siswa_id, $m->gm[0], 2) : 0;
                            ?>
                            <tr>
                                <td align="right">{{ ($key+1) }}</td>
                                <td>{{ $m->nama }}</td>
                                <td align="center" width="70">{{ $kkm_p }}</td>
                                <td align="center" width="70">{{ $nilai_p }}</td>
                                <td align="center" width="70">{{ predikat($nilai_p, $kkm_p) }}</td>
                                <td align="center" width="70">{{ $kkm_k }}</td>
                                <td align="center" width="70">{{ $nilai_k }}</td>
                                <td align="center" width="70">{{ predikat($nilai_k, $kkm_k) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row mb-3">
                    <label class="col-lg-2 col-md-3 col-form-label">Predikat Sikap Spiritual <span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-9">
                        <select name="sikap_spiritual_predikat" class="form-select form-select-sm {{ $errors->has('sikap_spiritual_predikat') ? 'border-danger' : '' }}" disabled>
                            <option value="" disabled selected>Belum Ada Nilai</option>
                            <option value="A" {{ $rapor && $rapor->sikap_spiritual_predikat == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ $rapor && $rapor->sikap_spiritual_predikat == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ $rapor && $rapor->sikap_spiritual_predikat == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ $rapor && $rapor->sikap_spiritual_predikat == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                        @if($errors->has('sikap_spiritual_predikat'))
                        <div class="small text-danger">{{ $errors->first('sikap_spiritual_predikat') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Sikap Spiritual <span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-9">
                        <textarea name="sikap_spiritual_deskripsi" class="form-control form-control-sm {{ $errors->has('sikap_spiritual_deskripsi') ? 'border-danger' : '' }}" rows="3" disabled>{{ $rapor ? $rapor->sikap_spiritual_deskripsi : 'Belum Ada Nilai' }}</textarea>
                        @if($errors->has('sikap_spiritual_deskripsi'))
                        <div class="small text-danger">{{ $errors->first('sikap_spiritual_deskripsi') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-lg-2 col-md-3 col-form-label">Predikat Sikap Sosial <span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-9">
                        <select name="sikap_sosial_predikat" class="form-select form-select-sm {{ $errors->has('sikap_sosial_predikat') ? 'border-danger' : '' }}" disabled>
                            <option value="" disabled selected>Belum Ada Nilai</option>
                            <option value="A" {{ $rapor && $rapor->sikap_sosial_predikat == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ $rapor && $rapor->sikap_sosial_predikat == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ $rapor && $rapor->sikap_sosial_predikat == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ $rapor && $rapor->sikap_sosial_predikat == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                        @if($errors->has('sikap_sosial_predikat'))
                        <div class="small text-danger">{{ $errors->first('sikap_sosial_predikat') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Sikap Sosial <span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-9">
                        <textarea name="sikap_sosial_deskripsi" class="form-control form-control-sm {{ $errors->has('sikap_sosial_deskripsi') ? 'border-danger' : '' }}" rows="3" disabled>{{ $rapor ? $rapor->sikap_sosial_deskripsi : 'Belum Ada Nilai' }}</textarea>
                        @if($errors->has('sikap_sosial_deskripsi'))
                        <div class="small text-danger">{{ $errors->first('sikap_sosial_deskripsi') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-lg-2 col-md-3 col-form-label">Status <span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-9">
                        <select name="status" class="form-select form-select-sm {{ $errors->has('status') ? 'border-danger' : '' }}" disabled>
                            <option value="" disabled selected>Belum Ada Nilai</option>
                            <option value="0" {{ $rapor && $rapor->status == '0' ? 'selected' : '' }}>Tidak Ada</option>
                            <option value="1" {{ $rapor && $rapor->status == '1' ? 'selected' : '' }}>Naik Kelas</option>
                            <option value="2" {{ $rapor && $rapor->status == '2' ? 'selected' : '' }}>Tinggal Kelas</option>
                            <option value="3" {{ $rapor && $rapor->status == '3' ? 'selected' : '' }}>Lulus</option>
                            <option value="4" {{ $rapor && $rapor->status == '4' ? 'selected' : '' }}>Tidak Lulus</option>
                        </select>
                        @if($errors->has('status'))
                        <div class="small text-danger">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>
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