<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sekolah;

class SekolahController extends Controller
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

        // Mengambil data sekolah
        $sekolah = Sekolah::first();

        // View
        return view('admin/sekolah/index', [
            'sekolah' => $sekolah,
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
            'nama' => 'required|max:255',
            'no_telepon' => 'required',
            'alamat' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan sekolah
            $sekolah = Sekolah::first();
            if(!$sekolah) $sekolah = new Sekolah;
            $sekolah->nama = $request->nama;
            $sekolah->no_telepon = $request->no_telepon;
            $sekolah->alamat = $request->alamat;
            $sekolah->save();

            // Redirect
            return redirect()->route('admin.sekolah.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }
}
