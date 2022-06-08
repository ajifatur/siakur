<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Guru;
use App\Models\Rombel;
use App\Models\WaliKelas;

class WaliKelasController extends Controller
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

        // Mengambil data wali kelas
        $wali_kelas = WaliKelas::where('ta_id','=',session()->get('taa'))->get();

        // View
        return view('admin/wali-kelas/index', [
            'wali_kelas' => $wali_kelas
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

        // Mengambil data rombel
        $rombel = Rombel::orderBy('nama','asc')->get();

        // Mengambil data guru
        $guru = Guru::orderBy('nama','asc')->get();

        // View
        return view('admin/wali-kelas/create', [
            'rombel' => $rombel,
            'guru' => $guru
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
            'rombel' => 'required',
            'guru' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan wali kelas
            $wali_kelas = new WaliKelas;
            $wali_kelas->rombel_id = $request->rombel;
            $wali_kelas->guru_id = $request->guru;
            $wali_kelas->ta_id = tahun_akademik() != null ? tahun_akademik()->id : 0;
            $wali_kelas->save();

            // Redirect
            return redirect()->route('admin.wali-kelas.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data wali kelas
        $wali_kelas = WaliKelas::findOrFail($id);

        // Mengambil data rombel
        $rombel = Rombel::orderBy('nama','asc')->get();

        // Mengambil data guru
        $guru = Guru::orderBy('nama','asc')->get();

        // View
        return view('admin/wali-kelas/edit', [
            'wali_kelas' => $wali_kelas,
            'rombel' => $rombel,
            'guru' => $guru
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
            'rombel' => 'required',
            'guru' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data wali kelas
            $wali_kelas = WaliKelas::find($request->id);
            $wali_kelas->rombel_id = $request->rombel;
            $wali_kelas->guru_id = $request->guru;
            $wali_kelas->save();

            // Redirect
            return redirect()->route('admin.wali-kelas.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data wali kelas
        $wali_kelas = WaliKelas::findOrFail($request->id);

        // Menghapus data wali kelas
        $wali_kelas->delete();

        // Redirect
        return redirect()->route('admin.wali-kelas.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
