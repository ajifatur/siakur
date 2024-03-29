<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTimeExt;
use App\Models\MutasiSiswa;
use App\Models\Siswa;

class MutasiSiswaController extends Controller
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

        // Mengambil data mutasi siswa
        $mutasi_siswa = MutasiSiswa::where('period_id','=',session('period'))->get();

        // View
        return view('admin/mutasi-siswa/index', [
            'mutasi_siswa' => $mutasi_siswa
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

        // Mengambil data siswa
        $siswa = Siswa::doesntHave('mutasi_siswa')->orderBy('nomor_identitas','asc')->get();

        // View
        return view('admin/mutasi-siswa/create', [
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
            'tujuan' => 'required',
            'tanggal' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan mutasi siswa
            $mutasi_siswa = new MutasiSiswa;
            $mutasi_siswa->period_id = session('period');
            $mutasi_siswa->siswa_id = $request->siswa;
            $mutasi_siswa->tujuan = $request->tujuan;
            $mutasi_siswa->tanggal = DateTimeExt::change($request->tanggal);
            $mutasi_siswa->save();

            // Redirect
            return redirect()->route('admin.mutasi-siswa.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data mutasi siswa
        $mutasi_siswa = MutasiSiswa::findOrFail($id);

        // Mengambil data siswa
        $siswa = Siswa::orderBy('nomor_identitas','asc')->get();

        // View
        return view('admin/mutasi-siswa/edit', [
            'mutasi_siswa' => $mutasi_siswa,
            'siswa' => $siswa,
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
            'siswa' => 'required',
            'tujuan' => 'required',
            'tanggal' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data mutasi siswa
            $mutasi_siswa = MutasiSiswa::find($request->id);
            $mutasi_siswa->siswa_id = $request->siswa;
            $mutasi_siswa->tujuan = $request->tujuan;
            $mutasi_siswa->tanggal = DateTimeExt::change($request->tanggal);
            $mutasi_siswa->save();

            // Redirect
            return redirect()->route('admin.mutasi-siswa.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data mutasi siswa
        $mutasi_siswa = MutasiSiswa::findOrFail($request->id);

        // Menghapus data mutasi siswa
        $mutasi_siswa->delete();

        // Redirect
        return redirect()->route('admin.mutasi-siswa.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
