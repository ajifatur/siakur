<?php

use App\Models\Nilai;
use App\Models\TahunAkademik;

if(!function_exists('tahun_akademik')) {
    function tahun_akademik() {
        $ta = TahunAkademik::where('status','=',1)->orderBy('tahun','desc')->orderBy('semester','desc')->first();
        return $ta ? $ta : null;
    }
}

if(!function_exists('tahun_akademik_all')) {
    function tahun_akademik_all() {
        $tahun_akademik = TahunAkademik::orderBy('status','desc')->get();
        return $tahun_akademik;
    }
}

if(!function_exists('nilai')) {
    function nilai($siswa, $guru_mapel, $jenis, $ulangan) {
        $nilai = Nilai::where('siswa_id','=',$siswa)->where('gurumapel_id','=',$guru_mapel)->where('jenis','=',$jenis)->where('ulangan','=',$ulangan)->where('ta_id','=',session()->get('taa'))->first();
        return $nilai ? $nilai->nilai : 0;
    }
}

if(!function_exists('total_nilai')) {
    function total_nilai($siswa, $guru_mapel, $jenis) {
        $array = ['UH 1', 'UH 2', 'UH 3', 'UTS', 'UAS'];
        $uh = 0;
        $uts = 0;
        $uas = 0;
        $count_uh = 0;
        foreach($array as $a) {
            if($a == 'UTS')
                $uts = nilai($siswa, $guru_mapel, $jenis, $a);
            elseif($a == 'UAS')
                $uas = nilai($siswa, $guru_mapel, $jenis, $a);
            else {
                $uh += nilai($siswa, $guru_mapel, $jenis, $a);
                $count_uh++;
            }
        }
        $total = (($uh / $count_uh) + $uts + $uas) / 3;
        return round($total,0);
    }
}

if(!function_exists('hari')) {
    function hari($num = 0) {
        $array = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        if($num != 0)
            return $array[$num-1];
        else
            return '';
    }
}