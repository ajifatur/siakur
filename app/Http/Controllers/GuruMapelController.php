<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\Mapel;

class GuruMapelController extends Controller
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

        // Mengambil data guru mapel
        $guru_mapel = GuruMapel::get();

        // View
        return view('admin/guru-mapel/index', [
            'guru_mapel' => $guru_mapel
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

        // Mengambil data mapel
        $mapel = Mapel::orderBy('nama','asc')->get();

        // Mengambil data guru
        $guru = Guru::orderBy('nama','asc')->get();

        // View
        return view('admin/guru-mapel/create', [
            'mapel' => $mapel,
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
            'mapel' => 'required',
            'guru' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan guru mapel
            $guru_mapel = new GuruMapel;
            $guru_mapel->mapel_id = $request->mapel;
            $guru_mapel->guru_id = $request->guru;
            $guru_mapel->ta_id = property_exists(tahun_akademik(), 'id') ? tahun_akademik()->id : 0;
            $guru_mapel->save();

            // Redirect
            return redirect()->route('admin.guru-mapel.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data guru mapel
        $guru_mapel = GuruMapel::findOrFail($id);

        // Mengambil data mapel
        $mapel = Mapel::orderBy('nama','asc')->get();

        // Mengambil data guru
        $guru = Guru::orderBy('nama','asc')->get();

        // View
        return view('admin/guru-mapel/edit', [
            'guru_mapel' => $guru_mapel,
            'mapel' => $mapel,
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
            'mapel' => 'required',
            'guru' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data guru mapel
            $guru_mapel = GuruMapel::find($request->id);
            $guru_mapel->mapel_id = $request->mapel;
            $guru_mapel->guru_id = $request->guru;
            $guru_mapel->save();

            // Redirect
            return redirect()->route('admin.guru-mapel.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data guru mapel
        $guru_mapel = GuruMapel::findOrFail($id);

        // Menghapus data guru mapel
        $guru_mapel->delete();

        // Redirect
        return redirect()->route('admin.guru-mapel.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
