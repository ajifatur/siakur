<?php

use App\Models\TahunAkademik;

if(!function_exists('tahun_akademik')) {
    function tahun_akademik() {
        $ta = TahunAkademik::where('status','=',1)->orderBy('tahun','desc')->orderBy('semester','desc')->first();
        return $ta ? $ta : null;
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