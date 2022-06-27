<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Guru;
use App\Models\WakaKurikulum;

class WakaKurikulumController extends Controller
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

        // Mengambil data waka kurikulum
        $waka_kurikulum = WakaKurikulum::where('ta_id','=',session()->get('taa'))->get();

        // View
        return view('admin/waka-kurikulum/index', [
            'waka_kurikulum' => $waka_kurikulum
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

        // Mengambil data guru
        $guru = Guru::orderBy('nama','asc')->get();

        // View
        return view('admin/waka-kurikulum/create', [
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
            'guru' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Cek waka kurikulum
            $cek = WakaKurikulum::where('guru_id','=',$request->guru)->where('ta_id','=',tahun_akademik()->id)->first();
            if($cek) {
                // Redirect
                return redirect()->back()->with(['message' => 'Sudah ada data!']);
            }

            // Simpan waka kurikulum
            $waka_kurikulum = new WakaKurikulum;
            $waka_kurikulum->guru_id = $request->guru;
            $waka_kurikulum->ta_id = tahun_akademik() != null ? tahun_akademik()->id : 0;
            $waka_kurikulum->save();

            // Redirect
            return redirect()->route('admin.waka-kurikulum.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data waka kurikulum
        $waka_kurikulum = WakaKurikulum::findOrFail($id);

        // Mengambil data guru
        $guru = Guru::orderBy('nama','asc')->get();

        // View
        return view('admin/waka-kurikulum/edit', [
            'waka_kurikulum' => $waka_kurikulum,
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
            'guru' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Cek waka kurikulum
            $cek = WakaKurikulum::where('guru_id','=',$request->guru)->where('ta_id','=',tahun_akademik()->id)->where('id','!=',$request->id)->first();
            if($cek) {
                // Redirect
                return redirect()->back()->with(['message' => 'Sudah ada data!']);
            }

            // Update data waka kurikulum
            $waka_kurikulum = WakaKurikulum::find($request->id);
            $waka_kurikulum->guru_id = $request->guru;
            $waka_kurikulum->save();

            // Redirect
            return redirect()->route('admin.waka-kurikulum.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data waka kurikulum
        $waka_kurikulum = WakaKurikulum::findOrFail($request->id);

        // Menghapus data waka kurikulum
        $waka_kurikulum->delete();

        // Redirect
        return redirect()->route('admin.waka-kurikulum.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
