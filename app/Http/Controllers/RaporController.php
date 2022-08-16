<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTimeExt;
use App\Models\AnggotaRombel;
use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Rapor;
use App\Models\TahunAkademik;
use App\Models\WaliKelas;
use \PDF;

class RaporController extends Controller
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

        if(Auth::user()->role_id == role('guru') && Auth::user()->guru && Auth::user()->guru->wali_kelas->where('ta_id','=',tahun_akademik()->id)->count() > 0) {
            // Mengambil data wali kelas
            $wali_kelas = Auth::user()->guru->wali_kelas()->has('rombel')->where('ta_id','=',session()->get('taa'))->first();

            // Mengambil data anggota rombel
            $anggota_rombel = $wali_kelas ? AnggotaRombel::where('rombel_id','=',$wali_kelas->rombel_id)->where('ta_id','=',session()->get('taa'))->orderby('no_urut','asc')->get() : [];

            // View
            return view('admin/rapor/index', [
                'wali_kelas' => $wali_kelas,
                'anggota_rombel' => $anggota_rombel,
            ]);
        }
        elseif(Auth::user()->role_id == role('siswa')){
            // Mengambil data wali kelas
            $wali_kelas = WaliKelas::has('rombel')->where('ta_id','=',session()->get('taa'))->firstOrFail();

            // Mengambil data anggota rombel
            $anggota_rombel = $wali_kelas ? AnggotaRombel::has('rombel')->has('siswa')->where('rombel_id','=',$wali_kelas->rombel_id)->where('siswa_id','=',Auth::user()->siswa->id)->where('ta_id','=',session()->get('taa'))->first() : null;

            // Mengambil data rapor
            $rapor = $anggota_rombel != null ? Rapor::where('siswa_id','=',Auth::user()->siswa->id)->where('rombel_id','=',$anggota_rombel->rombel_id)->where('ta_id','=',session()->get('taa'))->first() : null;

            // Mengambil data tahun akademik
            $tahun_akademik = TahunAkademik::findOrFail(session()->get('taa'));

            // Mengambil data jadwal
            $jadwal = $wali_kelas ? Jadwal::has('rombel')->has('guru_mapel')->where('rombel_id','=',$wali_kelas->rombel_id)->where('ta_id','=',session()->get('taa'))->groupBy('gurumapel_id')->get() : [];

            // Mengambil ID mapel
            $ids = [];
            foreach($jadwal as $j) {
                array_push($ids, $j->guru_mapel->mapel_id);
            }

            // Mengambil data mata pelajaran
            $mapel = Mapel::whereIn('id',$ids)->orderBy('num_order')->get();
            $jgm = $jadwal->pluck('gurumapel_id')->toArray();
            foreach($mapel as $key=>$m) {
                $gm = $m->guru_mapel()->where('ta_id','=',session()->get('taa'))->pluck('id')->toArray();
                $mapel[$key]->gm = array_intersect($gm, $jgm);
            }

            // View
            return view('admin/rapor/index-siswa', [
                'wali_kelas' => $wali_kelas,
                'anggota_rombel' => $anggota_rombel,
                'rapor' => $rapor,
                'tahun_akademik' => $tahun_akademik,
                'mapel' => $mapel,
            ]);
        }
        else abort(403);
    }

    /**
     * Print PDF.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cetak_pdf($id)
    {
        // Mengambil data wali kelas
        $wali_kelas = Auth::user()->guru->wali_kelas()->has('rombel')->where('ta_id','=',session()->get('taa'))->firstOrFail();

        // Mengambil data anggota rombel
        $anggota_rombel = $wali_kelas ? AnggotaRombel::has('rombel')->has('siswa')->where('rombel_id','=',$wali_kelas->rombel_id)->where('siswa_id','=',$id)->where('ta_id','=',session()->get('taa'))->first() : null;

        // Mengambil data rapor
        $rapor = $anggota_rombel != null ? Rapor::where('siswa_id','=',$anggota_rombel->siswa_id)->where('rombel_id','=',$anggota_rombel->rombel_id)->where('ta_id','=',session()->get('taa'))->first() : null;
     
        $pdf = PDF::loadview('admin/rapor/cetak-rapor', ['rapor'=>$rapor])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('rapor.pdf');
    }

    /**
     * Show the detail from the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        if(Auth::user()->role_id == role('guru')) {
            // Mengambil data wali kelas
            $wali_kelas = Auth::user()->guru->wali_kelas()->has('rombel')->where('ta_id','=',session()->get('taa'))->firstOrFail();

            // Mengambil data anggota rombel
            $anggota_rombel = $wali_kelas ? AnggotaRombel::has('rombel')->has('siswa')->where('rombel_id','=',$wali_kelas->rombel_id)->where('siswa_id','=',$id)->where('ta_id','=',session()->get('taa'))->first() : null;

            // Mengambil data rapor
            $rapor = $anggota_rombel != null ? Rapor::where('siswa_id','=',$anggota_rombel->siswa_id)->where('rombel_id','=',$anggota_rombel->rombel_id)->where('ta_id','=',session()->get('taa'))->first() : null;

            // Mengambil data tahun akademik
            $tahun_akademik = TahunAkademik::findOrFail(session()->get('taa'));

            // Mengambil data jadwal
            $jadwal = $wali_kelas ? Jadwal::has('rombel')->has('guru_mapel')->where('rombel_id','=',$wali_kelas->rombel_id)->where('ta_id','=',session()->get('taa'))->groupBy('gurumapel_id')->get() : [];

            // Mengambil ID mapel
            $ids = [];
            foreach($jadwal as $j) {
                array_push($ids, $j->guru_mapel->mapel_id);
            }

            // Mengambil data mata pelajaran
            $mapel = Mapel::whereIn('id',$ids)->orderBy('num_order')->get();
            $jgm = $jadwal->pluck('gurumapel_id')->toArray();
            foreach($mapel as $key=>$m) {
                $gm = $m->guru_mapel()->where('ta_id','=',session()->get('taa'))->pluck('id')->toArray();
                $mapel[$key]->gm = array_intersect($gm, $jgm);
            }

            // View
            return view('admin/rapor/detail', [
                'wali_kelas' => $wali_kelas,
                'anggota_rombel' => $anggota_rombel,
                'rapor' => $rapor,
                'tahun_akademik' => $tahun_akademik,
                'mapel' => $mapel,
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
        // Validation
        $validator = Validator::make($request->all(), [
            'sikap_spiritual_predikat' => 'required',
            'sikap_spiritual_deskripsi' => 'required',
            'sikap_sosial_predikat' => 'required',
            'sikap_sosial_deskripsi' => 'required',
            'status' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan rapor
            $rapor = Rapor::where('siswa_id','=',$request->siswa_id)->where('rombel_id','=',$request->rombel_id)->where('ta_id','=',session()->get('taa'))->first();
            if(!$rapor) $rapor = new Rapor;
            $rapor->siswa_id = $request->siswa_id;
            $rapor->rombel_id = $request->rombel_id;
            $rapor->ta_id = session()->get('taa');
            $rapor->sikap_spiritual_predikat = $request->sikap_spiritual_predikat;
            $rapor->sikap_spiritual_deskripsi = $request->sikap_spiritual_deskripsi;
            $rapor->sikap_sosial_predikat = $request->sikap_sosial_predikat;
            $rapor->sikap_sosial_deskripsi = $request->sikap_sosial_deskripsi;
            $rapor->status = $request->status;
            $rapor->save();

            // Redirect
            return redirect()->route('admin.rapor.detail', ['id' => $request->siswa_id])->with(['message' => 'Berhasil mengupdate data.']);
        }
    }
}
