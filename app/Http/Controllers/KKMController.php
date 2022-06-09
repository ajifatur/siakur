<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Kelas;
use App\Models\KKM;
use App\Models\Mapel;

class KKMController extends Controller
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

        // Mengambil data KKM
        $kkm = KKM::where('ta_id','=',session()->get('taa'))->get();

        // View
        return view('admin/kkm/index', [
            'kkm' => $kkm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        // Mengambil data kelas
        $kelas = Kelas::orderBy('nama','asc')->get();

        // Mengambil data mapel
        $mapel = Mapel::orderBy('nama','asc')->get();

        // View
        return view('admin/kkm/create', [
            'kelas' => $kelas,
            'mapel' => $mapel,
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
            'kelas' => 'required',
            'mapel' => 'required',
            'jenis' => 'required',
            'kkm' => 'required',
            'deskripsi_a' => 'required',
            'deskripsi_b' => 'required',
            'deskripsi_c' => 'required',
            'deskripsi_d' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan KKM
            $kkm = new KKM;
            $kkm->kelas_id = $request->kelas;
            $kkm->mapel_id = $request->mapel;
            $kkm->jenis = $request->jenis;
            $kkm->kkm = $request->kkm;
            $kkm->deskripsi_a = $request->deskripsi_a;
            $kkm->deskripsi_b = $request->deskripsi_b;
            $kkm->deskripsi_c = $request->deskripsi_c;
            $kkm->deskripsi_d = $request->deskripsi_d;
            $kkm->ta_id = tahun_akademik() != null ? tahun_akademik()->id : 0;
            $kkm->save();

            // Redirect
            return redirect()->route('admin.kkm.index')->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        // Mengambil data KKM
        $kkm = KKM::findOrFail($id);

        // Mengambil data kelas
        $kelas = Kelas::orderBy('nama','asc')->get();

        // Mengambil data mapel
        $mapel = Mapel::orderBy('nama','asc')->get();

        // View
        return view('admin/kkm/edit', [
            'kkm' => $kkm,
            'kelas' => $kelas,
            'mapel' => $mapel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'kelas' => 'required',
            'mapel' => 'required',
            'jenis' => 'required',
            'kkm' => 'required',
            'deskripsi_a' => 'required',
            'deskripsi_b' => 'required',
            'deskripsi_c' => 'required',
            'deskripsi_d' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data KKM
            $kkm = KKM::find($request->id);
            $kkm->kelas_id = $request->kelas;
            $kkm->mapel_id = $request->mapel;
            $kkm->jenis = $request->jenis;
            $kkm->kkm = $request->kkm;
            $kkm->deskripsi_a = $request->deskripsi_a;
            $kkm->deskripsi_b = $request->deskripsi_b;
            $kkm->deskripsi_c = $request->deskripsi_c;
            $kkm->deskripsi_d = $request->deskripsi_d;
            $kkm->save();

            // Redirect
            return redirect()->route('admin.kkm.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data KKM
        $kkm = KKM::find($request->id);

        // Menghapus data KKM
        $kkm->delete();

        // Redirect
        return redirect()->route('admin.kkm.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
