<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\GuruMapel;
use App\Models\AnggotaRombel;
use App\Models\Jadwal;
use App\Models\JP;
use App\Models\Rombel;
use App\Models\TahunAkademik;

class JadwalController extends Controller
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

        // Mengambil data jam pelajaran
        $jp = JP::orderBy('jam_mulai','asc')->get();

        // Mengambil data rombel
        $rombel = Rombel::orderBy('nama','asc')->get();

        // Mengambil data anggota rombel
        $anggota_rombel = AnggotaRombel::has('rombel')->has('siswa')->where('siswa_id','=','2')->where('ta_id','=',tahun_akademik()->id)->first();

        // Mengambil data guru mapel
        $guru_mapel = GuruMapel::orderBy('mapel_id','asc')->get();

        if(Auth::user()->role_id == role('super-admin') || (Auth::user()->guru && Auth::user()->guru->waka_kurikulum->where('ta_id','=',tahun_akademik()->id)->count() > 0)) {
            // View
            return view('admin/jadwal/index', [
                'jp' => $jp,
                'rombel' => $rombel,
                'guru_mapel' => $guru_mapel,
            ]);
        }
        elseif(Auth::user()->role_id == role('guru') && Auth::user()->guru->waka_kurikulum->where('ta_id','=',tahun_akademik()->id)->count() <= 0) {
            // Mengambil data guru mapel
            $guru_mapel_ids = Auth::user()->guru->guru_mapel->pluck('id')->toArray();

            // View
            return view('admin/jadwal/index-teacher', [
                'jp' => $jp,
                'rombel' => $rombel,
                'guru_mapel' => $guru_mapel,
                'guru_mapel_ids' => $guru_mapel_ids,
            ]);
        }
        elseif(Auth::user()->role_id == role('siswa')) {

            // View
            return view('admin/jadwal/index-siswa', [
                'jp' => $jp,
                'rombel' => $rombel,
                'guru_mapel' => $guru_mapel,
                'anggota_rombel' => $anggota_rombel,
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
            'hari' => 'required',
            'jam' => 'required',
            'rombel' => 'required',
            'mapel' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan jadwal
            if($request->type == 'create')
                $jadwal = new Jadwal;
            elseif($request->type == 'update')
                $jadwal = Jadwal::findOrFail($request->id);

            $jadwal->hari = $request->hari;
            $jadwal->jp_id = $request->jam;
            $jadwal->rombel_id = $request->rombel;
            $jadwal->gurumapel_id = $request->mapel;
            $jadwal->ta_id = tahun_akademik() != null ? tahun_akademik()->id : 0;
            $jadwal->save();

            // Redirect
            if($request->type == 'create')
                return redirect()->route('admin.jadwal.index')->with(['message' => 'Berhasil menambah data.']);
            elseif($request->type == 'update')
                return redirect()->route('admin.jadwal.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);
        
        // Mengambil data jadwal
        $jadwal = Jadwal::findOrFail($request->id);

        // Menghapus data jadwal
        $jadwal->delete();

        // Redirect
        return redirect()->route('admin.jadwal.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
