<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTimeExt;
use App\Models\AnggotaRombel;
use App\Models\GuruMapel;
use App\Models\Jadwal;
use App\Models\KKM;
use App\Models\Nilai;
use App\Models\Rombel;
use App\Models\User;
use App\Models\Siswa;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        if(Auth::user()->role_id == role('guru') && Auth::user()->guru && Auth::user()->guru->guru_mapel->where('ta_id','=',tahun_akademik()->id)->count() > 0) {
            // Mengambil data guru mapel
            $guru_mapel = Auth::user()->guru->guru_mapel;

            // Mengambil data jadwal
            $jadwal = Jadwal::has('rombel')->whereIn('gurumapel_id',$guru_mapel->pluck('id')->toArray())->where('ta_id','=',session()->get('taa'))->groupBy('rombel_id')->get();

            // View
            return view('admin/nilai/index', [
                'guru_mapel' => $guru_mapel,
                'jadwal' => $jadwal,
            ]);
        }
        elseif(Auth::user()->role_id == role('siswa')){
            // Mengambil data anggota rombel
            $anggota_rombel = AnggotaRombel::has('rombel')->has('siswa')->where('siswa_id','=',Auth::user()->siswa->id)->where('ta_id','=',tahun_akademik()->id)->first();

            // Mengambil data guru mapel
            $guru_mapel = GuruMapel::orderBy('mapel_id','asc')->get();

            // Mengambil data jadwal
            $jadwal = Jadwal::has('rombel')->where('rombel_id','=',$anggota_rombel->rombel_id)->where('ta_id','=',session()->get('taa'))->groupBy('gurumapel_id')->get();

            // View
            return view('admin/nilai/index-siswa', [
                'anggota_rombel' => $anggota_rombel,
                'guru_mapel' => $guru_mapel,
                'jadwal' => $jadwal,
            ]);
        }
        else abort(403);
    }

    public function set($gurumapel_id, $rombel_id)
    {
        if(Auth::user()->role_id == role('guru')) {
            if(!in_array($gurumapel_id, Auth::user()->guru->guru_mapel->pluck('id')->toArray()))
                abort(403);

            // Mengambil data guru mapel
            $guru_mapel = GuruMapel::has('mapel')->findOrFail($gurumapel_id);

            // Mengambil data rombel
            $rombel = Rombel::findOrFail($rombel_id);

            // Mengambil data anggota rombel
            $anggota_rombel = AnggotaRombel::where('rombel_id','=',$rombel->id)->where('ta_id','=',session()->get('taa'))->orderby('no_urut','asc')->get();

            // KKM pengetahuan
            $kkm_p = KKM::where('kelas_id','=',$rombel->kelas_id)->where('mapel_id','=',$guru_mapel->mapel_id)->where('jenis','=',1)->where('ta_id','=',session()->get('taa'))->first();

            // KKM keterampilan
            $kkm_k = KKM::where('kelas_id','=',$rombel->kelas_id)->where('mapel_id','=',$guru_mapel->mapel_id)->where('jenis','=',2)->where('ta_id','=',session()->get('taa'))->first();

            // Array ulangan
            $ulangan = ['UH 1', 'UH 2', 'UH 3', 'UTS', 'UAS'];

            // View
            return view('admin/nilai/set', [
                'guru_mapel' => $guru_mapel,
                'rombel' => $rombel,
                'anggota_rombel' => $anggota_rombel,
                'ulangan' => $ulangan,
                'kkm_p' => $kkm_p,
                'kkm_k' => $kkm_k,
            ]);
        }
    }

    public function detail($gurumapel_id, $rombel_id)
    {
        if(Auth::user()->role_id == role('siswa')) {
            // Mengambil data guru mapel
            $guru_mapel = GuruMapel::has('mapel')->findOrFail($gurumapel_id);

            // Mengambil data rombel
            $rombel = Rombel::findOrFail($rombel_id);

            // Mengambil data anggota rombel
            $anggota_rombel = AnggotaRombel::where('rombel_id','=',$rombel->id)->where('siswa_id','=',Auth::user()->siswa->id)->where('ta_id','=',session()->get('taa'))->orderby('no_urut','asc')->get();

            // KKM pengetahuan
            $kkm_p = KKM::where('kelas_id','=',$rombel->kelas_id)->where('mapel_id','=',$guru_mapel->mapel_id)->where('jenis','=',1)->where('ta_id','=',session()->get('taa'))->first();

            // KKM keterampilan
            $kkm_k = KKM::where('kelas_id','=',$rombel->kelas_id)->where('mapel_id','=',$guru_mapel->mapel_id)->where('jenis','=',2)->where('ta_id','=',session()->get('taa'))->first();

            // Array ulangan
            $ulangan = ['UH 1', 'UH 2', 'UH 3', 'UTS', 'UAS'];

            // View
            return view('admin/nilai/detail-siswa', [
                'guru_mapel' => $guru_mapel,
                'rombel' => $rombel,
                'anggota_rombel' => $anggota_rombel,
                'ulangan' => $ulangan,
                'kkm_p' => $kkm_p,
                'kkm_k' => $kkm_k,
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Mengambil nilai
        $nilai = Nilai::where('siswa_id','=',$request->siswa)->where('gurumapel_id','=',$request->gurumapel)->where('jenis','=',$request->jenis)->where('ulangan','=',$request->ulangan)->where('ta_id','=',session()->get('taa'))->first();

        // Simpan nilai
        if(!$nilai) $nilai = new Nilai;
        $nilai->siswa_id = $request->siswa;
        $nilai->gurumapel_id = $request->gurumapel;
        $nilai->ta_id = session()->get('taa');
        $nilai->jenis = $request->jenis;
        $nilai->ulangan = $request->ulangan;
        $nilai->nilai = $request->nilai;
        $nilai->save();

        // Return
        return response()->json([
            'nilai' => $nilai->nilai,
            'total' => total_nilai($request->siswa, $request->gurumapel, $request->jenis)
        ]);
    }
}
