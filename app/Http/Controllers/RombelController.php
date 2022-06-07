<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;

class RombelController extends Controller
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

        // Mengambil data rombel
        $rombel = Rombel::orderBy('nama','asc')->get();

        // View
        return view('admin/rombel/index', [
            'rombel' => $rombel
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

        // Mengambil data jurusan
        $jurusan = Jurusan::orderBy('nama','asc')->get();

        // View
        return view('admin/rombel/create', [
            'kelas' => $kelas,
            'jurusan' => $jurusan
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
            'jurusan' => 'required',
            'nama' => 'required|max:200',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan rombel
            $rombel = new Rombel;
            $rombel->kelas_id = $request->kelas;
            $rombel->jurusan_id = $request->jurusan;
            $rombel->nama = $request->nama;
            $rombel->save();

            // Redirect
            return redirect()->route('admin.rombel.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data rombel
        $rombel = Rombel::findOrFail($id);

        // Mengambil data kelas
        $kelas = Kelas::orderBy('nama','asc')->get();

        // Mengambil data jurusan
        $jurusan = Jurusan::orderBy('nama','asc')->get();

        // View
        return view('admin/rombel/edit', [
            'rombel' => $rombel,
            'kelas' => $kelas,
            'jurusan' => $jurusan,
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
            'jurusan' => 'required',
            'nama' => 'required|max:200',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data rombel
            $rombel = Rombel::find($request->id);
            $rombel->kelas_id = $request->kelas;
            $rombel->jurusan_id = $request->jurusan;
            $rombel->nama = $request->nama;
            $rombel->save();

            // Redirect
            return redirect()->route('admin.rombel.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data rombel
        $rombel = Rombel::find($request->id);

        // Menghapus data rombel
        $rombel->delete();

        // Redirect
        return redirect()->route('admin.rombel.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
