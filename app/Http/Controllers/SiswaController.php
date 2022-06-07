<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTimeExt;
use App\Models\Siswa;

class SiswaController extends Controller
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

        // Mengambil data siswa
        $siswa = Siswa::orderBy('nama','asc')->get();

        // View
        return view('admin/siswa/index', [
            'siswa' => $siswa
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

        // View
        return view('admin/siswa/create');
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
            'nama' => 'required|max:200',
            'nomor_identitas' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan siswa
            $siswa = new Siswa;
            $siswa->nama = $request->nama;
            $siswa->nomor_identitas = $request->nomor_identitas;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->tanggal_lahir = DateTimeExt::change($request->tanggal_lahir);
            $siswa->nomor_telepon = $request->nomor_telepon;
            $siswa->alamat = $request->alamat;
            $siswa->save();

            // Redirect
            return redirect()->route('admin.siswa.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data siswa
        $siswa = Siswa::findOrFail($id);

        // View
        return view('admin/siswa/edit', [
            'siswa' => $siswa
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
            'nama' => 'required|max:200',
            'nomor_identitas' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data siswa
            $siswa = Siswa::find($request->id);
            $siswa->nama = $request->nama;
            $siswa->nomor_identitas = $request->nomor_identitas;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->tanggal_lahir = DateTimeExt::change($request->tanggal_lahir);
            $siswa->nomor_telepon = $request->nomor_telepon;
            $siswa->alamat = $request->alamat;
            $siswa->save();

            // Redirect
            return redirect()->route('admin.siswa.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data siswa
        $siswa = Siswa::find($request->id);

        // Menghapus data siswa
        $siswa->delete();

        // Redirect
        return redirect()->route('admin.siswa.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
