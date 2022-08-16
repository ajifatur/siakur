<table class="w-100 no-border">
	<tr>
		<td class="fw-bold" style="width:20%;">Nama Sekolah</td>
        <td class="fw-bold" style="width:30%;">: MAN 2 Banjarnegara</td>
		<td class="fw-bold" style="width:20%;">Kelas:</td>
        <td class="fw-bold" style="width:30%;">: {{ $anggota_rombel->rombel->nama }}</td>
	</tr>
	<tr>
		<td class="fw-bold">Nama</td>
		<td class="fw-bold">: {{ $anggota_rombel->siswa->nama }}</td>
        <td class="fw-bold">Semester</td>
		<td class="fw-bold">: {{ $tahun_akademik->semester == 1 ? 'Ganjil' : 'Genap' }}</td>
	</tr>
    <tr>
		<td class="fw-bold">Nomor Induk</td>
		<td class="fw-bold">: {{ $anggota_rombel->siswa->nomor_identitas }}</td>
        <td class="fw-bold">Tahun Ajaran</td>
		<td class="fw-bold">: {{ $tahun_akademik->tahun.'/'.($tahun_akademik->tahun+1) }}</td>
	</tr>
</table>
<center class="fw-bold mt-2">CAPAIAN HASIL BELAJAR</center>
<p class="fw-bold">A. Sikap</p>
<table class="bordered">
	<tr>
		<th style="width:25%">Predikat</th>
		<th>Deskripsi</th>
    </tr>
	<tr>
		<td>Sikap Spiritual : <span class="fw-bold">{{ $rapor->sikap_spiritual_predikat }}</span></td>
		<td>{{ $rapor->sikap_spiritual_deskripsi }}</td>
    </tr>
	<tr>
		<td>Sikap Sosial &nbsp;&nbsp;&nbsp; : <span class="fw-bold">{{ $rapor->sikap_sosial_predikat }}</span></td>
		<td>{{ $rapor->sikap_sosial_deskripsi }}</td>
	</tr>
</table>
<p class="fw-bold mt-2">B. Pengetahuan dan Keterampilan</p>
<table class="bordered">
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
        <td align="center" width="30">{{ $kkm_p }}</td>
        <td align="center" width="30">{{ $nilai_p }}</td>
        <td align="center" width="30">{{ predikat($nilai_p, $kkm_p) }}</td>
        <td align="center" width="30">{{ $kkm_k }}</td>
        <td align="center" width="30">{{ $nilai_k }}</td>
        <td align="center" width="30">{{ predikat($nilai_k, $kkm_k) }}</td>
    </tr>
    @endforeach
</tbody>
</table>
<table class="mt-2 w-100 no-border">
    <tr>
        <td></td>
        <td width="60">Diberikan di : </td>
    </tr>
    <tr>
        <td></td>
        <td>Pada Tanggal : <br><br></td>
    </tr>
    <tr>
        <td>Mengetahui,<br>Orang Tua/Wali<br><br><br></td>
		<td>Wali Kelas<br><br><br></td>
    </tr>
	<tr>
		<td>..............................................<br><br>&nbsp; </td>
		<td>..............................................<br><br>NIP. ......................................</td>
	</tr>
</table>


<style>
	table.no-border td, table.no-border th{padding-bottom: 5px}
	table.bordered{border-collapse: collapse; width:100%}
	table.bordered, table.bordered td, table.bordered th{border:1px solid #000;}
	table.bordered td, table.bordered th{padding:10px}
	.mt-1{margin-top:1em}
	.mt-2{margin-top:2em}
	.p-1{padding:1em}
    .border{border:1px solid #000}
    .w-100{width:100%}
	.fw-bold{font-weight:bold}
</style>