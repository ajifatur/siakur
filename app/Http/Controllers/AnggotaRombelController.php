<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\AnggotaRombel;
use App\Models\Rombel;
use App\Models\Siswa;

class AnggotaRombelController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        // Mengambil data rombel
        $rombel = Rombel::findOrFail($id);

        // Mengambil data siswa
        $siswa = Siswa::orderBy('nomor_identitas','asc')->get();

        // View
        return view('admin/anggota-rombel/create', [
            'rombel' => $rombel,
            'siswa' => $siswa,
        ]);
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
            'siswa' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Mengambil no urut terakhir
            $ar = AnggotaRombel::where('rombel_id','=',$request->rombel)->where('ta_id','=',tahun_akademik()->id)->latest('no_urut')->first();

            // Simpan anggota rombel
            $anggota_rombel = new AnggotaRombel;
            $anggota_rombel->rombel_id = $request->rombel;
            $anggota_rombel->siswa_id = $request->siswa;
            $anggota_rombel->ta_id = tahun_akademik() != null ? tahun_akademik()->id : 0;
            $anggota_rombel->no_urut = $ar ? $ar->no_urut + 1 : 1;
            $anggota_rombel->save();

            // Redirect
            return redirect()->route('admin.rombel.detail', ['id' => $request->rombel])->with(['message' => 'Berhasil menambah data.']);
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
        
        // Mengambil data anggota rombel
        $anggota_rombel = AnggotaRombel::find($request->id);

        // Menghapus data anggota rombel
        $anggota_rombel->delete();

        // Redirect
        return redirect()->route('admin.rombel.detail', ['id' => $anggota_rombel->rombel_id])->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Sort the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $anggota_rombel = AnggotaRombel::find($id);
                if($anggota_rombel) {
                    $anggota_rombel->no_urut = $key + 1;
                    $anggota_rombel->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Terjadi kesalahan dalam mengurutkan data.';
    }
}
