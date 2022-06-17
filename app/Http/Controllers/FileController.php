<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\File as Berkas;
use App\Models\JenisFile;
use App\Models\Kelas;

class FileController extends Controller
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

        if(Auth::user()->role_id == role('guru')) {
            // Mengambil data guru mapel
            $guru_mapel = Auth::user()->guru->guru_mapel;

            // Mengambil data jenis file
            $jenis_file = JenisFile::findOrFail($request->query('id'));

            // Mengambil data file
            $file = Berkas::has('guru_mapel')->has('kelas')->where('jenisfile_id','=',$jenis_file->id)->where('ta_id','=',session()->get('taa'))->get();

            // View
            return view('admin/file/index', [
                'guru_mapel' => $guru_mapel,
                'jenis_file' => $jenis_file,
                'file' => $file
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);
        
        if(Auth::user()->role_id == role('guru')) {
            // Mengambil data guru mapel
            $guru_mapel = Auth::user()->guru->guru_mapel;

            // Mengambil data jenis file
            $jenis_file = JenisFile::findOrFail($request->query('id'));

            // Mengambil data kelas
            $kelas = Kelas::orderBy('nama','asc')->get();

            // View
            return view('admin/file/create', [
                'guru_mapel' => $guru_mapel,
                'jenis_file' => $jenis_file,
                'kelas' => $kelas,
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
            'guru_mapel' => 'required',
            'kelas' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan file
            $file = new Berkas;
            $file->gurumapel_id = $request->guru_mapel;
            $file->kelas_id = $request->kelas;
            $file->jenisfile_id = $request->jenis_file;
            $file->ta_id = session()->get('taa');
            $file->file = '';
            $file->save();

            // Redirect
            return redirect()->route('admin.file.index', ['id' => $request->jenis_file])->with(['message' => 'Berhasil menambah data.']);
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
        
        if(Auth::user()->role_id == role('guru')) {
            // Mengambil data guru mapel
            $guru_mapel = Auth::user()->guru->guru_mapel;

            // Mengambil data file
            $file = Berkas::has('jenis_file')->findOrFail($id);

            // Mengambil data kelas
            $kelas = Kelas::orderBy('nama','asc')->get();

            // View
            return view('admin/file/edit', [
                'guru_mapel' => $guru_mapel,
                'file' => $file,
                'kelas' => $kelas,
            ]);
        }
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
            'guru_mapel' => 'required',
            'kelas' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data file
            $file = Berkas::find($request->id);
            $file->gurumapel_id = $request->guru_mapel;
            $file->kelas_id = $request->kelas;
            $file->save();

            // Redirect
            return redirect()->route('admin.file.index', ['id' => $file->jenisfile_id])->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data file
        $file = Berkas::find($request->id);

        // Menghapus data file
        $file->delete();

        // Redirect
        return redirect()->route('admin.file.index', ['id' => $file->jenisfile_id])->with(['message' => 'Berhasil menghapus data.']);
    }
}
